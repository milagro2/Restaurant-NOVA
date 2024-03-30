<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gebruikerID = $_SESSION['gebruikerID'];

    $sql = "DELETE FROM Gebruiker WHERE gebruikerID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $gebruikerID);

    if ($stmt->execute()) {
        session_destroy();
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting account: " . $stmt->error;
    }

    $stmt->close();
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account verwijderen</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h2>Weet je zeker dat je je account wilt verwijderen?</h2>
        <form method="post">
            <button type="submit">Ja, verwijder mijn account</button>
        </form>
    </div>
</body>

</html>
