
        $(document).ready(function () {
            $("#forgotForm").on("submit", function (e) {
                e.preventDefault();

                const formData = {
                    "email": $("#email").val(),             
                      }

                $.ajax({
                    url: "engine/handle-forgot",
                    method: "POST",
                    contentType: "application/json",
                    data: JSON.stringify(formData),
                    success: function (response) {
                        if (response.success) {
                            $("#responseMessage").html(`<div class="alert alert-success">${response.message}</div>`);
                        } else {
                            $("#responseMessage").html(`<div class="alert alert-danger">${response.message}</div>`);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("XHR Response:", xhr.responseText);
                        console.error("Status:", status);
                        console.error("Error:", error);
                    
                        $("#responseMessage").html(`
                            <div class="alert alert-danger">
                                <strong>Error:</strong><br>
                                ${xhr.responseText || 'Something went wrong.'}
                            </div>
                        `);
                    }
                });
            });
        });
  