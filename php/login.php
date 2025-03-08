<?php
session_start();

$servername = "cz1.helkor.eu";
$username = "u1918_D7TSELSLDS";
$password = "l4B@l6OAg!xFgY.Wc89XKyjZ";
$dbname = "s1918_dashboard";

// PDO připojení k databázi
try {
    $pdo = new PDO("mysql:host=$servername;port=3306;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Chyba připojení k databázi.");
}

$error = ''; // Inicializace proměnné pro chyby

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ošetření vstupů z formuláře
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validace, zda jsou pole vyplněná
    if (!empty($username) && !empty($password)) {
        // Příprava SQL dotazu pro vyhledání uživatele podle jména
        $stmt = $pdo->prepare("SELECT * FROM User WHERE username = :username");
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Ověření, zda existuje uživatel a zda je heslo správné
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true); // Zabrání session hijackingu
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Přesměrování na dashboard po úspěšném přihlášení
            header("Location: ../dashboard.php");
            exit;
        } else {
            // Chyba, pokud je uživatelské jméno nebo heslo nesprávné
            $error = "Neplatné uživatelské jméno nebo heslo.";
        }
    } else {
        // Chyba, pokud některé pole není vyplněné
        $error = "Vyplňte prosím všechna pole.";
    }
}

if ($error) {
    echo "<p style='color:red;'>$error</p>"; // Zobrazení chybové zprávy
}
