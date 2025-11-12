<?php
declare(strict_types=1);

require_once 'auth.php';
require_once 'RegistryHandler.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $handler = new RegistryHandler($db);
    
    $success = $handler->store($_POST, $_FILES);
    
    echo json_encode([
        'success' => $success,
        'message' => $success ? 'Registry submitted successfully' : 'Submission failed'
    ]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
