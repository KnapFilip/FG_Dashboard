<?php
session_start();

$servername = "cz1.helkor.eu";
$username = "u1918_D7TSELSLDS";
$password = "l4B@l6OAg!xFgY.Wc89XKyjZ";
$dbname = "s1918_dashboard";

// Připojení k databázi
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Chyba připojení: " . $conn->connect_error);
}

// Získání ID objednávky z URL (předpokládáme, že ID objednávky je posíláno v URL)
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id === 0) {
    echo "Neplatné ID objednávky.";
    exit();
}

// Příprava SQL dotazu pro získání detailů objednávky
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

// Zkontroluj, zda byla objednávka nalezena
if ($result->num_rows === 0) {
    echo "Objednávka s tímto ID nebyla nalezena.";
    exit();
}

$order = $result->fetch_assoc();

// Uzavření spojení s databází
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potvrzení objednávky</title>
    <link rel="stylesheet" href="css/confirmation.css"> <!-- Připojte svůj CSS soubor pro styling -->
    <link rel="icon" type="image/png" href="images/logo_FG.png">
</head>

<body>
    <div class="confirmation-container">
        <h1>Potvrzení objednávky</h1>
        <p>Vítejte, <strong><?php echo htmlspecialchars($order['name']) . " " . htmlspecialchars($order['surname']); ?>!</strong></p>
        <p>Děkujeme za vaši objednávku. Během 24 hodin vás budeme kontaktovat na email <?php echo htmlspecialchars($order['email']); ?>.</p>

        <h3>Detaily objednávky:</h3>
        <p><strong>ID objednávky:</strong> <?php echo $order['id']; ?></p>
        <p><strong>Jméno:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
        <p><strong>Příjmení:</strong> <?php echo htmlspecialchars($order['surname']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
        <p><strong>Telefon:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
        <p><strong>Adresa:</strong> <?php echo htmlspecialchars($order['address']); ?></p>

        <h4>Objednávka:</h4>
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
        <p><strong>Metoda platby:</strong> <?php echo htmlspecialchars($order['payment']); ?></p>

        <h4>Souhlas s podmínkami:</h4>
        <p><strong>GDPR:</strong> <?php echo $order['gdpr'] ? 'Souhlasí' : 'Nesouhlasí'; ?></p>
        <p><strong>Obchodní podmínky:</strong> <?php echo $order['vos'] ? 'Souhlasí' : 'Nesouhlasí'; ?></p>

        <br>
        <a href="https://dash.knapf.eu/dashboard.php" class="btn-back">Zpět na dashboard</a>
    </div>
</body>

</html>