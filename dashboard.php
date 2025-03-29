<?php
session_start();

// Ověření, zda je uživatel přihlášený
if (!isset($_SESSION['username'])) {
    // Pokud není, přesměrovat na login
    header("Location: login.php");
    exit();
}
// Připojení k databázi (upravte podle Vašeho nastavení)
$db_host = 'cz1.helkor.eu:3306';
$db_name = 's1918_dashboard';
$db_user = 'u1918_D7TSELSLDS';
$db_pass = 'l4B@l6OAg!xFgY.Wc89XKyjZ';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Připojení k databázi selhalo: " . $e->getMessage());
}

// Předpokládáme, že ID uživatele je uloženo v session nebo je známé – zde pro ukázku $userId = 1
$userId = 1;

// Načtení údajů uživatele včetně hesla (používáme password_hash)
$stmt = $pdo->prepare("SELECT name, surname, username, email, dob, created_at, role_id, password_hash FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Uživatel nebyl nalezen.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">
    <link rel="icon" type="image/jpg" href="images/logo.png">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="images/logo_FG.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                    <li><a href="dashboard.php" class="Active">🏠 Dashboard</a></li><br>
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
    <section>
        <div class="content">
            <h1>Dashboard</h1>
            <p>Vítejte v administraci, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        </div>
    </section><br>
    <div class="info">
        <div class="profile_info">
            <h2><a href="profile.php" style="color: white; text-decoration: none">Profil</a></h2>
            <p>Vaše informace</p><br>
            <p><strong>Jméno:</strong><br> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Příjmení:</strong><br> <?php echo htmlspecialchars($user['surname']); ?></p>
            <p><strong>Uživatelské jméno:</strong><br> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            <p><strong>Email:</strong><br> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Datum narození:</strong><br> <?php echo htmlspecialchars($user['dob']); ?></p>
        </div>
        <div class="news">
            <h2>Novinky a aktualizace</h2>
            <p>19.03.2025</p><br>
            <p>Uvedení portálu do provozu a zajištění funkčnosti na všech zařízech kromě telefonů <br>
                Podpora telefonů bude zajiště v následujících dnech.
            </p>
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