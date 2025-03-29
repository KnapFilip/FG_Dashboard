<?php
session_start();
require_once 'php/username_verify.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="images/logo.png">
    <link rel="stylesheet" href="css/registration.css">
    <title>Registrace</title>
    <link rel="icon" type="image/png" href="images/logo_FG.png">
</head>
<br>
<br>

<body>
    <div class="registration">
        <form id="registerForm" action="php/registration.php" method="POST" enctype="multipart/form-data" onsubmit="return validatepassword(event)" oninput="checkUsername()">
            <h2>Registrační formulář</h2>

            <label for="name">Jméno</label><br>
            <input type="text" name="name" required><br>

            <label for="surname">Příjmení</label><br>
            <input type="text" name="surname" required><br>

            <label for="username">Uživatelské jméno</label><br>
            <input type="text" name="username" placeholder="bez diakritiky" required><br>

            <label for="email">Email</label><br>
            <input type="email" name="email" required><br>

            <label for="dob">Datum narození</label><br>
            <input type="date" name="dob" required><br>

            <label for="password">Heslo</label><br>
            <input type="password" id="password" name="password" minlength="8" required><br>

            <label for="confirm_password">Potvrzení hesla</label><br>
            <input type="password" id="confirm_password" required><br>

            <input type="submit" value="Registrovat se">
        </form>
        <h3><a href="login.php">Již máte účet? Přihlašte se zde.</a></h3>
    </div>

</body>
<footer>
    <!--Odkazy na sociální sítě-->
    <a href="https://www.instagram.com/fida_knap/" target="_blank" style="padding: 10px;"><img src="images/instagram.png" alt="instagram" style="width: 4%; height: 4%;" class="IG"></a>
    <a href="https://discord.gg/Msv22AUx3m" target="_blank" style="padding: 10px;"><img src="images/discord.png" alt="discord" style="width: 5%; height: 7%;" class="DC"></a>
    <p>Created by Filip Knap with lot of ☕ and ❤️</p>
    <p>© 2025 Knap Filip</p>
</footer>

</html>

<script src="js/validation.js"></script>
<script src="js/username_check.js"></script>