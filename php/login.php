<?php
session_start();

// Zobrazení errorů pro debug (v produkci vypnout!)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Připojení k databázi
$servername = "cz1.helkor.eu";
$username = "u1918_D7TSELSLDS";
$password = "l4B@l6OAg!xFgY.Wc89XKyjZ";
$dbname = "s1918_dashboard";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Chyba připojení k databázi.");
}

// Funkce na ošetření vstupních dat
function cleanInput($conn, $data)
{
    return htmlspecialchars(mysqli_real_escape_string($conn, trim($data)));
}

// Kontrola, zda jsou vyplněná povinná pole
if (empty($_POST['username_or_email']) || empty($_POST['password'])) {
    die("❌ Musíte vyplnit všechny údaje.");
}

$usernameOrEmail = cleanInput($conn, $_POST['username_or_email']);
$password = $_POST['password'];

// Kontrola existence uživatele (username NEBO email)
$stmt = $conn->prepare("SELECT id, username, email, password_hash, role_id FROM users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Ověření hesla
    if (password_verify($password, $user['password_hash'])) {
        // Regenerace session ID pro bezpečnost
        session_regenerate_id(true);

        // Uložení údajů do SESSION
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role_id'] = $user['role_id'];

        // Přesměrování podle role
        switch ($user['role_id']) {
            case 1:
                header("Location: https://dash.knapf.eu/dashboard.php");
                break;
            case 2:
                header("Location: https://dash.knapf.eu/dashboard.php");
                break;
            default:
                header("Location: https://dash.knapf.eu/dashboard.php");
        }
        exit();
    } else {
        die("❌ Chybné heslo.");
    }
} else {
    die("❌ Uživatel neexistuje.");
}

// Zavření spojení
$stmt->close();
$conn->close();
