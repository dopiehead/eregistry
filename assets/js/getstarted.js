
$(function() {
    // jQuery UI tabs initialization with fade animation
    $("#auth-tabs").tabs({
        activate: function(event, ui) {
            ui.newPanel.hide().fadeIn(300);
        }
    });
    // Handle user type button selection (outside form submission)
    // $(".btn-outline-secondary").on("click", function(e) {
    //     e.preventDefault();
    //     const userType = $(this).attr("id");
    //     $("#user_type").val(userType);
    //     $(this).addClass("btn-secondary text-white")
    //            .siblings().removeClass("btn-secondary text-white");
    // });

    // LOGIN HANDLER
    $('#login').on('submit', function(e) {
        e.preventDefault();

        $(".spinner-border").show();
        $(".signin-note").hide();
        $('.btn-custom').prop('disabled', true);
        const formData = {
        "login-email": $("#login-email").val(),
        "login-password": $("#login-password").val(),
          }
        const url = $("#url_details").val().trim();

        $.ajax({
            type: "POST",
            url: "engine/loginProcess",
            data: JSON.stringify(formData),
            contentType: "application/json", // Important!
            dataType: "json",
            success: function(response) {
                $(".spinner-border").hide();
                $(".signin-note").show();
                $('.btn-custom').prop('disabled', false);

                if (response.status === "success") {
                    if (url) {
                        window.location.href = url;
                    } else {
                        window.location.href = "protected/dashboard.php";                      
                    }
                } else {
                    $("#error-message").text(response.message);
                    $("#login-email").addClass("border border-2 border-danger");
                    $("#login-password").addClass("border border-2 border-danger");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $(".spinner-border").hide();
                $(".signin-note").show();
                $('.btn-custom').prop('disabled', false);
            
                // Display detailed error
                let errorMsg = "Something went wrong. Please try again.";
            
                if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                    errorMsg = jqXHR.responseJSON.message;
                } else if (jqXHR.responseText) {
                    errorMsg = "Server Error: " + jqXHR.responseText;
                } else if (errorThrown) {
                    errorMsg = "Error Thrown: " + errorThrown;
                } else if (textStatus) {
                    errorMsg = "Status: " + textStatus;
                }
            
                // Log full response to console for developer debugging
                console.error("AJAX Error:", {
                    status: jqXHR.status,
                    statusText: jqXHR.statusText,
                    responseText: jqXHR.responseText,
                    errorThrown: errorThrown,
                    textStatus: textStatus
                });
            
                $("#error-message").text(errorMsg);
            }
        });
    });

    // SIGNUP HANDLER
    $('#signup').on('submit', function(e) {
        e.preventDefault();

        if ($('#signup-password').val() !== $('#signup-confirm').val()) {
            alert("Passwords do not match!");
            return;
        }

        $(".spinner-border").show();
        $(".signup-note").hide();
        $('.btn-custom').prop('disabled', true);

        const formData = {
        "signup-name": $("#signup-name").val(),
        "signup-email": $("#signup-email").val(),
        "signup-password": $("#signup-password").val(),
        "signup-confirm": $("#signup-confirm").val(),
        "bio": null,        // Add if needed
        "pin": null,        // Add if needed
        "image": null     // Optional
    };

        $.ajax({
            type: "POST",
            url: "engine/register",
            data: JSON.stringify(formData),
            contentType: "application/json", // Important!
            dataType: "json",
            success: function(response) {
                $(".spinner-border").hide();
                $(".signup-note").show();
                $('.btn-custom').prop('disabled', false);

                if (response.status === "success") {
                    swal({
                        icon: "success",
                        title: "Registration Successful",
                        text: response.message
                    });
                    $('#signup')[0].reset();
                } else {
                    swal({
                        icon: "warning",
                        title: "Registration Failed",
                        text: response.message
                    });

                     $("input").addClass("border border-2 border-danger");
          
                }
            },
            error: function(err) {
                $(".spinner-border").hide();
                $(".signup-note").show();
                $('.btn-custom').prop('disabled', false);
                swal({
                    icon: "error",
                    title: "Registration Failed",
                    text: err.responseText || "Something went wrong"
                });
            }
        });
    });
});
