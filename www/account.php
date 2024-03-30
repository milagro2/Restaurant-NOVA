<?php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: index.php");
    exit();
}

require_once "database.php";

$userID = $_SESSION['gebruikerID'];
$sql = "SELECT * FROM Gebruiker WHERE gebruikerID = $userID";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "User not found";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    .container {
        max-width: 72%;
        margin: 2% 2%;
        background-color: #00000085;
        border-radius: 10px;
        margin-left: 22%;
    }

    form {
        margin-bottom: 2%;
        margin-left: 0%;
    }
</style>

<body>


    <?php $title = "Account"; ?>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h2>Accountinformatie</h2>
        <form action="update_account.php" method="post">
            <p><strong>Naam:</strong> <input type="text" name="naam" value="<?php echo $user['naam']; ?>"></p>
            <p><strong>Adres:</strong> <input type="text" name="adres" value="<?php echo $user['adres']; ?>"></p>
            <p><strong>Email:</strong> <input type="email" name="email" value="<?php echo $user['email']; ?>"></p>
            <p><strong>Rol:</strong> <?php echo $user['rol']; ?></p>
            <button type="submit">Opslaan</button>
        </form>

        <form action="delete_account.php" method="post" onsubmit="return confirm('Weet je zeker dat je jouw account wil verwijderen? Dit kan niet ongedaan worden gemaakt.');">
            <button type="submit">Account verwijderen</button>
        </form>
    </div>
</body>

</html>