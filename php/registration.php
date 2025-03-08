<?php
session_start();

$servername = "cz1.helkor.eu";
$username = "u1918_D7TSELSLDS";
$password = "l4B@l6OAg!xFgY.Wc89XKyjZ";
$dbname = "s1918_dashboard";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Chyba připojení: " . $conn->connect_error);
}

// Získání dat z formuláře
$name = htmlspecialchars($_POST['name']);
$surname = htmlspecialchars($_POST['surname']);
$username = htmlspecialchars($_POST['username']);
$email = htmlspecialchars($_POST['email']);
$dob = $_POST['dob'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashování hesla

$stmt = $conn->prepare("INSERT INTO users (name, surname, username, email, dob, password) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $name, $surname, $username, $email, $dob, $password);

$stmt->close();
$conn->close();
