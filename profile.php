<?php
session_start();

// Zapnutí zobrazování chyb
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Zpracování formuláře ke změně hesla
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Načtení vstupních hodnot
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Ověření, že aktuální heslo sedí s tím uloženým v databázi
    if (!password_verify($current_password, $user['password_hash'])) {
        $error = "Aktuální heslo není správné.";
    } elseif (strlen($new_password) < 8) {
        $error = "Nové heslo musí mít minimálně 8 znaků.";
    } elseif ($new_password === $current_password) {
        $error = "Nové heslo nesmí být stejné jako aktuální heslo.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Nové heslo a jeho potvrzení se neshodují.";
    } else {
        // Zahashování nového hesla a jeho uložení do databáze
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        if ($update_stmt->execute([$new_hashed_password, $userId])) {
            echo "<script>alert('Heslo bylo úspěšně změněno.'); window.location.href=window.location.href;</script>";
            exit;
        } else {
            $error = "Došlo k chybě při aktualizaci hesla.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="images/logo.png">
    <link rel="stylesheet" href="css/profile.css">
    <title>Profil</title>
    <link rel="icon" type="image/png" href="images/logo_FG.png">
</head>
<header>
    <h1 class="ds">Profil</h1>
</header>
<br>
<br>

<body>
    <section>
        <div class="navbar">
        <nav>
                <ul><br><br><br>
                    <li><a href="dashboard.php">🏠 Dashboard</a></li><br>
                    <li><a href="price_list.php">💲 Ceník</a></li><br>
                    <li><a href="eshop.php">✙ Vytvořit objednávku</a></li><br>
                    <li><a href="orders.php">🌐 Objednávky</a></li><br>
                    <li><a href="profile.php" class="Active"> 👤 Profil</a></li><br>
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
    <div class="profile-pass">
        <div class="profile">
            <h2>Váš profil</h2>
            <p>Jste přihlášen jako: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            <br>

            <!-- Zobrazení údajů uživatele -->
            <h3>Jméno</h3>
            <p><?php echo htmlspecialchars($user['name']); ?></p>

            <h3>Příjmení</h3>
            <p><?php echo htmlspecialchars($user['surname']); ?></p>

            <h3>Uživatelské jméno</h3>
            <p><?php echo htmlspecialchars($user['username']); ?></p>

            <h3>Email</h3>
            <p><?php echo htmlspecialchars($user['email']); ?></p>

            <h3>Datum narození</h3>
            <p><?php echo htmlspecialchars($user['dob']); ?></p>

            <h3>Účet vytvořen</h3>
            <p><?php echo htmlspecialchars($user['created_at']); ?></p>

            <h3>Role</h3>
            <p>
                <?php
                switch ($user['role_id']) {
                    case 1:
                        echo "Managment";
                        break;
                    case 2:
                        echo "Admin";
                        break;
                    case 3:
                        echo "Uživatel";
                        break;
                    default:
                        echo "Neznámá role";
                }
                ?>
            </p>
        </div>
        <!-- Zobrazení případné chybové hlášky -->
        <?php if (isset($error)) {
            echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>";
        } ?>
        <div class="password">
            <!-- Formulář pro změnu hesla -->
            <h2>Změna hesla</h2>
            <form method="post" action="">
                <label for="current_password">Aktuální heslo:</label><br>
                <input type="password" id="current_password" name="current_password" required><br><br>

                <label for="new_password">Nové heslo:</label><br>
                <input type="password" id="new_password" name="new_password" required><br><br>

                <label for="confirm_password">Nové heslo znovu:</label><br>
                <input type="password" id="confirm_password" name="confirm_password" required><br><br>

                <input type="submit" value="Změnit heslo">
            </form>
        </div>
    </div>
</body>
<footer style="background-color: rgb(54, 54, 54)">
    <!--Odkazy na sociální sítě-->
    <a href="https://www.instagram.com/fida_knap/" target="_blank" style="padding: 10px;"><img src="images/instagram.png" alt="instagram" style="width: 4%; height: 4%;" class="IG"></a>
    <a href="https://discord.gg/Msv22AUx3m" target="_blank" style="padding: 10px;"><img src="images/discord.png" alt="discord" style="width: 5%; height: 7%;" class="DC"></a>
    <p>Created by Filip Knap with lot of ☕ and ❤️</p>
    <p>© 2025 Knap Filip</p>
</footer>

</html>