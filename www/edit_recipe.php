<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'employee')) {
    header("Location: index.php");
    exit();
}

require_once "database.php";

// Check if recipe ID is provided
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["recipe_id"])) {
    // Sanitize and get the recipe ID
    $recipe_id = mysqli_real_escape_string($conn, $_GET["recipe_id"]);

    // Retrieve recipe details from the database
    $sql = "SELECT * FROM Product WHERE productID = '$recipe_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Recipe not found.";
        exit();
    }
} else {
    // If recipe ID is not provided, redirect to menu page
    header("Location: menu.php");
    exit();
}

// Update recipe details in the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = mysqli_real_escape_string($conn, $_POST["naam"]);
    $beschrijving = mysqli_real_escape_string($conn, $_POST["beschrijving"]);
    $inkoopprijs = $_POST["inkoopprijs"];
    $verkoopprijs = $_POST["verkoopprijs"];
    $afbeelding = mysqli_real_escape_string($conn, $_POST["afbeelding"]);
    $is_vega = isset($_POST["is_vega"]) ? 1 : 0;
    $categorie = mysqli_real_escape_string($conn, $_POST["categorie"]);
    $aantal_voorraad = $_POST["aantal_voorraad"];

    $sql = "UPDATE Product SET naam = '$naam', beschrijving = '$beschrijving', inkoopprijs = $inkoopprijs, verkoopprijs = $verkoopprijs, afbeelding = '$afbeelding', is_vega = $is_vega, categorie = '$categorie', aantal_voorraad = $aantal_voorraad WHERE productID = '$recipe_id'";

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
    <title>Wijzig recept</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php $title = "Wijzig recept"; ?>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1>Wijzig recept</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
            <label for="naam">Naam:</label><br>
            <input type="text" id="naam" name="naam" value="<?php echo $row['naam']; ?>" required><br><br>
            <label for="beschrijving">Beschrijving:</label><br>
            <textarea id="beschrijving" name="beschrijving" rows="4" required><?php echo $row['beschrijving']; ?></textarea><br><br>
            <label for="inkoopprijs">Inkoopprijs (€):</label><br>
            <input type="number" id="inkoopprijs" name="inkoopprijs" step="0.1" min="0" value="<?php echo $row['inkoopprijs']; ?>" required><br><br>
            <label for="verkoopprijs">Verkoopprijs (€):</label><br>
            <input type="number" id="verkoopprijs" name="verkoopprijs" step="0.1" min="0" value="<?php echo $row['verkoopprijs']; ?>" required><br><br>
            <label for="afbeelding">Afbeelding:</label><br>
            <input type="file" id="afbeelding" name="afbeelding" value="<?php echo $row['afbeelding']; ?>" required><br><br>
            <label for="is_vega">Vegan:</label><br>
            <input type="checkbox" id="is_vega" name="is_vega" <?php if ($row['is_vega'] == 1) echo "checked"; ?>><br><br>
            <label for="categorie">Categorie:</label><br>
            <select id="categorie" name="categorie" required>
                <option value="Voorgerecht" <?php if ($row['categorie'] == 'Voorgerecht') echo "selected"; ?>>Voorgerecht</option>
                <option value="Hoofdgerecht" <?php if ($row['categorie'] == 'Hoofdgerecht') echo "selected"; ?>>Hoofdgerecht</option>
                <option value="Dessert" <?php if ($row['categorie'] == 'Dessert') echo "selected"; ?>>Dessert</option>
                <option value="Drank" <?php if ($row['categorie'] == 'Drank') echo "selected"; ?>>Drank</option>
                <option value="Tussendoortje" <?php if ($row['categorie'] == 'Tussendoortje') echo "selected"; ?>>Tussendoortje</option>
            </select><br><br>
            <label for="aantal_voorraad">Aantal voorraad:</label><br>
            <input type="number" id="aantal_voorraad" name="aantal_voorraad" min="0" value="<?php echo $row['aantal_voorraad']; ?>" required><br><br>
            <input type="submit" value="Opslaan">
        </form>
    </div>
</body>

</html>