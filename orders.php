<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ověření přihlášení
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Připojení k databázi
$servername = "cz1.helkor.eu";
$username = "u1918_D7TSELSLDS";
$password = "l4B@l6OAg!xFgY.Wc89XKyjZ";
$dbname = "s1918_dashboard";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Chyba připojení: " . $conn->connect_error);
}

// SQL dotaz na objednávky uživatele
$sql = "SELECT id, web_name, total_price, payment, created_at FROM orders WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="images/logo.png">
    <link rel="stylesheet" href="css/orders.css">
    <title>objednávky</title>
    <link rel="icon" type="image/png" href="images/logo_FG.png">
</head>
<header>
    <h1 class="ds">objednávky</h1>
</header>
<br>
<br>

<body>
    <section>
        <div class="navbar">
            <nav>
                <ul><br><br><br>
                    <li><a href="dashboard.php">🏠 Dashboard</a></li><br>
                    <li><a href="price_list.php">💲 Ceník</a></li><br>
                    <li><a href="eshop.php">✙ Vytvořit objednávku</a></li><br>
                    <li><a href="orders.php" class="Active">🌐 Objednávky</a></li><br>
                    <li><a href="profile.php"> 👤 Profil</a></li><br>
                    <li class="dropdown">
                        <?php if (isset($_SESSION['role_id']) && ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2)): ?>
                            <a href="#">⚙️ Managment ▼</a>
                            <ul class="dropdown-menu">
                                <li><a href="admin_orders.php">Orders</a></li>
                                <li><a href="admin_wip.php">WIP</a></li>
                            </ul>
                        <?php endif; ?>
                    </li>


                    <li><a href="php/logout.php"><img src="images/log_out.png" alt="Log-out" width="10%" height="10%"> Odhlásit se</a></li><br>
                </ul>
            </nav>
        </div><br>
    </section><br>
    <h2>Vaše objednávky</h2>
    <table>
        <tr>
            <th>ID objednávky</th>
            <th>Jméno webu</th>
            <th>Celková cena</th>
            <th>Metoda platby</th>
            <th>Datum vytvoření</th>
            <th>Detail</th>
        </tr>
        <?php while ($order = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($order['id']); ?></td>
                <td><?php echo htmlspecialchars($order['web_name']); ?></td>
                <td><?php echo htmlspecialchars($order['total_price']); ?> Kč</td>
                <td><?php echo $order['payment'] == 0 ? 'Bankovní převod' : 'PayPal'; ?></td>
                <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                <td><button class="order-button" data-id="<?php echo $order['id']; ?>">Detail</button></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Modální okno -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="orderDetails">Načítání...</div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modal = document.getElementById("orderModal");
            var orderDetails = document.getElementById("orderDetails");
            var closeBtn = document.getElementsByClassName("close")[0];

            document.querySelectorAll(".order-button").forEach(function(button) {
                button.addEventListener("click", function() {
                    var orderId = this.getAttribute("data-id");

                    // AJAX požadavek na načtení detailů
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
        });
    </script>
</body><br>
<br>
<footer style="background-color: rgb(54, 54, 54)">
    <!--odkazy na sociální sítě-->
    <a href="https://www.instagram.com/fida_knap/" target="_blank" style="padding: 10px;"><img src="images/instagram.png" alt="instagram" style="width: 4%; height: 4%;" class="ig"></a>
    <a href="https://discord.gg/msv22aux3m" target="_blank" style="padding: 10px;"><img src="images/discord.png" alt="discord" style="width: 5%; height: 7%;" class="dc"></a>
    <p>created by filip knap with lot of ☕ and ❤️</p>
    <p>© 2025 knap filip</p>
</footer>

</html>
<?php
$stmt->close();
$conn->close();
?>