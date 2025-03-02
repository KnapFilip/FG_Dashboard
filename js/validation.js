document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("form").addEventListener("submit", function (event) {
        let password = document.getElementById("password").value;
        let confirmPassword = document.getElementById("confirm_password").value;

        if (password !== confirmPassword) {
            alert("Hesla se neshodují!");
            event.preventDefault(); // Zabrání odeslání formuláře
        }
    });
});
