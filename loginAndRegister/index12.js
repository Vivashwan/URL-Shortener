document.addEventListener('DOMContentLoaded', function() {
    let body = document.querySelector('body');
    let bun = document.querySelector('.bun');
    let registerBtn = body.querySelector('.inputButton');
    const savedMode = localStorage.getItem('mode');

    const keySound5 = new Audio("./music/tapNotification.mp3");
    const keySound4 = new Audio("./music/keyPressSound1.mp3");

    function playKeyPressSound(sound, delay) {
        setTimeout(() => {
            sound.currentTime = 0;
            sound.play();
        }, delay);
    }

    function setMode(mode) {
        if (mode === 'light') {
            body.classList.add('light');
        } else {
            body.classList.remove('light');
        }
    }

    setMode(savedMode || 'dark');

    bun.addEventListener('click', function() {
        // Toggle light mode
        playKeyPressSound(keySound5, 0);
        body.classList.toggle('light');

        // Update mode in local storage
        const newMode = body.classList.contains('light') ? 'light' : 'dark';
        localStorage.setItem('mode', newMode);
    });

    registerBtn.addEventListener('click', function() {
        playKeyPressSound(keySound4, 0);
    });

    document.querySelectorAll('.logi').forEach(function(button) {
        // Add a click event listener to each of them
        button.addEventListener('click', function(event) {
            // Prevent the default action of the link
            event.preventDefault();

            // Play the delete sound
            var audio = document.getElementById('bSound');
            audio.play();

            // After the sound has finished playing, navigate to the link's href
            audio.onended = function() {
                window.location = button.getAttribute('href');
            };
        });

    });

     setTimeout(function() {
        var errorMessage = document.getElementById('password-match-error');
        if (errorMessage) {
            errorMessage.style.transition = "opacity 1s";
            errorMessage.style.opacity = "0";
            setTimeout(function() {
                errorMessage.style.display = "none";
            }, 1000); // Hide the error message after fading out
        }
    }, 3000);

    setTimeout(function() {
        var emailError = document.getElementById('email-exists-error');
        if (emailError) {
            emailError.style.transition = "opacity 1s";
            emailError.style.opacity = "0";
            setTimeout(function() {
                emailError.style.display = "none";
            }, 1000); // Hide the error message after fading out
        }
    }, 3000);

    setTimeout(function() {
        var passwordError = document.getElementById('password-length-error');
        if (passwordError) {
            passwordError.style.transition = "opacity 1s";
            passwordError.style.opacity = "0";
            setTimeout(function() {
                passwordError.style.display = "none";
            }, 1000); // Hide the error message after fading out
        }
    }, 3000);

    setTimeout(function() {
        var emailError = document.getElementById('email-invalid-error');
        if (emailError) {
            emailError.style.transition = "opacity 1s";
            emailError.style.opacity = "0";
            setTimeout(function() {
                emailError.style.display = "none";
            }, 1000); // Hide the error message after fading out
        }
    }, 3000);

    setTimeout(function() {
        var emailError = document.getElementById('all-fields-req');
        if (emailError) {
            emailError.style.transition = "opacity 1s";
            emailError.style.opacity = "0";
            setTimeout(function() {
                emailError.style.display = "none";
            }, 1000); // Hide the error message after fading out
        }
    }, 3000);

});
