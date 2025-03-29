<?php
session_start();

// Ověření, zda je uživatel přihlášený
if (!isset($_SESSION['username'])) {
    // Pokud není, přesměrovat na login
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="images/logo.png">
    <link rel="stylesheet" href="css/wip.css">
    <title>Filip Knap</title>
    <link rel="icon" type="image/png" href="images/logo_FG.png">
</head>
<header>
    <h1>Filip Knap</h1>
    <section>
        <div class="navbar">
            <nav>
                <ul><br><br><br>
                    <li><a href="dashboard.php">🏠 Dashboard</a></li><br>
                    <li><a href="price_list.php">💲 Ceník</a></li><br>
                    <li><a href="eshop.php">✙ Vytvořit objednávku</a></li><br>
                    <li><a href="orders.php">🌐 Objednávky</a></li><br>
                    <li><a href="profile.php"> 👤 Profil</a></li><br>
                    <li class="dropdown">
                        <?php if (isset($_SESSION['role_id']) && ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2)): ?>
                            <a href="#">⚙️ Managment ▼</a>
                            <ul class="dropdown-menu">
                                <li><a href="admin_orders.php">Orders</a></li>
                                <li><a href="admin_wip.php">WIP</a></li>
                            </ul>
                        <?php endif; ?>
                    </li>


                    <li><a href="php/logout.php"><img src="images/log_out.png" alt="Log-out" width="10%" height="10%"> Odhlásit se</a></li><br>
                </ul>
            </nav>
        </div><br>
    </section><br>
</header>

<body>
    <div class="wip">

        <h2 class="wip" style="text-align: center; font-size: 150px; margin-top: 10%; margin-left: 8%;">Zde pro vás připravujeme něco skvělého!</h2>

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

<script src="JS/ban.js"></script>