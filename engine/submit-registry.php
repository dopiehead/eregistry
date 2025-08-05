<?php
// Configuration
$uploadDir = "uploads/";
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'];
$maxFileSize = 5 * 1024 * 1024; // 5MB

$response = [
    "success" => false,
    "message" => "",
    "uploaded" => []
];

// Ensure uploads directory exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Process form if POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Example: Access other form fields
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';

    // File handling
    if (!empty($_FILES['files']['name'][0])) {
        foreach ($_FILES['files']['name'] as $index => $fileName) {
            $tmpName = $_FILES['files']['tmp_name'][$index];
            $fileSize = $_FILES['files']['size'][$index];
            $fileError = $_FILES['files']['error'][$index];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if ($fileError !== UPLOAD_ERR_OK) {
                $response['message'] .= "Error uploading $fileName.<br>";
                continue;
            }

            if (!in_array($fileExt, $allowedExtensions)) {
                $response['message'] .= "$fileName: File type not allowed.<br>";
                continue;
            }

            if ($fileSize > $maxFileSize) {
                $response['message'] .= "$fileName: File too large.<br>";
                continue;
            }

            $newName = uniqid() . '.' . $fileExt;
            $targetFile = $uploadDir . $newName;

            if (move_uploaded_file($tmpName, $targetFile)) {
                $response['uploaded'][] = $newName;
            } else {
                $response['message'] .= "$fileName: Failed to save file.<br>";
            }
        }
    } else {
        $response['message'] = "No files uploaded.";
    }

    if (count($response['uploaded']) > 0) {
        $response['success'] = true;
        $response['message'] = "Form submitted and files uploaded.";
    }
} else {
    $response['message'] = "Invalid request.";
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
