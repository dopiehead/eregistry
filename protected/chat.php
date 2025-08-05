<?php 
include("contents/permission.php");
if (isset($_SESSION['u_id'])) {
    $sender     = $email;
    $senderName = $name;
}
$conn = $auth->getConnection();
if (isset($_GET['user_name'])) {
    $user_name = $_GET['user_name'];
    $sql = "UPDATE messages SET has_read = 1 WHERE sender_email = ? AND receiver_email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $user_name, $sender);
        $stmt->execute();
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chat</title>
    <?php include("components/links.php") ?>
    <link rel="stylesheet" href="../assets/css/protected/chat.css">
</head>
<body>
    <div class="chat-container">
        <!-- Header -->
        <div class="chat-header">
            <a href="messages.php" class="back-button">
                <i class="fa fa-chevron-left"></i>
            </a>
            <div class="user-info">
                <h2 class="user-name">
                    <a href="user-profile.php?id=<?= $id ?>">
                        <?= substr($user_name, 0, 4); ?>
                    </a>
                </h2>
            </div>
        </div>

        <!-- Messages Container -->
        <div class="messages-container" id="messagebox">
            <div id="parent">
                <div id="child">
<?php
$sql = "SELECT * FROM messages WHERE is_sender_deleted = 0 AND ((sender_email = ? AND receiver_email = ?) OR (sender_email = ? AND receiver_email = ?)) ORDER BY date ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $sender, $user_name, $user_name, $sender);
$stmt->execute();
$result = $stmt->get_result();

while ($messages = $result->fetch_assoc()) {
    if ($messages['sender_email'] === $user_name) {
?>
        <div class="message-group receiver-message">
            <div class="message-bubble">
                <?= htmlspecialchars($messages['compose']); ?>
            </div>
            <div class="message-time">
                Received: <?= htmlspecialchars($messages['date']); ?>
            </div>
        </div>
<?php
    }
    if ($messages['receiver_email'] === $user_name) {
?>
        <div class="message-group sender-message">
            <div class="message-bubble">
                <?= htmlspecialchars($messages['compose']); ?>
            </div>
            <div class="message-time">
                <div class="message-status">
                    <?php if ($messages['has_read'] == 1) { ?>
                        <span class="status-seen">
                            <i class="fas fa-check-double"></i>
                            Seen: <?= htmlspecialchars($messages['date']); ?>
                        </span>
                    <?php } else { ?>
                        <span class="status-sent">
                            <i class="fas fa-check"></i>
                            Sent: <?= htmlspecialchars($messages['date']); ?>
                        </span>
                    <?php } ?>
                </div>
            </div>
        </div>
<?php
    }
}
$stmt->close();
?>
                </div>
            </div>

            <!-- Typing Indicator -->
            <div class="typing-indicator" id="typingIndicator">
                <div class="typing-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="chat-input-container">
            <form method="post" id="message-form">
                <input type="hidden" name="has" value="0">
                <input type="hidden" name="is_sender_deleted" value="0">
                <input type="hidden" name="is_receiver_deleted" value="0">
                <input type="hidden" name="sentto" value="<?= htmlspecialchars($user_name); ?>">
<?php
$subject = "No subject found";
if (isset($sender, $user_name)) {
    $stmt = $conn->prepare(
        "SELECT subject FROM messages WHERE (sender_email = ? AND receiver_email = ?) OR (sender_email = ? AND receiver_email = ?) ORDER BY id DESC LIMIT 1"
    );
    if ($stmt) {
        $stmt->bind_param("ssss", $sender, $user_name, $user_name, $sender);
        $stmt->execute();
        $stmt->bind_result($fetched_subject);
        if ($stmt->fetch()) {
            $subject = empty($fetched_subject) ? "No subject found" : $fetched_subject;
        }
        $stmt->close();
    }
}
?>
                <input type="hidden" name="subject" value="<?= htmlspecialchars($subject); ?>">
                <input type="hidden" name="sentby" value="<?= htmlspecialchars($sender); ?>">
                <input type="hidden" name="name" value="<?= htmlspecialchars($senderName); ?>">
                <input type="hidden" id="receiver_name" name="receiver_name" value="<?= htmlspecialchars($user_name) ?>">
                <div class="input-wrapper">
                    <textarea class="message-input" name="message" id="message" rows="1" placeholder="Type your message..." wrap="physical"></textarea>
                    <button type="button" name="submit" id="submit" class="send-button">
                        <i class="fa fa-paper-plane"></i>
                        Send
                    </button>
                </div>
            </form>
        </div>
    </div>

    <span class="result"></span>
    <script src="../assets/js/chat.js"></script>
</body>
</html>
