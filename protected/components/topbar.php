
<div class="top-bar">
            <div>
                <h1 style="margin: 0; font-size: 24px; font-weight: 600; color: #1f2937;">Hello, <?= htmlspecialchars($name) ?></h1>
            </div>
            <div class="user-profile">
                <span style="color: #6b7280; font-size: 14px;"><?= htmlspecialchars (date("Y-m-d")) ?></span>
                <?php             
             if (!in_array($extension , $image_extension)) :
                  echo"<div class='text-center user-avatar border border-mute rounded rounded-circle  d-flex justify-content-center align-items-center'><span style='font-size:20px;' class='text-secondary text-uppercase'>".substr($name,0,2)."</span></div>";                  
             else: ?> 
                <?php $image = $image ?? "https://placehold.co/600x400"; ?>
                <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($name) ?>" class="user-avatar">
           <?php endif ?>
                <div>
                    <div style="font-weight: 600; font-size: 14px;"><?= htmlspecialchars($name) ?></div>
                    <div style="color: #6b7280; font-size: 12px;">@<?= htmlspecialchars($name) ?></div>
                </div>
                <div class="dropdown">
                    <a href='tel:+<?= htmlspecialchars($phone ?? null) ?>' class="btn" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-phone"></i>
                    </a>
                </div>
                <a class='text-dark' href='notifications.php'>
<?php
// Count all notifications for this recipient_id
$get_notifications = $conn->prepare("
    SELECT COUNT(*) AS count 
    FROM user_notifications 
    WHERE recipient_id = ? AND pending = 0
");
if ($get_notifications) {
    $get_notifications->bind_param("i", $id);
    $get_notifications->execute();
    $result = $get_notifications->get_result();
    $row = $result->fetch_assoc();
    $countnotifications = (int)$row['count'];
    $get_notifications->close();
} else {
    $countnotifications = 0;
}
?>

                <div class="dropdown">

                        <i class="fas fa-bell"></i> (<span class='text-danger'><?= htmlspecialchars($countnotifications) ?></span>)
               
                </div> 
                </a>
                <div class="dropdown">
                    <button class="btn" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                </div>
            </div>
        </div>