<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/html; charset=utf-8');


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

<h4>Status:</h4>
<?php echo htmlspecialchars($order['status']); ?>

<h4>Datum vytvoření:</h4>
<p><strong>Vytvořeno:</strong> <?php echo htmlspecialchars($order['created_at']); ?></p>