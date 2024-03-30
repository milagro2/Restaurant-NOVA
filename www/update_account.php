<?php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: index.php");
    exit();
}

require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_SESSION['gebruikerID'];
    
    $naam = $_POST['naam'];
    $adres = $_POST['adres'];
    $email = $_POST['email'];

    $sql = "UPDATE Gebruiker SET naam='$naam', adres='$adres', email='$email' WHERE gebruikerID=$userID";

    if (mysqli_query($conn, $sql)) {
        header("Location: account.php?update=success");
        exit();
    } else {
        header("Location: account.php?update=error");
        exit();
    }
} else {
    header("Location: account.php");
    exit();
}

mysqli_close($conn);
?>
