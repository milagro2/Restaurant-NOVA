<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'employee')) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['recipe_id'])) {
    require_once "database.php";

    $recipe_id = mysqli_real_escape_string($conn, $_POST['recipe_id']);

    $stmt = $conn->prepare("DELETE FROM Product WHERE productID = ?");
    $stmt->bind_param("i", $recipe_id);

    if ($stmt->execute()) {
        header("Location: menu.php");
        exit();
    } else {
        echo "Error deleting recipe: " . $stmt->error;
    }

    $stmt->close();
    mysqli_close($conn);
} else {
    header("Location: menu.php");
    exit();
}
?>
