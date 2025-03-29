function validatepassword(event) {
    event.preventDefault(); // Zabrání odeslání formuláře, pokud není správně vyplněný

    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirm_password").value;

    if (password !== confirmPassword) {
        alert("Hesla se neshodují!");
        return false;
    }

    document.getElementById("registerForm").submit();
}