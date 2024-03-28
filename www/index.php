<?php
session_start();

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $wachtwoord = $_POST["wachtwoord"];

    require_once "database.php";

    $sql = "SELECT * FROM Gebruiker WHERE email='$email' AND wachtwoord='$wachtwoord'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION["logged_in"] = true;
        $_SESSION["email"] = $email;
        $_SESSION["rol"] = $user['rol'];
        header("Location: menu.php");
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
    <title>Welkom bij Restaurant Nova</title>
    <link rel="stylesheet" href="homestyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Welkom bij Restaurant Nova</h1>
        <div class="login-form">
            <h2>Inloggen</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="email"> email--adres:</label>
                <input type="email" id="email" name="email" required><br><br>
                <label for="wachtwoord">Wachtwoord:</label>
                <input type="password" id="wachtwoord" name="wachtwoord" required><br><br>
                <?php if (isset($error_message)) { ?>
                    <p class="error"><?php echo $error_message; ?></p>
                <?php } ?>
                <input type="submit" value="Inloggen">
                <p>Nog geen account? <a href="registratie.php">Registreer hier</a>.</p>
            </form>
        </div>
    </div>
</body>

</html>