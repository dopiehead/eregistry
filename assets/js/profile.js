
$(document).ready(function () {
  // Change border on focus
  window.changeBackground = function (obj) {
    $(obj).addClass("border border-danger");
  };

  // Save data on blur
  window.saveData = function (obj, id, column) {
    let value = obj.value.trim();

    let customer = {
      id: id, // optional, may be empty if using session
      column: column,
      value: value,
    };

    console.log("Sending data:", customer); // ✅ Debug

    $.ajax({
      type: "POST",
      url: "../engine/saveData", // ✅ update this path if needed
      data: customer,
      dataType: "json",
      success: function (response) {
        console.log("Server response:", response); // ✅ Debug

        if (response.success === true) {
          swal({
            title: "Success",
            text: "Record saved",
            icon: "success",
            timer: 1500,
            buttons: false,
          });
          $(obj).removeClass("border border-danger");
        } else {
          swal({
            title: "Error",
            text: response.error || "Failed to save record",
            icon: "warning",
          });
        }
      },
      error: function (xhr, status, error) {
        swal({
          title: "AJAX Error",
          text: `Request failed: ${error}`,
          icon: "error",
        });
        console.error("AJAX error:", xhr.responseText);
      },
    });
  };


  $('#bankForm').on('submit', function (e) {
    e.preventDefault();

    const btn = $('#submit');
    const spinner = btn.find('.spinner-border');
    const note = btn.find('.submit-note');

    // Disable button and show spinner
    btn.prop('disabled', true);
    spinner.show();
    note.text('Submitting...');

    const formData = {
        bank_name: $('input').eq(0).val().trim(),
        bank_account: $('input').eq(1).val().trim(),
        bank_balance: $('input').eq(2).val().trim()
    };

    $.ajax({
        url: '../engine/bankProcessingEngine',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(formData),
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                swal({
                  icon:"success",
                  title:"Success",
                  text:"Bank data saved successfully!"
                });
            } else {
                swal({
                  icon:"warning",
                  title:"Notice",
                  text:"Error: " + (response.error || "Something went wrong")
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", error);
            alert("AJAX failed: " + error);
        },
        complete: function () {
            // Re-enable button and hide spinner
            btn.prop('disabled', false);
            spinner.hide();
            note.text('Submit');
        }
    });
});


// $('#lg').html("<select  id='lga' class=' lga '><option>LGA</option></select>");
$('.location').on('change', function (e) {
  e.preventDefault();
  var location = $(this).val();

  if (location === '') {
      $('#lga').html('<option value="">Select LGA</option>');
      return;
  }

  $.ajax({
      type: "POST",
      url: "../engine/get-lga", // Your PHP file
      data: { location: location },
      success: function (data) {
          $('#lga').html(data);
      },
      error: function () {
          $('#lga').html('<option value="">Failed to load LGAs</option>');
      }
  });
});



});





