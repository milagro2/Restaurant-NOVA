<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $wachtwoord = $_POST["wachtwoord"];

    require_once "database.php";

    // check of gebruiker bestaat
    $sql = "SELECT * FROM Gebruiker WHERE email='$email' AND wachtwoord='$wachtwoord'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION["logged_in"] = true;
        $_SESSION["email"] = $email;
        header("Location: index.php");
        exit();
    } else {

        $error_message = "Ongeldige e-mail of wachtwoord. Probeer opnieuw.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h2>Inloggen</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required><br><br>
            <label for="wachtwoord">Wachtwoord:</label>
            <input type="password" id="wachtwoord" name="wachtwoord" required><br><br>
            <?php if (isset($error_message)) { ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php } ?>
            <input type="submit" value="Inloggen">
        </form>
        <p>Nog geen account? <a href="registratie.php">Registreer hier</a>.</p>
    </div>
</body>

</html>