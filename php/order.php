<?php
session_start();

// Zobrazení errorů (pro debug, v produkci vypnout!)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Připojení k databázi
$servername = "cz1.helkor.eu:3306";
$username = "u1918_D7TSELSLDS";
$password = "l4B@l6OAg!xFgY.Wc89XKyjZ";
$dbname = "s1918_dashboard";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Chyba připojení: " . $conn->connect_error);
}

// Kontrola přihlášení uživatele
if (!isset($_SESSION['user_id'])) {
    die("❌ Musíte být přihlášen pro vytvoření objednávky.");
}

// Získání ID přihlášeného uživatele
$user_id = $_SESSION['user_id'];

// Získání a validace dat z formuláře
$name = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
$surname = htmlspecialchars($_POST['surname'] ?? '', ENT_QUOTES, 'UTF-8');
$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL) ? $_POST['email'] : die("❌ Neplatný email.");
$phone = preg_match('/^\d{9}$/', $_POST['phone'] ?? '') ? $_POST['phone'] : die("❌ Neplatné telefonní číslo.");
$address = htmlspecialchars($_POST['address'] ?? '', ENT_QUOTES, 'UTF-8');
$web_name = htmlspecialchars($_POST['web_name'] ?? '', ENT_QUOTES, 'UTF-8');
$web_type = $_POST['web_type'] ?? '';
$web_use = htmlspecialchars($_POST['web_use'] ?? '', ENT_QUOTES, 'UTF-8');
$pages = htmlspecialchars($_POST['pages'] ?? '', ENT_QUOTES, 'UTF-8');
$other = htmlspecialchars($_POST['other'] ?? '', ENT_QUOTES, 'UTF-8');

$login = isset($_POST['login']) ? 1 : 0;
$admin = isset($_POST['admin']) ? 1 : 0;
$shop = isset($_POST['shop']) ? 1 : 0;
$db = isset($_POST['db']) ? 1 : 0;
$hosting = isset($_POST['hosting']) ? 1 : 0;
$domain = isset($_POST['domain']) ? 1 : 0;
$contact_form = isset($_POST['contact_form']) ? 1 : 0;

$total_price = floatval(str_replace(',', '.', $_POST['total_price'] ?? '0'));
if ($total_price <= 0) {
    die("❌ Neplatná cena.");
}

$payment = $_POST['payment'] ?? '';

// 📌 **PŘIDANÉ:** `user_id` do INSERT dotazu!
$sql = "INSERT INTO orders 
    (user_id, name, surname, email, phone, address, web_name, web_type, web_use, pages, login, admin, shop, db, hosting, domain, contact_form, other, total_price, payment) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "isssssssssiiiiiiissd", // 📌 Opravený typový řetězec!
    $user_id,
    $name,
    $surname,
    $email,
    $phone,
    $address,
    $web_name,
    $web_type,
    $web_use,
    $pages,
    $login,
    $admin,
    $shop,
    $db,
    $hosting,
    $domain,
    $contact_form,
    $other,
    $total_price,
    $payment
);

if ($stmt->execute()) {
    // Získání ID poslední objednávky
    $order_id = $conn->insert_id;

    // Přesměrování na potvrzení
    header('Location: ../confirmation.php?order_id=' . $order_id);
    exit();
} else {
    echo "❌ Chyba při odesílání objednávky: " . $stmt->error;
}

// Uzavření spojení
$stmt->close();
$conn->close();
