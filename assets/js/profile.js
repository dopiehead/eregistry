
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
      bank_name: $('#bank_name').val().trim(),
      bank_account: $('#bank_account').val().trim(),
      bank_balance: $('#bank_balance').val().trim(),
      account_type: $('#account_type').val().trim(),
      account_details: $('#account_details').val().trim()
  };

  // console.log("Bank Name:", formData.bank_name);
  // console.log("Bank Account:", formData.bank_account);
  // console.log("Bank Balance:", formData.bank_balance);
  // console.log("Account Type:", formData.account_type);

  $.ajax({
    type: 'POST',
    url: '../engine/bankProcessingEngine',
    data: {
        bank_name: $("#bank_name").val(),
        bank_account: $("#bank_account").val(),
        bank_balance: $("#bank_balance").val(),
        account_type: $("#account_type").val(),
        account_details: $("#account_details").val()
    },
    success: function (response) {
     

        if (response.success) {
            swal({title:"Success",icon:"success",text:response.message});
        } else {
            swal({title:"Notice",icon:"warning",text:response.error || "Unknown error."});
        }
    },
    error: function (xhr, status, error) {
        console.error("AJAX error:", error);
        console.log("Response text:", xhr.responseText);
        swal({title:"Notice",icon:"warning",text:"Unexpected error occurred. See console for details."});
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


$(document).ready(function () {
    $("#saveNextOfKin").on("click", function (e) {
        e.preventDefault();

        // Collect form data
        let data = {
            next_of_kin_name: $("#next_of_kin_name").val(),
            next_of_kin_address: $("#next_of_kin_address").val(),
            next_of_kin_telephone: $("#next_of_kin_telephone").val(),
            next_of_kin_relationship: $("#next_of_kin_relationship").val()
        };

        // Send AJAX request
        $.ajax({
            url: "../engine/next_of_kin", // Your PHP file
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(data),
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $("#message").html(
                        "<span class='text-success'>Next of kin details saved successfully.</span>"
                    );
                } else {
                    $("#message").html(
                        "<span class='text-danger'>" + (response.error || "An error occurred") + "</span>"
                    );
                }
            },
            error: function () {
                $("#message").html(
                    "<span class='text-danger'>Unable to save data. Please try again.</span>"
                );
            }
        });
    });
});







