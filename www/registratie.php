<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST["naam"];
    $email = $_POST["email"];
    $wachtwoord = $_POST["wachtwoord"];
    $adres = $_POST["adres"];
    $rol = $_POST["rol"];

    require_once "database.php";

    $sql = "INSERT INTO Gebruiker (naam, email, wachtwoord, adres, rol) VALUES ('$naam', '$email', '$wachtwoord', '$adres', '$rol')";

    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registratie</title>
    <link rel="stylesheet" href="homestyle.css">
</head>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">

<body>


    <div class="container">
        <h2>Registratie</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="naam">Naam:</label>
            <input type="text" id="naam" name="naam" required><br><br>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required><br><br>
            <label for="wachtwoord">Wachtwoord:</label>
            <input type="password" id="wachtwoord" name="wachtwoord" required><br><br>
            <label for="adres">Adres:</label>
            <input type="text" id="adres" name="adres" required><br><br>
            <label for="rol">Rol:</label>
            <select id="rol" name="rol">
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
                <option value="customer">Customer</option>
            </select><br><br>
            <input type="submit" value="Registreren">
            <p>Heb je al een account? <a href="index.php">Log hier in</a>.</p>
        </form>
    </div>




</body>

</html>