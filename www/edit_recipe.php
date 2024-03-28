<?php
session_start();

if ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'employee') {
    exit("Unauthorized access");
}

require_once "database.php";

if (!isset($_GET["recipe_id"])) {
    exit("Recipe ID is missing");
}

$recipe_id = $_GET["recipe_id"];

$sql = "SELECT * FROM Product WHERE productID = $recipe_id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    exit("Product details not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = isset($_POST["naam"]) ? mysqli_real_escape_string($conn, $_POST["naam"]) : '';
    $beschrijving = isset($_POST["beschrijving"]) ? mysqli_real_escape_string($conn, $_POST["beschrijving"]) : '';
    $inkoopprijs = isset($_POST["inkoopprijs"]) ? $_POST["inkoopprijs"] : 0;
    $verkoopprijs = isset($_POST["verkoopprijs"]) ? $_POST["verkoopprijs"] : 0;
    $afbeelding = isset($_POST["afbeelding"]) ? mysqli_real_escape_string($conn, $_POST["afbeelding"]) : '';
    $is_vega = isset($_POST["is_vega"]) ? $_POST["is_vega"] : 0;
    $categorie = isset($_POST["categorie"]) ? mysqli_real_escape_string($conn, $_POST["categorie"]) : '';
    $aantal_voorraad = isset($_POST["aantal_voorraad"]) ? $_POST["aantal_voorraad"] : 0;

    $sql = "UPDATE Product SET naam='$naam', beschrijving='$beschrijving', inkoopprijs=$inkoopprijs, verkoopprijs=$verkoopprijs, afbeelding='$afbeelding', is_vega=$is_vega, categorie='$categorie', aantal_voorraad=$aantal_voorraad WHERE productID = $recipe_id";

    if (mysqli_query($conn, $sql)) {
        header("Location: menu.php");
        exit;
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php $title = "Edit Recipe"; ?>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2>Edit Recipe</h2>
        <form action="edit_recipe.php?recipe_id=<?php echo $recipe_id; ?>" method="post">
            <label for="naam">Naam:</label><br>
            <input type="text" id="naam" name="naam" value="<?php echo $row['naam']; ?>"><br>
            <label for="beschrijving">Beschrijving:</label><br>
            <textarea id="beschrijving" name="beschrijving"><?php echo $row['beschrijving']; ?></textarea><br>
            <label for="inkoopprijs">Inkoopprijs:</label><br>
            <input type="text" id="inkoopprijs" name="inkoopprijs" value="<?php echo $row['inkoopprijs']; ?>"><br>
            <label for="verkoopprijs">Verkoopprijs:</label><br>
            <input type="text" id="verkoopprijs" name="verkoopprijs" value="<?php echo $row['verkoopprijs']; ?>"><br>
            <label for="afbeelding">Afbeelding:</label><br>
            <input type="text" id="afbeelding" name="afbeelding" value="<?php echo $row['afbeelding']; ?>"><br>
            <label for="is_vega">Is Vegan:</label><br>
            <input type="text" id="is_vega" name="is_vega" value="<?php echo $row['is_vega']; ?>"><br>
            <label for="categorie">Categorie:</label><br>
            <input type="text" id="categorie" name="categorie" value="<?php echo $row['categorie']; ?>"><br>
            <label for="aantal_voorraad">Aantal Voorraad:</label><br>
            <input type="text" id="aantal_voorraad" name="aantal_voorraad" value="<?php echo $row['aantal_voorraad']; ?>"><br><br>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>

</html>