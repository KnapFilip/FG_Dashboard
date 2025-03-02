<?php
// Zde ukončíme session
session_start();
session_unset(); // Smaže všechny proměnné session
session_destroy(); // Zničí session

// Přesměrování na jiný web
header("Location: https://www.KnapF.eu");
exit; // Ukončí skript, aby se přesměrování provedlo okamžitě
?>
