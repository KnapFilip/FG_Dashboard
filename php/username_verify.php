<?php
// Připojení k databázi
$host = "cz1.helkor.eu:3306";
$dbname = "s1918_dashboard";
$username = "u1918_D7TSELSLDS";
$password = "l4B@l6OAg!xFgY.Wc89XKyjZ";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Chyba připojení: " . $e->getMessage());
}

// Získání hodnoty z AJAX požadavku
if (isset($_POST['username'])) {
    $userInput = trim($_POST['username']);

    // Příprava dotazu
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->execute([$userInput]);
    $count = $stmt->fetchColumn();

    // Odpověď JSON
    echo json_encode(["exists" => $count > 0]);
}
