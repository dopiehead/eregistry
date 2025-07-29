
$('#contactForm').on('submit', function(e) {
    e.preventDefault();

    const formData = {
        email: $('#subscriptionemail').val().trim(),
       
    };

    $.ajax({
        url: 'engine/handle-subscription',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(formData),
        success: function(response) {
            if (response.status === 'success') {
                $('#response').html(`<div class="alert alert-success">${response.message}</div>`);
                $('#contactForm')[0].reset();
            } else {
                $('#response').html(`<div class="alert alert-danger">${response.message}</div>`);
               
            }
        },
        error: function(xhr, status, error) {
            $('#response').html(`<div class="alert alert-danger">An error occurred: ${error}</div>`);
        }
    });
});

