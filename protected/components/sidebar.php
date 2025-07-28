<div class="sidebar">
    <div class="logo">
        <i class="fas fa-th-large"></i> Eregistry
    </div>

    <nav class="nav flex-column">
        <a class="nav-link" href="../../index.php"><i class="fas fa-home"></i> Home</a>
        <a class="nav-link active" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a class="nav-link" href="profile.php"><i class="fas fa-user-alt"></i> Profile</a>
        <a class="nav-link" href="messages.php"><i class="fas fa-comments"></i> Chats</a>
        <a class="nav-link" href="post-contents.php"><i class="fas fa-book"></i> Contents</a>

        <!-- Settings toggle link -->
        <a style='cursor:pointer;' class="nav-link" id="settingsToggleBtn">
            <i class="fas fa-cog"></i> Settings 
            <span class="fa fa-caret-down ms-2"></span>
        </a>

        <!-- Hidden settings submenu -->
        <ul id="settingsContainer" class="list-unstyled pb-4 pt-2 px-3 bg-light d-none flex-column">
            <li>
                <a id="openProfilePopup" style="cursor:pointer" class="text-decoration-none border-bottom border-1 text-secondary border-secondary pt-2 pb-1 d-block">Change profile image</a>
            </li>
            <li>
                <a href="#" class="text-decoration-none border-bottom border-1 text-secondary border-secondary pt-2 pb-1 d-block">Delete Account</a>
            </li>
        </ul>
    </nav>

    <div style="padding: 24px;">
        <a href="#" style="color: #a0aec0; text-decoration: none; font-size: 14px;"><i class="fas fa-question-circle"></i> Help & Information</a>
        <div style="margin-top: 16px;">
            <a href="../engine/logout.php" style="color: #a0aec0; text-decoration: none; font-size: 14px;"><i class="fas fa-sign-out-alt"></i> Log out</a>
        </div>
    </div>
</div>

<!-- Popup modal for image upload -->

<div class="popupProfile p-4 bg-white border rounded shadow position-fixed top-50 start-50 translate-middle"
     style="max-width: 400px; display: none; z-index: 1050;">
  
  <!-- Close button (top right) -->
  <button type="button" class="btn-close position-absolute top-0 end-0 m-2" id="closeProfilePopup" aria-label="Close"></button>

  <form id="changeImageForm" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="profileImage" class="form-label">Change Profile Image</label>
      <input type="file" class="form-control" id="fileupload" name="fileupload" accept="image/*" required>
    </div>

    <button type="submit" class="btn btn-primary w-100"><span class='submit-note'>Upload</span> <span style='display:none;' class='spinner-border text-white'></span></button>
  </form>
<div class='text-center' id='result'></div>
</div>
<!-- End of image upload modal -->








<script>
  $(document).ready(function () {

    // Toggle settings dropdown
    $('#settingsToggleBtn').on('click', function () {
      const container = $('#settingsContainer');

      if (container.is(':visible')) {
        container.slideUp(200, function () {
          container.removeClass('d-flex').addClass('d-none');
        });
      } else {
        container.removeClass('d-none').addClass('d-flex').hide().slideDown(200);
      }
    });

    // Open profile popup
    $('#openProfilePopup').on('click', function () {
      $('#result').html(''); // clear previous messages
      $('.popupProfile').fadeIn();
    });

    // Close profile popup
    $('#closeProfilePopup').on('click', function () {
      $('.popupProfile').fadeOut();
    });

    // Handle image form submission
    $('#changeImageForm').on('submit', function (e) {
      e.preventDefault();

      $(".spinner-border").show();
      $(".submit-note").hide();

      let formData = new FormData(this);

      $.ajax({
        url: '../engine/changeProfilePhoto', // Ensure this path is correct
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',

        success: function (response) {
          $(".spinner-border").hide();
          $(".submit-note").show();

          if (response.success) {
            $("#result").html('<div class="alert alert-success">' + response.message + '</div>');

            setTimeout(function () {
              $('.popupProfile').fadeOut(1000);
              $("#changeImageForm")[0].reset(); // Reset form
              // Optionally update profile image on page
            }, 1000);

          } else {
            $("#result").html('<div class="alert alert-danger">' + (response.message || 'Upload failed.') + '</div>');
          }
        },

        error: function () {
          $(".spinner-border").hide();
          $(".submit-note").show();

          $("#result").html('<div class="alert alert-danger">Server error. Please try again.</div>');
        }
      });
    });

  });
</script>



