function checkUsername() {
    let username = document.getElementById("username").value;
    let errorMessage = document.getElementById("error-message");

    if (username.length < 3) {
        errorMessage.textContent = "Uživatelské jméno musí mít alespoň 3 znaky.";
        return;
    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "check_username.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            if (response.exists) {
                errorMessage.textContent = "Toto uživatelské jméno je již obsazené!";
            } else {
                errorMessage.textContent = "";
            }
        }
    };

    xhr.send("username=" + encodeURIComponent(username));
}