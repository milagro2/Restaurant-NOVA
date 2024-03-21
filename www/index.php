<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welkom bij Restaurant Nova</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>Welkom bij Restaurant Nova</h1>
        <div class="login-form">
            <h2>Inloggen</h2>
            <form method="post" action="login.php">
                <input type="email" name="email" placeholder="E-mailadres" required><br>
                <input type="password" name="wachtwoord" placeholder="Wachtwoord" required><br>
                <input type="submit" value="Inloggen">
            </form>
            <p>Nog geen account? <a href="registratie.php">Registreer hier</a>.</p>
        </div>
    </div>
</body>

</html>
