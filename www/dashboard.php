<?php
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    // Als de gebruiker niet is ingelogd, stuur hem naar de inlogpagina
    header("Location: login.php");
    exit();
}

// Gebruiker is ingelogd, toon het dashboard
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Welkom bij het Dashboard</h2>
        <!-- Inhoud van het dashboard -->
        <p>Dit is het dashboard van de applicatie.</p>
        <p>Voeg hier inhoud toe die alleen zichtbaar is voor ingelogde gebruikers.</p>
        <a href="login.php">Uitloggen</a> <!-- Optie om uit te loggen -->
    </div>
</body>
</html>
