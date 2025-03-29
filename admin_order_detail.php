<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['username'])) {
    echo "Přístup zamítnut!";
    exit();
}

if (!isset($_GET['order_id'])) {
    echo "Chyba: Chybí ID objednávky!";
    exit();
}

$order_id = intval($_GET['order_id']);

$servername = "cz1.helkor.eu";
$username = "u1918_D7TSELSLDS";
$password = "l4B@l6OAg!xFgY.Wc89XKyjZ";
$dbname = "s1918_dashboard";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Chyba připojení: " . $conn->connect_error);
}

// Zpracování formuláře pro uložení poznámek
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notes'])) {
    // Zkontrolujeme, zda sloupec notes existuje
    $col_check = $conn->query("SHOW COLUMNS FROM orders LIKE 'notes'");
    if ($col_check->num_rows == 0) {
        // Přidání sloupce notes do tabulky orders, pokud neexistuje
        $conn->query("ALTER TABLE orders ADD COLUMN notes TEXT");
    }
    $notes = $_POST['notes'];
    $update_sql = "UPDATE orders SET notes = ? WHERE id = ? AND user_id = ?";
    $stmt_update = $conn->prepare($update_sql);
    $stmt_update->bind_param("sii", $notes, $order_id, $_SESSION['user_id']);
    $stmt_update->execute();
    $stmt_update->close();
}

// Načtení detailů objednávky
$sql = "SELECT * FROM orders WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $order_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Objednávka nenalezena!";
    exit();
}

$order = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <title>Detail objednávky</title>
    <style>
        /* Základní styl pro textarea */
        textarea {
            width: 100%;
            max-width: 500px;
            height: 100px;
            margin-bottom: 10px;
        }

        /* Styl pro oblast poznámek */
        .notes-container {
            margin: 20px auto;
            text-align: center;
            border: 1px solid #ccc;
            padding: 15px;
            background-color: rgb(40, 40, 40);
            color: white;
            border-radius: 5px;
        }

        /* Zajištění, že text uvnitř není skrytý */
        .notes-container p,
        .notes-container h4 {
            color: white;
        }
    </style>
</head>

<body>
    <h3>Detail objednávky #<?php echo htmlspecialchars($order['id']); ?></h3>
    <p><strong>Jméno webu:</strong> <?php echo htmlspecialchars($order['web_name']); ?></p>
    <p><strong>Typ webu:</strong> <?php echo htmlspecialchars($order['web_type']); ?></p>
    <p><strong>Využití webu:</strong> <?php echo htmlspecialchars($order['web_use']); ?></p>
    <p><strong>Požadované stránky:</strong> <?php echo htmlspecialchars($order['pages']); ?></p>

    <h4>Volitelné služby:</h4>
    <p><strong>Login/registrace:</strong> <?php echo $order['login'] ? 'Ano' : 'Ne'; ?></p>
    <p><strong>Admin stránka:</strong> <?php echo $order['admin'] ? 'Ano' : 'Ne'; ?></p>
    <p><strong>E-shop:</strong> <?php echo $order['shop'] ? 'Ano' : 'Ne'; ?></p>
    <p><strong>Propojení s databází:</strong> <?php echo $order['db'] ? 'Ano' : 'Ne'; ?></p>
    <p><strong>Hosting:</strong> <?php echo $order['hosting'] ? 'Ano' : 'Ne'; ?></p>
    <p><strong>Doména:</strong> <?php echo $order['domain'] ? 'Ano' : 'Ne'; ?></p>
    <p><strong>Kontaktní formulář:</strong> <?php echo $order['contact_form'] ? 'Ano' : 'Ne'; ?></p>
    <p><strong>Jiné požadavky:</strong> <?php echo htmlspecialchars($order['other']); ?></p>

    <h4>Cena:</h4>
    <p><strong>Celková cena:</strong> <?php echo htmlspecialchars($order['total_price']); ?> Kč</p>
    <h4>Platba:</h4>
    <p><strong>Metoda platby:</strong> <?php echo $order['payment'] == 0 ? 'Bankovní převod' : 'PayPal'; ?></p>
    <h4>Datum vytvoření:</h4>
    <p><strong>Vytvořeno:</strong> <?php echo htmlspecialchars($order['created_at']); ?></p>

    <!-- Oblast pro poznámky -->
    <div class="notes-container">
        <h4>Poznámky</h4>
        <!-- Zobrazení aktuálních poznámek -->
        <p><?php echo isset($order['notes']) && $order['notes'] !== '' ? htmlspecialchars($order['notes']) : 'Žádné poznámky.'; ?></p>
        <!-- Formulář pro uložení/úpravu poznámek -->
        <form method="post" action="">
            <textarea name="notes" rows="4" cols="50" placeholder="Sem napište své poznámky..."><?php echo isset($order['notes']) ? htmlspecialchars($order['notes']) : ''; ?></textarea>
            <br>
            <input type="submit" value="Uložit poznámky">
        </form>
    </div>
</body>

</html>