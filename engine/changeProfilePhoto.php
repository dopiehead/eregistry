<?php
session_start();
header('Content-Type: application/json');

require_once 'auth.php';
require_once '../vendor/autoload.php';

use Cloudinary\Cloudinary;

$auth = new Auth(new Database());
if (!$auth->isLoggedIn()) {
    echo json_encode(["success" => false, "message" => "Not authenticated."]);
    exit;
}

$conn = $auth->getConnection();

// Validate session user
$userId = $_SESSION['u_id'] ?? null;

if (!$userId) {
    echo json_encode(["success" => false, "message" => "Invalid session."]);
    exit;
}

$table = 'user_profile';
$imageColumn = 'image';
$cloudFolder = 'eregistry/users'; // Cloudinary folder

// Cloudinary setup
try {
    $cloudinary = new Cloudinary([
        'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'],
        'api_key'    => $_ENV['CLOUDINARY_API_KEY'],
        'api_secret' => $_ENV['CLOUDINARY_API_SECRET'],
        'secure'     => true
    ]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Cloudinary config failed: " . $e->getMessage()]);
    exit;
}

// Validate uploaded file
if (!isset($_FILES['fileupload']) || $_FILES['fileupload']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(["success" => false, "message" => "No file uploaded or upload error."]);
    exit;
}

$file = $_FILES['fileupload'];
$basename = basename($file['name']);
$extension = strtolower(pathinfo($basename, PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png'];
$maxSize = 4 * 1024 * 1024;

if (!in_array($extension, $allowed)) {
    echo json_encode(["success" => false, "message" => "Invalid file type. Use JPG, JPEG, or PNG."]);
    exit;
}

if ($file['size'] > $maxSize) {
    echo json_encode(["success" => false, "message" => "Image exceeds 4MB size limit."]);
    exit;
}

// Upload to Cloudinary
try {
    $upload = $cloudinary->uploadApi()->upload($file['tmp_name'], [
        'folder' => $cloudFolder,
        'public_id' => 'profile_' . uniqid(),
        'overwrite' => true,
        'resource_type' => 'image'
    ]);
    $imageUrl = $upload['secure_url'] ?? null;
    if (!$imageUrl) {
        echo json_encode(["success" => false, "message" => "Image upload failed."]);
        exit;
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Upload error: " . $e->getMessage()]);
    exit;
}


// Update DB
$stmt = $conn->prepare("UPDATE $table SET $imageColumn = ? WHERE id = ?");
$stmt->bind_param("si", $imageUrl, $userId);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Profile image updated successfully!", "image" => $imageUrl]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update profile image in database."]);
}

$stmt->close();
$conn->close();
?>
