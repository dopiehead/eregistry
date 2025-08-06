
    (function () {
        const inputs = Array.from(document.querySelectorAll('.pin-input'));
        const errorEl = document.getElementById('error-message');
        const form = document.getElementById('pinForm');

        // Focus first on load
        if (inputs.length) inputs[0].focus();

        // Enforce one digit, auto-advance, and handle backspace
        inputs.forEach((input, idx) => {
            input.addEventListener('input', (e) => {
                let v = input.value.replace(/\D/g, '');
                if (v.length > 1) v = v.slice(-1); // keep last digit if multiple
                input.value = v;

                if (v && idx < inputs.length - 1) {
                    inputs[idx + 1].focus();
                    inputs[idx + 1].select?.();
                }
                errorEl.textContent = '';
            });

            input.addEventListener('keydown', (e) => {
                const key = e.key;

                // Move left on Backspace if empty
                if (key === 'Backspace' && !input.value && idx > 0) {
                    inputs[idx - 1].focus();
                    inputs[idx - 1].value = '';
                    e.preventDefault();
                }

                // Arrow navigation
                if (key === 'ArrowLeft' && idx > 0) {
                    inputs[idx - 1].focus();
                    e.preventDefault();
                }
                if (key === 'ArrowRight' && idx < inputs.length - 1) {
                    inputs[idx + 1].focus();
                    e.preventDefault();
                }
            });

            // Prevent scroll changing numbers on focus (desktop)
            input.addEventListener('wheel', (e) => e.preventDefault(), { passive: false });

            // Handle paste of full PIN
            input.addEventListener('paste', (e) => {
                const text = (e.clipboardData || window.clipboardData).getData('text');
                const digits = (text || '').replace(/\D/g, '').slice(0, inputs.length);
                if (!digits) return;

                e.preventDefault();
                inputs.forEach((inp, i) => inp.value = digits[i] || '');
                const last = digits.length ? Math.min(digits.length, inputs.length) - 1 : 0;
                inputs[last].focus();
            });
        });

        // Submit
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            const pin = inputs.map(i => i.value).join('');
            if (pin.length !== 4 || /\D/.test(pin)) {
                errorEl.textContent = 'Please enter a valid 4-digit PIN.';
                return;
            }

            // TODO: replace with your endpoint if needed
            fetch('engine/verify_pin', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ pin })
            })
            .then(res => res.json())
            .then(json => {
                if (json.success) {
                    window.location.href = json.redirect || 'protected/userdashboarddetails.php';
                } else {
                    errorEl.textContent = json.error || 'Invalid PIN. Please try again.';
                    inputs.forEach(i => i.value = '');
                    inputs[0].focus();
                }
            })
            .catch(() => {
                errorEl.textContent = 'Network error. Please try again.';
            });
        });
    })();

    // $(document).on("submit","#pinForm",function (e) {
    //     e.preventDefault();
    //     let formData = $(this).serialize();
    //     if(formData.length === 0){
    //       $("#error-message").html("<span alert='danger'>Please Enter Pin</span>");
    //     }
    //     $.ajax({
    //            url:"pin-confirmation",
    //            type:"POST",
    //            data:formData,
    //            dataType:"JSON",
    //            success:function(response){
    //               if(response.message ==='success'){
    //                 window.location.href = "userdashboarddetails.php";
    //               }
    //               else{
    //                 $("#error-message").html("<span alert='danger'>" + response.message + "</span>");
    //               }
    //            }



    //     });
        
    // });
   