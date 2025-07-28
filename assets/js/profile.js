
 // Ensure jQuery is loaded before this
$(document).ready(function () {
  // Enable editing on click
  $(".btn-edit").click(function () {
    $("span[contenteditable]").css("border-bottom", "1px dotted red");
    $("span[contenteditable]").prop("contenteditable", true);
  });

  // Change background on focus
  window.changeBackground = function (obj) {
    $(obj).addClass("border-1 border-mute");
  };

  // Save data on blur
  window.saveData = function (obj, id, column) {
    let customer = {
      id: id,
      column: column,
      value: obj.innerText.trim(),
    };

    $.ajax({
      type: "POST",
      url: "../engine/saveData",
      data: customer,
      dataType: "json",
      success: function (response) {
        if (response.success === true) {
          swal({
            title: "Success",
            text: "Record saved",
            icon: "success",
          });
          $(obj).removeClass("border-mute");
        } else {
          swal({
            title: "Error",
            text: "Failed to save record",
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
        console.error("AJAX request failed:", xhr.responseText);
      },
    });
  };
});
