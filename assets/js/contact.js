$('#contactForm').on('submit', function(e) {
    e.preventDefault();

    // Disable UI during submission
    $(".spinner-border").show();
    $(".btn-text").hide();

    // const formData1 = $("#contactForm").serialize();

    // Gather form data
    const formData = {
        firstName: $('#firstName').val().trim(),
        lastName: $('#lastName').val().trim(),
        subject: $('#subject').val().trim(),
        email: $('#email').val().trim(),
        message: $('#message').val().trim()
    };



    // Basic frontend validation
    if (!formData.firstName || !formData.email || !formData.subject || !formData.message) {
        
        swal({
             title:"Notice",
             text:"All required fields must be filled out.",
             icon:"warning"
        });

        $(".btn-text").show();
        $(".spinner-border").hide();
        return;
    }

    // AJAX request
    $.ajax({
        url: 'engine/handle-contact', // your PHP handler
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(formData),
        success: function(response) {
            if (response.status === 'success') {
                swal({
                    title: "Success",
                    text: response.message,
                    icon: "success",
                });
                $('#contactForm')[0].reset();
            } else {
                swal({
                    title: "Notice",
                    text: response.message,
                    icon: "warning",
                });
            }

            $(".btn-text").show();
            $(".spinner-border").hide();
        },
        error: function(xhr, status, error) {
            $('#responseMessage').html(`<div class="alert alert-danger">An error occurred: ${error}</div>`);
            $(".btn-text").show();
            $(".spinner-border").hide();
        }
    });
});
