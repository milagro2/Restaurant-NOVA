<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'employee')) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "database.php";

    $naam = mysqli_real_escape_string($conn, $_POST["naam"]);
    $beschrijving = mysqli_real_escape_string($conn, $_POST["beschrijving"]);
    $inkoopprijs = $_POST["inkoopprijs"];
    $verkoopprijs = $_POST["verkoopprijs"];
    $afbeelding = mysqli_real_escape_string($conn, $_POST["afbeelding"]);
    $is_vega = isset($_POST["is_vega"]) ? 1 : 0;
    $categorie = mysqli_real_escape_string($conn, $_POST["categorie"]);
    $aantal_voorraad = $_POST["aantal_voorraad"];
    $sql = "INSERT INTO Product (naam, beschrijving, inkoopprijs, verkoopprijs, afbeelding, is_vega, categorie, aantal_voorraad) VALUES ('$naam', '$beschrijving', $inkoopprijs, $verkoopprijs, '$afbeelding', $is_vega, '$categorie', $aantal_voorraad)";

    if (mysqli_query($conn, $sql)) {
        header("Location: menu.php");
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
    <title>Voeg recept toe aan menu</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php $title = "Voeg recept toe"; ?>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1>Voeg recept toe aan menu</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <label for="naam">Naam:</label><br>
            <input type="text" id="naam" name="naam" required><br><br>
            <label for="beschrijving">Beschrijving:</label><br>
            <textarea id="beschrijving" name="beschrijving" rows="4" required></textarea><br><br>
            <label for="inkoopprijs">Inkoopprijs (€):</label><br>
            <input type="number" id="inkoopprijs" name="inkoopprijs" step="0.01" min="0" required><br><br>
            <label for="verkoopprijs">Verkoopprijs (€):</label><br>
            <input type="number" id="verkoopprijs" name="verkoopprijs" step="0.01" min="0" required><br><br>
            <label for="afbeelding">Afbeelding:</label><br>
            <input type="file" id="afbeelding" name="afbeelding" required><br><br>
            <label for="is_vega">Vegan:</label>
            <input type="checkbox" id="is_vega" name="is_vega"><br><br>
            <label for="categorie">Categorie:</label><br>
            <select id="categorie" name="categorie" required>
                <option value="option1">Voorgerecht</option>
                <option value="option2">Hoofdgerecht</option>
                <option value="option3">Dessert</option>
                <option value="option4">Drank</option>
                <option value="option5">Tussendoortje</option>
            </select><br><br>
            <label for="aantal_voorraad">Aantal voorraad:</label><br>
            <input type="number" id="aantal_voorraad" name="aantal_voorraad" min="0" required><br><br>
            <input type="submit" value="Opslaan">
        </form>
    </div>

</body>

</html>