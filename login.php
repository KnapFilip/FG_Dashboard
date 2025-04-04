<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="images/logo.png">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
    <link rel="icon" type="image/png" href="images/logo_FG.png">
</head>
<br>
<br>

<body>
    <div class="login">
        <form action="php/login.php" method="POST">
            <h1>Login</h1>

            <label for="username_or_email">Uživatelské jméno nebo Email</label><br>
            <input type="text" id="username_or_email" name="username_or_email" required><br>

            <label for="password">Heslo</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" value="Přihlásit se"><br><br>
        </form>
        <h3><a href="registration.php">Nemáte účet? Zaregistrujte se zde.</a></h3>
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