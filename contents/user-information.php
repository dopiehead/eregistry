<?php 

$getUserDetails = $conn->prepare("SELECT * FROM user_profile WHERE id = ? AND verified = 1");
$getUserDetails->bind_param("i", $u_id);

if ($getUserDetails->execute()) {
    $result = $getUserDetails->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        extract($user);
    } else {
        echo "User not found or not verified.";
    }
} else {
    echo "Query execution failed: " . $conn->error;
}

$getUserDetails->close();







?>