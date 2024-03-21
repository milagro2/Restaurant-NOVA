<?php
session_start();


if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login.php");
    exit();
}

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
        <p>Dit is het dashboard van de applicatie.</p>
        <p>Voeg hier inhoud toe die alleen zichtbaar is voor ingelogde gebruikers.</p>
        <a href="index.php">Uitloggen</a>
    </div>
</body>
</html>
