<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');

$conn = $auth->getConnection();

$user_id = $auth->getUserId();

$getUserDetails = $conn->prepare("SELECT * FROM user_profile WHERE id = ? AND verified = 1");
$getUserDetails->bind_param("i", $user_id);

if ($getUserDetails->execute()) {
    $result = $getUserDetails->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // 🔑 Create variables like $name, $email, etc. from array keys
        extract($user);

        // ✅ Now you can use variables directly
        // e.g., echo $name, $email, $bio, etc.

    } else {
        echo "User not found or not verified.";
    }
} else {
    echo "Query execution failed: " . $conn->error;
}

$getUserDetails->close();
?>
