<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="images/logo.png">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="images/logo_FG.png">
</head>
<header>
    <h1 class="ds">Dashboard</h1>
</header>
<br>
<br>

<body>
    <section>
        <div class="navbar">
            <nav>
                <ul><br><br><br>
                    <li><a class="Active" href="dashboard.php">🏠 Dashboard</a></li><br>
                    <li><a href="eshop.php">✙ Vytvořit objednávku</a></li><br>
                    <li><a href="orders.php">🌐 Objednávky</a></li><br>
                    <li><a href="wip.html"> 👤 Profil</a></li><br>
                    <li><a href="php/logout.php"><img src="images/log_out.png" alt="Log-out" width="10%" height="10%">Odhlásit se</a></li><br>
                </ul>
            </nav>
        </div><br>
    </section><br>
    <section>
        <div class="content">
            <h1>Dashboard</h1>
            <p>Vítejte v administraci, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        </div>
    </section><br>
    <div class="info">
        <div class="profile_info">
            <h2>Profil</h2>
            <p>Vaše informace</p>
        </div>
        <div class="news">
            <h2>Novinky a aktualizace</h2>
            <p></p>
        </div>
    </div>

</body><br>
<br>
<footer style="background-color: rgb(54, 54, 54)">
    <!--Odkazy na sociální sítě-->
    <a href="https://www.instagram.com/fida_knap/" target="_blank" style="padding: 10px;"><img src="images/instagram.png" alt="instagram" style="width: 4%; height: 4%;" class="IG"></a>
    <a href="https://discord.gg/Msv22AUx3m" target="_blank" style="padding: 10px;"><img src="images/discord.png" alt="discord" style="width: 5%; height: 7%;" class="DC"></a>
    <p>Created by Filip Knap with lot of ☕ and ❤️</p>
    <p>© 2025 Knap Filip</p>
</footer>

</html>