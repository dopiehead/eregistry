<?php include("contents/permission.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Notifications</title>
    <?php @include("components/links.php") ?>
    <link rel="stylesheet" href="../assets/css/protected/contents.css">
    <link rel="stylesheet" href="../assets/css/protected/post-contents.css">
</head>
<body>
    <!-- Sidebar -->
    <?php @include("components/sidebar.php") ?>
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <?php @include("components/topbar.php") ?>

        <div class="container-fluid py-3">

<?php
// Mark all as read (pending=1) for this recipient_id
$get_notifications   = $conn->prepare("SELECT id, sender_id, message, pending, date FROM user_notifications WHERE recipient_id = ? ORDER BY date DESC");
$update_notifications = $conn->prepare("UPDATE user_notifications SET pending = 1 WHERE recipient_id = ?");
if ($update_notifications && $update_notifications->bind_param("i", $user_id)) {
    $update_notifications->execute();
    $update_notifications->close();
}

include("../engine/time_ago.php");

$hasRows = false;
if ($get_notifications && $get_notifications->bind_param("i", $user_id)) {
    $get_notifications->execute();
    $result = $get_notifications->get_result();
    $hasRows = ($result && $result->num_rows > 0);
}
?>

<?php if ($hasRows): ?>
  <!-- Header / actions row -->
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h5 class="mb-0">Notifications</h5>
    <!-- Optional: Clear-all action (wire later if needed) -->
    <!-- <button class="btn btn-sm btn-outline-secondary"><i class="fa fa-broom me-1"></i>Clear All</button> -->
  </div>

  <div class="row g-3">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card shadow-sm h-100">
          <div class="card-body d-flex flex-column gap-2">

            <!-- Top line: Icon + sender + unread badge -->
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center gap-2">
                <span class="text-primary fa fa-bell fa-lg"></span>
                <span class="text-muted small">
                  From:
                  <b class="text-dark">
                    <?= htmlspecialchars($row['sender_id'] ?: 'Admin') ?>
                  </b>
                </span>
              </div>

              <?php if ((int)$row['pending'] === 0): ?>
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Unread</span>
              <?php else: ?>
                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Read</span>
              <?php endif; ?>
            </div>

            <!-- Message -->
            <div class="mt-1">
              <p class="mb-0 <?= (int)$row['pending'] === 0 ? 'fw-semibold' : '' ?>">
                <?= htmlspecialchars($row['message']) ?>
              </p>
            </div>

            <!-- Footer: time + delete -->
            <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top">
              <span class="text-muted small">
                <?= htmlspecialchars(timeAgo($row['date'])) ?>
              </span>
              <button
                type="button"
                class="btn btn-sm btn-outline-danger btn-delete"
                data-id="<?= (int)$row['id'] ?>"
                title="Delete notification"
              >
                <i class="fa fa-trash me-1"></i>Delete
              </button>
            </div>

          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

<?php else: ?>
  <!-- Empty state -->
  <div class="d-flex align-items-center justify-content-center" style="min-height: 50vh;">
    <div class="text-center">
      <div class="mb-2">
        <i class="fa fa-bell-slash text-secondary" style="font-size: 2.25rem;"></i>
      </div>
      <p class="text-secondary mb-1">You have no new notifications</p>
      <small class="text-muted">We’ll let you know when something arrives.</small>
    </div>
  </div>
<?php endif; ?>

<?php
  if ($get_notifications) { $get_notifications->close(); }
?>

</div>

<script 
  src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js">
</script>
   <script src="../assets/js/notifications.js"></script>
   <script>
    document.addEventListener('click', async function(e) {
  const btn = e.target.closest('.btn-delete');
  if (!btn) return;

  const id = btn.getAttribute('data-id');
 
  if (!id) return;

  const card = btn.closest('.col-12, .col-md-6, .col-lg-4') || btn.closest('.card');

  const confirm = await Swal.fire({
    title: 'Delete notification?',
    text: 'This action cannot be undone.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete',
    cancelButtonText: 'Cancel'
  });

  if (!confirm.isConfirmed) return;

  try {
    const res = await fetch('../engine/delete-notification', {
    method: 'POST',
     headers: {
       'X-Requested-With': 'XMLHttpRequest',
       'Content-Type': 'application/x-www-form-urlencoded'
  },
  body: 'id=' + encodeURIComponent(id)
   });
    const text = await res.text();

    if (text.trim() === '1') {
      if (card) card.remove();
      Swal.fire({ title: 'Deleted', text: 'Notification removed.', icon: 'success', timer: 1200, showConfirmButton: false });
    } else {
      Swal.fire({ title: 'Notice', text: text || 'Could not delete notification.', icon: 'info' });
    }
  } catch (err) {
    Swal.fire({ title: 'Error', text: 'Network error. Please try again.', icon: 'error' });
  }
});

   </script>
</body>
</html> 
