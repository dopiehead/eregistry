
<?php session_start();

require_once 'auth.php';

require_once '../vendor/autoload.php';

$auth = new Auth( new Database());

if (!$auth->isLoggedIn()) {
    header('Location: ../getstarted.php');
    exit;
}

else{
    include("contents/userDetails.php");
}

$conn = $auth->getConnection();

use Cloudinary\Cloudinary;

// Validate session and determine user type
$userType = null;
$userId = null;
$imageColumn = null;
$table = null;

if (!empty($_SESSION['u_id'])) {
    $userId = $_SESSION['u_id'];
    $table = 'user_profile';
    $imageColumn = 'image';
    $folder = 'uploads/users/';
} 

// Cloudinary configuration
try {
    $cloudinary = new Cloudinary([
        'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'],
        'api_key'    => $_ENV['CLOUDINARY_API_KEY'],
        'api_secret' => $_ENV['CLOUDINARY_API_SECRET'],
        'secure'     => true
    ]);
} catch (Exception $e) {
    exit("Cloudinary configuration failed: " . $e->getMessage());
}

// Validate uploaded file
if (!isset($_FILES['fileupload']) || $_FILES['fileupload']['error'] !== UPLOAD_ERR_OK) {
    exit("No file uploaded or upload error.");
}

$file = $_FILES['fileupload'];
$basename = basename($file['name']);
$extension = strtolower(pathinfo($basename, PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png'];
$maxSize = 4 * 1024 * 1024;

if (!in_array($extension, $allowed)) {
    exit("Please upload a valid image (JPG, JPEG, PNG).");
}

if ($file['size'] > $maxSize) {
    exit("Image file size exceeds the 4MB limit.");
}

// Upload to Cloudinary
try {
    $upload = $cloudinary->uploadApi()->upload($file['tmp_name'], [
        'folder' => $folder,
        'public_id' => 'profile_' . uniqid(),
        'overwrite' => true,
        'resource_type' => 'image'
    ]);
    $imageUrl = $upload['secure_url'] ?? null;
    if (!$imageUrl) {
        exit("Upload failed. No URL returned.");
    }
} catch (Exception $e) {
    exit("Cloudinary upload error: " . $e->getMessage());
}

// Update user record using prepared statement
$id = $_POST['id'];

$stmt = $conn->prepare("UPDATE $table SET $imageColumn = ? WHERE id = ?");
$stmt->bind_param("si", $imageUrl, $id);

if ($stmt->execute()) {
    if ($userType === 'buyer') {
        $_SESSION['image'] = $imageUrl;
    } else {
        $_SESSION['business_image'] = $imageUrl;
    }
    echo "1";
} else {
    echo "Error updating profile image.";
}

$stmt->close();
$conn->close();
?>
