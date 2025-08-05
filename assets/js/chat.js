
$(document).ready(function() {
    // Auto-resize textarea
    const textarea = document.getElementById('message');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    // Send message on button click
    $('#submit').on('click', function(e) {
        e.preventDefault();
        
        const messageText = $('#message').val().trim();
        if (!messageText) return;

        // Disable send button temporarily
        $(this).prop('disabled', true);
        
        // Show typing indicator
        $('#typingIndicator').show();

        $.ajax({
            type: "POST",
            url: "../engine/message-process",
            data: $('#message-form').serialize(),
            cache: false,
            contentType: "application/x-www-form-urlencoded",
            success: function(response) {
                $('.result').html(response);
                $('.result').fadeOut('slow');
                $('#message').val('');
                $('#message').css('height', 'auto');
                
                // Hide typing indicator
                $('#typingIndicator').hide();
                
                // Re-enable send button
                $('#submit').prop('disabled', false);
                
                // Scroll to bottom
                var objDiv = document.getElementById('messagebox');
                objDiv.scrollTop = objDiv.scrollHeight;
            },
            error: function() {
                $('#typingIndicator').hide();
                $('#submit').prop('disabled', false);
            }
        });
    });

    // Send message on Enter key (Shift+Enter for new line)
    $('#message').on('keypress', function(e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            $('#submit').click();
        }
    });

    // Auto-refresh messages
    setInterval(function() {
        $("#parent").load(location.href + " #child", function() {
            // Scroll to bottom after loading new messages
            var objDiv = document.getElementById('messagebox');
            objDiv.scrollTop = objDiv.scrollHeight;
        });
    }, 2500);

    // Initial scroll to bottom
    setTimeout(function() {
        var objDiv = document.getElementById('messagebox');
        objDiv.scrollTop = objDiv.scrollHeight;
    }, 100);
});
