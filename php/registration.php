<?php
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
$name = $_POST['name'];
$surname = $_POST['surname'];
$username = $_POST['username'];
$email = $_POST['email'];
$dob = $_POST['dob'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashování hesla

// Vložení dat do databáze
$sql = "INSERT INTO users (name, surname, username, email, dob, password) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $name, $surname, $username, $email, $dob, $password);

if ($stmt->execute()) {
    echo "<script>alert('Registrace proběhla úspěšně!'); window.location.href='../dashboard.html';</script>";
} else {
    echo "<script>alert('Chyba při registraci: " . $stmt->error . "'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
