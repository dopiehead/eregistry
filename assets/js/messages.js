$(document).ready(function () {
    $('.remove').click(function () {
      if (confirm("Are you sure you want to delete this?")) {
        var id = $(this).attr('id');
        var rowElement = $(this).closest('tr');
  
        $.ajax({
          url: '../engine/remove-received',
          method: 'POST',
          data: { id: id },
          success: function (response) {
            if (response == 1) {
              swal({
                text: "Message has been deleted",
                icon: "success"
              });
              rowElement.fadeOut('slow', function () {
                $(this).remove();
              });
            } else {
              swal({
                icon: "error",
                text: response
              });
            }
          },
          error: function () {
            swal({
              icon: "error",
              text: "An error occurred while processing your request."
            });
          }
        });
      }
    });
  
    $('.removeSent').click(function () {
      if (confirm("Are you sure you want to delete this?")) {
        var id = $(this).attr('id');
        var rowElement = $(this).closest('tr');
  
        $.ajax({
          url: '../engine/remove-sent',
          method: 'POST',
          data: { id: id },
          success: function (response) {
            if (response == 1) {
              swal({
                text: "Message has been deleted",
                icon: "success"
              });
              rowElement.fadeOut('slow', function () {
                $(this).remove();
              });
            } else {
              swal({
                icon: "error",
                text: response
              });
            }
          },
          error: function () {
            swal({
              icon: "error",
              text: "An error occurred while processing your request."
            });
          }
        });
      }
    });
  });
  