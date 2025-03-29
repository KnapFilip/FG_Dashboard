function checkUsername() {
    let username = document.getElementById("username").value.trim();
    let errorMessage = document.getElementById("error-message");

    // Kontrola délky a nepovolených znaků
    let usernameRegex = /^[a-zA-Z0-9_-]{3,}$/;
    if (!usernameRegex.test(username)) {
        errorMessage.textContent = "Uživatelské jméno musí mít alespoň 3 znaky a nesmí obsahovat speciální znaky.";
        return;
    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "check_username.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            if (response.exists) {
                errorMessage.textContent = "Toto uživatelské jméno je již obsazené!";
            } else {
                errorMessage.textContent = "✅ Uživatelské jméno je dostupné.";
                errorMessage.style.color = "green";
            }
        }
    };

    xhr.send("username=" + encodeURIComponent(username));
}
