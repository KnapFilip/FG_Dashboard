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

// Ošetření vstupních dat
function cleanInput($data)
{
    return htmlspecialchars(trim($data));
}

$name = cleanInput($_POST['name']);
$surname = cleanInput($_POST['surname']);
$username = cleanInput($_POST['username']);
$email = cleanInput($_POST['email']);
$dob = $_POST['dob'];
$password = $_POST['password'];
$default_role_id = 3; // ID role "User"

// Validace username (min. 3 znaky, bez speciálních znaků)
if (!preg_match("/^[a-zA-Z0-9_-]{3,}$/", $username)) {
    die("Neplatné uživatelské jméno.");
}

// Validace emailu
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Neplatný email.");
}

// Hashování hesla
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Kontrola, zda uživatel již existuje
$checkStmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
$checkStmt->bind_param("ss", $username, $email);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    echo "Uživatel s tímto jménem nebo emailem již existuje.";
    $checkStmt->close();
    $conn->close();
    exit();
}
$checkStmt->close();

// Vložení uživatele do databáze s rolí User (role_id = 3)
$stmt = $conn->prepare("INSERT INTO users (name, surname, username, email, dob, password_hash, role_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssi", $name, $surname, $username, $email, $dob, $hashedPassword, $default_role_id);

if ($stmt->execute()) {
    // Uložení údajů do SESSION pro přihlášení uživatele
    $_SESSION['user_id'] = $stmt->insert_id;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['role_id'] = $default_role_id;

    // Přesměrování na dashboard
    header("Location: https://dash.knapf.eu/dashboard.php");
    exit();
} else {
    echo "Chyba při registraci: " . $stmt->error;
}

$stmt->close();
$conn->close();
