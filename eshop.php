<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="images/logo.png">
    <link rel="stylesheet" href="css/eshop.css">
    <title>E-Shop</title>
    <link rel="icon" type="image/png" href="images/logo_FG.png">
</head>
<header>
    <h1 class="ds">E-Shop</h1>
</header>
<br>
<br>

<body>
    <section>
        <div class="navbar">
            <nav>
                <ul><br><br><br>
                    <li><a href="dashboard.php">🏠 Dashboard</a></li><br>
                    <li><a class="Active" href="eshop.php">✙ Vytvořit objednávku</a></li><br>
                    <li><a href="orders.php">🌐 Objednávky</a></li><br>
                    <li><a href="wip.html"> 👤 Profil</a></li><br>
                    <li><a href="php/logout.php"><img src="images/log_out.png" alt="Log-out" width="10%" height="10%">Odhlásit se</a></li><br>
                </ul>
            </nav>
        </div><br>
    </section><br>
    <div class="order_form">
        <h2>Objednávkový formulář</h2>
        <form action="php/order.php" method="post" class="Contact" enctype="multipart/form-data">
            <h3>Kontaktní údaje</h3>
            <label for="name">Jméno</label><br>
            <input type="text" id="name" name="name" required placeholder="Filip"><br>

            <label for="surname">Příjmení</label><br>
            <input type="text" id="surname" name="surname" required placeholder="Knap"><br>

            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" required placeholder="KnapFilip@email.cz"><br>

            <label for="phone">Telefon</label><br>
            <input type="tel" id="phone" name="phone" required placeholder="+420 731 XXX 329"><br>

            <label for="address">Adresa</label><br>
            <input type="text" id="address" name="address" required placeholder="Ulice, Číslo popisné, Město, směrovací číslo" style="font-size: medium;"><br>

            <h3>Objednávka</h3>
            <div class="order">
                <div class="web_form">
                    <label for="web">Webové stránky 1500kč (základ)</label><br>

                    <label for="web_name">Jméno webu</label><br>
                    <input type="text" id="web_name" name="web_name"><br>

                    <label for="web_type">Typ webu</label><br>
                    <select name="web_type" id="web_type">
                        <option value="static">Statický</option>
                        <option value="dynamic">Dynamický</option>
                    </select><br>

                    <label for="web_use">Hlavní využití webu</label><br>
                    <input type="text" id="web_use" name="web_use"><br>

                    <label for="colors">Barevné schéma (jpg s kódy)</label><br>
                    <input type="file" id="colors" name="colors"><br>

                    <label for="logo">Logo</label><br>
                    <input type="file" id="logo" name="logo"><br>

                    <label for="pages">Požadované stránky</label><br>
                    <input type="text" id="pages" name="pages" placeholder="Úvod, O nás, atd."><br>

                    <!-- Checkboxy -->
                    <input type="checkbox" id="login" name="login"><label for="login">Login/registrace formulář +250kč</label>
                    <input type="checkbox" id="admin" name="admin"><label for="admin">Admin stránka +200kč</label>
                    <input type="checkbox" id="shop" name="shop"><label for="shop">E-shop +500kč</label>
                    <input type="checkbox" id="db" name="db"><label for="db">Propojení s databází +50kč</label>
                    <input type="checkbox" id="hosting" name="hosting"><label for="hosting">Zajištění hostingu +50kč</label>
                    <input type="checkbox" id="domain" name="domain"><label for="domain">Zajištění domény +50kč</label>
                    <input type="checkbox" id="contact_form" name="contact_form"><label for="contact_form">Kontaktní formulář s propojením na email 50 kč</label>
                    <br>
                    <label for="other">Jiné +100kč (Každý požadavek oddělovat čárkou)</label><br>
                    <textarea name="other" id="other_text"></textarea><br>

                    <label for="total_price">Celková cena</label><br>
                    <input type="text" id="total_price" name="total_price" readonly>
                </div><br><br>
            </div>

            <h3>Platba</h3>
            <label for="payment">Způsob platby</label><br>
            <select name="payment" id="payment">
                <option value="bank">Převodem</option>
                <option value="paypal">Paypal</option>
            </select><br>

            <p>Pokud by při zadání objednávky došlo k chybě nebo špatnému zadání cena na faktuře se může lišit. Tyto změny budou obeznámeny kupujícímu.</p>

            <input type="checkbox" id="gdpr" name="gdpr" required>
            <label for="gdpr"><a href="other/GDPR.pdf" target="_blank">Souhlasím se zpracováním osobních údajů</a></label><br>

            <input type="checkbox" id="vos" name="vos" required>
            <label for="vos"><a href="other/obchodni-podminky.pdf" target="_blank">Souhlasím s obchodními podmínkami</a></label><br><br>

            <input type="submit" value="Odeslat objednávku">
        </form>

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

<script src="js/prices.js"></script>