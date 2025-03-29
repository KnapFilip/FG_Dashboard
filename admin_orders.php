<?php
session_start();

// Ověření, zda je uživatel přihlášený
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$role_id = $_SESSION['role_id'];

// Zkontroluj, zda má uživatel roli 1 (Managment) nebo 2 (Admin)
if ($role_id != 1 && $role_id != 2) {
    header("Location: dashboard.php");
    exit();
}

// Připojení k databázi
$servername = "cz1.helkor.eu:3306";
$username = "u1918_D7TSELSLDS";
$password = "l4B@l6OAg!xFgY.Wc89XKyjZ";
$dbname = "s1918_dashboard";

// Vytvoření připojení
$conn = new mysqli($servername, $username, $password, $dbname);

// Ověření připojení
if ($conn->connect_error) {
    die("❌ Chyba připojení k databázi: " . $conn->connect_error);
}
// Nastavení kódování pro MySQL
$conn->set_charset("utf8mb4");

// Zpracování formuláře pro změnu stavu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = intval($_POST['order_id']);
    $status = $conn->real_escape_string($_POST['status']);
    $update_sql = "UPDATE orders SET status = '$status' WHERE id = $order_id";

    if ($conn->query($update_sql) === TRUE) {
        echo "✅ Stav objednávky byl úspěšně změněn.";
    } else {
        echo "❌ Chyba při aktualizaci objednávky: " . $conn->error;
    }
}

// Načtení objednávek
$sql = "SELECT * FROM orders ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="images/logo.png">
    <link rel="stylesheet" href="css/admin_orders.css">
    <title>Filip Knap</title>
    <link rel="icon" type="image/png" href="images/logo_FG.png">
</head>

<header>
    <h1>Admin-Orders</h1>
</header>
<br><br>

<body>
    <section>
        <div class="navbar">
        <nav>
                <ul><br><br><br>
                    <li><a href="dashboard.php">🏠 Dashboard</a></li><br>
                    <li><a href="price_list.php">💲 Ceník</a></li><br>
                    <li><a href="eshop.php">✙ Vytvořit objednávku</a></li><br>
                    <li><a href="orders.php">🌐 Objednávky</a></li><br>
                    <li><a href="profile.php"> 👤 Profil</a></li><br>
                    <li class="dropdown" class="Active">
                        <?php if (isset($_SESSION['role_id']) && ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2)): ?>
                            <a href="#">⚙️ Managment ▼</a>
                            <ul class="dropdown-menu">
                                <li><a href="admin_orders.php" class="Active">Orders</a></li>
                                <li><a href="admin_wip.php">WIP</a></li>
                            </ul>
                        <?php endif; ?>
                    </li>


                    <li><a href="php/logout.php"><img src="images/log_out.png" alt="Log-out" width="10%" height="10%"> Odhlásit se</a></li><br>
                </ul>
            </nav>
        </div><br>
    </section><br>

    <?php
    if ($result->num_rows > 0) {
        echo '<h2>Vaše objednávky</h2>';
        echo '<table>
            <tr>
                <th>ID objednávky</th>
                <th>Jméno webu</th>
                <th>Celková cena</th>
                <th>Metoda platby</th>
                <th>Datum vytvoření</th>
                <th>Stav změna</th>
                <th>Detail</th>
            </tr>';

        while ($order = $result->fetch_assoc()) {
            echo '<tr>
                <td>' . htmlspecialchars($order['id']) . '</td>
                <td>' . htmlspecialchars($order['web_name']) . '</td>
                <td>' . htmlspecialchars($order['total_price']) . ' Kč</td>
                <td>' . ($order['payment'] == 0 ? 'Bankovní převod' : 'PayPal') . '</td>
                <td>' . htmlspecialchars($order['created_at']) . '</td>
                <td>
                    <select class="status-select" data-order-id="' . $order['id'] . '">
                        <option value="Čeká" ' . ($order['status'] == 'Čeká' ? 'selected' : '') . '>Čeká</option>
                        <option value="V procesu" ' . ($order['status'] == 'V procesu' ? 'selected' : '') . '>V procesu</option>
                        <option value="Dokončeno" ' . ($order['status'] == 'Dokončeno' ? 'selected' : '') . '>Dokončeno</option>
                    </select>
                </td>
                <td>
                    <button class="update-status-button" data-id="' . $order['id'] . '">Změnit stav</button>
                    <button class="order-button" data-id="' . $order['id'] . '">Detail</button>
                </td>
            </tr>';
        }
        echo '</table>';
    } else {
        echo "❌ Žádné objednávky nebyly nalezeny.";
    }
    ?>

    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="orderDetails">Načítání...</div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Modální okno pro detail objednávky
            var modal = document.getElementById("orderModal");
            var orderDetails = document.getElementById("orderDetails");
            var closeBtn = document.getElementsByClassName("close")[0];

            document.querySelectorAll(".order-button").forEach(function(button) {
                button.addEventListener("click", function() {
                    var orderId = this.getAttribute("data-id");

                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "order_detail.php?order_id=" + orderId, true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            orderDetails.innerHTML = xhr.responseText;
                            modal.style.display = "block";
                        }
                    };
                    xhr.send();
                });
            });

            closeBtn.onclick = function() {
                modal.style.display = "none";
            };

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };

            // Tlačítko pro změnu statusu (AJAX)
            document.querySelectorAll(".update-status-button").forEach(function(button) {
                button.addEventListener("click", function() {
                    var orderId = this.getAttribute("data-id");
                    var select = this.closest("tr").querySelector(".status-select");
                    var newStatus = select.value;

                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            alert(xhr.responseText); // zobrazí úspěšnou zprávu
                            // Aktualizuj stav na stránce bez znovu načtení
                            this.closest("tr").querySelector(".status").textContent = newStatus;
                        }
                    };
                    xhr.send("order_id=" + orderId + "&status=" + newStatus);
                });
            });
        });
    </script>

</body><br>
<br>
<footer style="background-color: rgb(54, 54, 54)">
    <a href="https://www.instagram.com/fida_knap/" target="_blank" style="padding: 10px;"><img src="images/instagram.png" alt="instagram" style="width: 4%; height: 4%;" class="ig"></a>
    <a href="https://discord.gg/msv22aux3m" target="_blank" style="padding: 10px;"><img src="images/discord.png" alt="discord" style="width: 5%; height: 7%;" class="dc"></a>
    <p>created by filip knap with lot of ☕ and ❤️</p>
    <p>© 2025 knap filip</p>
</footer>

</html>

<?php
$conn->close();
?>