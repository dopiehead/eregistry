
$('#contactForm').on('submit', function(e) {
    e.preventDefault();

    const formData = {
        firstName: $('#firstName').val().trim(),
        lastName: $('#lastName').val().trim(),
        subject: $('#subject').val().trim(),
        email: $('#email').val().trim(),
        message: $('#message').val().trim()
    };

    $.ajax({
        url: 'engine/handle-contact',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(formData),
        success: function(response) {
            if (response.status === 'success') {
                $('#responseMessage').html(`<div class="alert alert-success">${response.message}</div>`);
                $('#contactForm')[0].reset();
            } else {
                $('#responseMessage').html(`<div class="alert alert-danger">${response.message}</div>`);
               
            }
        },
        error: function(xhr, status, error) {
            $('#responseMessage').html(`<div class="alert alert-danger">An error occurred: ${error}</div>`);
        }
    });
});

