// DOM Elements
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".wrapper form");
    const fullURL = form.querySelector("input");
    const shortenBtn = form.querySelector("button");
    const blueEffect = document.querySelector(".blurEffect");
    const popupBox = document.querySelector(".popup-Box");
    const form2 = popupBox.querySelector("form");
    const shortenURL = popupBox.querySelector("input");
    const saveBtn = popupBox.querySelector("button");
    const copyBtn = popupBox.querySelector(".fa-copy");
    const infoBox = popupBox.querySelector(".infoBox");
    const body = document.querySelector("body");
    const bun = document.querySelector(".bun");
    const btn = document.querySelector(".btn");
    const deleteBtns = document.querySelectorAll(".deleteBtn");

    // Audio Elements
    const keySounds = [
        new Audio("./music/clickButton.mp3"),
        new Audio("./music/fingerSnap.mp3"),
        new Audio("./music/shootingSound.mp3"),
        new Audio("./music/uiClick.mp3"),
        new Audio("./music/selectSound.mp3"),
        new Audio("./music/tapNotification.mp3"),
        new Audio("./music/keyPressSound3.mp3")
    ];

    // Functions to Play Key Press Sounds
    function playKeyPressSound(sound, delay) {
        setTimeout(() => {
            sound.currentTime = 0;
            sound.play();
        }, delay);
    }

    // Prevent Form Submission
    form.onsubmit = (e) => {
        e.preventDefault();
    };

    // Shorten Button Click Event
    shortenBtn.onclick = () => {
        playKeyPressSound(keySounds[0], 0);
        setTimeout(() => {
            shortenBtn.style.transform = "scale(0.9)";
            setTimeout(() => {
                shortenBtn.style.transform = "scale(1)";
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "php/urlControl.php", true);
                xhr.onload = () => {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        let data = xhr.response;
                        if (data.length <= 5) {
                            blueEffect.style.display = "block";
                            popupBox.classList.add("show");
                            let domain = "localhost/URL_Shortener/";
                            shortenURL.value = domain + data;
                            copyBtn.onclick = () => {
                                playKeyPressSound(keySounds[3], 0);
                                shortenURL.select();
                                document.execCommand("copy");
                            };
                            saveBtn.onclick = () => {
                                playKeyPressSound(keySounds[4], 0);
                                form2.onsubmit = (e) => {
                                    e.preventDefault();
                                };
                                let xhr2 = new XMLHttpRequest();
                                xhr2.open("POST", "php/save-url.php", true);
                                xhr2.onload = () => {
                                    if (xhr2.readyState == 4 && xhr2.status == 200) {
                                        let data = xhr2.response;
                                        if (data == "success") {
                                            setTimeout(() => {
                                                location.reload();
                                            }, 1000); // Add a delay of 1 second (1000 milliseconds)
                                        } else {
                                            infoBox.classList.add("error");
                                            infoBox.innerText = data;
                                        }
                                    }
                                };
                                let short_url = shortenURL.value;
                                let hidden_url = data;
                                xhr2.setRequestHeader(
                                    "Content-type",
                                    "application/x-www-form-urlencoded"
                                );
                                xhr2.send(
                                    "shorten_url=" + short_url + "&hidden_url=" + hidden_url
                                );
                            };
                            // Start confetti animation after the popup box is shown
                            canvas.width = width - 10;
                            canvas.height = height - 10;
                            window.requestAnimationFrame(startConfetti);
                        } else {
                            alert(data);
                        }
                    }
                };
                let formData = new FormData(form);
                xhr.send(formData);
            }, 100);
        }, 50);
    };

    // Set Mode Function
    function setMode(mode) {
        if (mode === "light") {
            body.classList.add("light");
        } else {
            body.classList.remove("light");
        }
    }

    // Set Mode from Local Storage or Default to Dark
    const savedMode = localStorage.getItem("mode");
    setMode(savedMode || "dark");

    // Bun Click Event (Toggle Light/Dark Mode)
    bun.onclick = function () {
        playKeyPressSound(keySounds[5], 0);
        body.classList.toggle("light");
        const newMode = body.classList.contains("light") ? "light" : "dark";
        localStorage.setItem("mode", newMode);
    };

    document.querySelectorAll('.deleteBtn').forEach(function (button) {
        button.addEventListener('click', function (event) {
            // Play the delete sound
            document.getElementById('deleteSound').play();

            // Prevent the default action of the delete button
            event.preventDefault();

            // Trigger the delete action after the sound has finished playing (you can adjust the delay)
            setTimeout(function () {
                window.location = button.getAttribute('href');
            }, 1000); // Adjust the delay as needed
        });
    });

    document.querySelectorAll('.clearBtn').forEach(function (button) {
        button.addEventListener('click', function (event) {
            // Play the clear sound
            document.getElementById('clearSound').play();

            // Prevent the default action of the clear button
            event.preventDefault();

            // Trigger the clear action after the sound has finished playing (you can adjust the delay)
            setTimeout(function () {
                window.location = button.getAttribute('href');
            }, 1000); // Adjust the delay as needed
        });
    });

    document.querySelectorAll('.btn').forEach(function (button) {
        button.addEventListener('click', function (event) {
            // Play the btn sound
            document.getElementById('btnSound').play();

            // Prevent the default action of the button
            event.preventDefault();

            // Trigger the action associated with the button after the sound has finished playing (you can adjust the delay)
            setTimeout(function () {
                window.location = button.getAttribute('href');
            }, 1000); // Adjust the delay as needed
        });
    });
});