<?php

declare(strict_types=1);

require_once 'auth.php';

header('Content-Type: application/json');

$auth = new Auth(new Database());

// Sanitize and validate POST input
$sender_email = filter_var($_POST['sentby'] ?? '', FILTER_VALIDATE_EMAIL);
$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
$compose = htmlspecialchars(trim($_POST['message'] ?? ''));
$receiver_email = filter_var($_POST['sentto'] ?? '', FILTER_VALIDATE_EMAIL);

// Default message meta values
$has_read = 0;
$is_receiver_deleted = 0;
$is_sender_deleted = 0;
$date = date('Y-m-d H:i:s');

// Validation
if (!$sender_email || !$receiver_email) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid sender or receiver email."
    ]);
    exit;
}

if (empty($subject)) {
    echo json_encode([
        "status" => "error",
        "message" => "Subject field is required."
    ]);
    exit;
}

if (empty($compose)) {
    echo json_encode([
        "status" => "error",
        "message" => "Message field cannot be empty."
    ]);
    exit;
}

// Call Auth method to insert message
if ($auth->sendMessage(
    sender_email: $sender_email,
    name: $name,
    subject: $subject,
    compose: $compose,
    receiver_email: $receiver_email,
    has_read: $has_read,
    is_receiver_deleted: $is_receiver_deleted,
    is_sender_deleted: $is_sender_deleted,
    date: $date
)) {
    echo json_encode([
        "status" => "success",
        "message" => "Message sent successfully."
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to send message."
    ]);
}

?>
