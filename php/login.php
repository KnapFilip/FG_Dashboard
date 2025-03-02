<?php
session_start();

$servername = "cz1.helkor.eu";
$username = "u1918_p0RJhKRM6N";
$password = "FTE@Zh@5rq@z0^eawy8!su^r";
$dbname = "s1918_users";

// Připojení k databázi
$conn = new mysqli($servername, $username, $password, $dbname, 3306);

// Kontrola připojení
if ($conn->connect_error) {
    die("Chyba připojení: " . $conn->connect_error);
}

// Získání dat z formuláře
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Příprava SQL dotazu
$sql = "SELECT id, username, email, password FROM users WHERE username = ? AND email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Ověření hesla
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        echo "<script>alert('Přihlášení proběhlo úspěšně!'); window.location.href='../dashboard.html';</script>";
    } else {
        echo "<script>alert('Nesprávné heslo!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Uživatel nenalezen!'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
