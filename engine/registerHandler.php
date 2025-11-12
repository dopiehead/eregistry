<?php
session_start();
header('Content-Type: application/json');

require_once 'auth.php';
require_once '../vendor/autoload.php';

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

$auth = new Auth(new Database());
$conn = $auth->getConnection();

// Configure Cloudinary
Configuration::instance([
    'cloud' => [
       'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'],
        'api_key'    => $_ENV['CLOUDINARY_API_KEY'],
        'api_secret' => $_ENV['CLOUDINARY_API_SECRET'],
    ],
    'url' => ['secure' => true]
]);

$cloudinary = new Cloudinary();

class RegistryHandler {
    private mysqli $conn;
    private Cloudinary $cloudinary;

    public function __construct(mysqli $conn, Cloudinary $cloudinary) {
        $this->conn = $conn;
        $this->cloudinary = $cloudinary;
    }

    public function store(array $data, array $files): bool {
        $category = $data['category'] ?? '';
        $other_category = $data['other_category'] ?? '';
        $name = $data['registry_name'] ?? '';
        $desc = $data['registry_description'] ?? '';
        $imagePath = null;

        // Upload first file to Cloudinary if available
        if (!empty($files['files']['tmp_name'][0])) {
            $tmp = $files['files']['tmp_name'][0];
            $originalName = basename($files['files']['name'][0]);

            try {
                $upload = $this->cloudinary->uploadApi()->upload($tmp, [
                    'folder' => 'eregistry/registries/',
                    'public_id' => pathinfo($originalName, PATHINFO_FILENAME) . '_' . time(),
                    'overwrite' => true,
                    'resource_type' => 'auto'
                ]);

                $imagePath = $upload['secure_url'];
            } catch (Exception $e) {
                error_log('Cloudinary Upload Error: ' . $e->getMessage());
                return false;
            }
        }

        // Insert into registries table
        $stmt = $this->conn->prepare("
            INSERT INTO registries (category, other_category, registry_name, registry_description, imagePath)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->bind_param("sssss", $category, $other_category, $name, $desc, $imagePath);

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }
}

// Use the handler
$handler = new RegistryHandler($conn, $cloudinary);
$response = ['success' => $handler->store($_POST, $_FILES)];

echo json_encode($response);
