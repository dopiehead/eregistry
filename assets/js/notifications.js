
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
    const res = await fetch('delete-notification.php?id=' + encodeURIComponent(id), {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
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
