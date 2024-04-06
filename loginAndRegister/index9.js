document.addEventListener('DOMContentLoaded', function() {
    let body = document.querySelector('body');
    let loginBtn = body.querySelector('.formBtn');
    let loginForm = document.querySelector('form'); // Define loginForm variable
    let bun = document.querySelector('.bun');
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

    document.querySelectorAll('.reg').forEach(function(button) {
        // Add a click event listener to each of them
        button.addEventListener('click', function(event) {
            // Prevent the default action of the link
            event.preventDefault();

            // Play the delete sound
            var audio = document.getElementById('aSound');
            audio.play();

            // After the sound has finished playing, navigate to the link's href
            audio.onended = function() {
                window.location = button.getAttribute('href');
            };
        });
});

    loginBtn.addEventListener('click', function() {
        playKeyPressSound(keySound4, 0);
    });

    const passwordInput = document.querySelector("input[name='password']");
        const passwordError = document.getElementById("passwordError");
        const emailInput = document.querySelector("input[name='email']");
        const emailError = document.getElementById("emailError");

        // Move error messages below the respective input fields
        passwordInput.parentNode.insertBefore(passwordError, passwordInput.nextSibling);
        emailInput.parentNode.insertBefore(emailError, emailInput.nextSibling);

        // Fade out error messages after 3 seconds
        setTimeout(function() {
            passwordError.style.opacity = '0';
            emailError.style.opacity = '0';
            setTimeout(function() {
                passwordError.style.display = 'none';
                emailError.style.display = 'none';
            }, 1000); // Additional 1 second for display:none transition
        }, 3000);
});