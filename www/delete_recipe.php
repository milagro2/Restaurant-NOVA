<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'employee')) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['recipe_id'])) {
    require_once "database.php";

    $recipe_id = $_POST['recipe_id'];

    // gerecht verwijderen
    $sql = "DELETE FROM Product WHERE productID = $recipe_id";

    if (mysqli_query($conn, $sql)) {
        header("Location: menu.php");
        exit();
    } else {
        echo "Error deleting recipe: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    header("Location: menu.php");
    exit();
}
?>
