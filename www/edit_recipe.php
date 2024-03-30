<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'employee')) {
    header("Location: index.php");
    exit();
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
    $is_vega = isset($_POST["is_vega"]) ? $_POST["is_vega"] : 0;
    $categorie = isset($_POST["categorie"]) ? mysqli_real_escape_string($conn, $_POST["categorie"]) : '';
    $aantal_voorraad = isset($_POST["aantal_voorraad"]) ? $_POST["aantal_voorraad"] : 0;

    // Check if a new image is uploaded
    if ($_FILES["afbeelding"]["size"] > 0) {
        // Handle file upload
        $afbeelding_name = $_FILES["afbeelding"]["name"];
        $afbeelding_tmp = $_FILES["afbeelding"]["tmp_name"];
        $afbeelding_path = "fotos/" . $afbeelding_name;
        move_uploaded_file($afbeelding_tmp, $afbeelding_path);
    } else {
        // Retain the existing image path
        $afbeelding_name = $row['afbeelding'];
    }

    $sql = "UPDATE Product SET naam=?, beschrijving=?, inkoopprijs=?, verkoopprijs=?, afbeelding=?, is_vega=?, categorie=?, aantal_voorraad=? WHERE productID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssddsiidi", $naam, $beschrijving, $inkoopprijs, $verkoopprijs, $afbeelding_name, $is_vega, $categorie, $aantal_voorraad, $recipe_id);

    if ($stmt->execute()) {
        header("Location: menu.php");
        exit;
    } else {
        echo "Error updating product: " . $stmt->error;
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
    <title>Edit Recipe</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 98%;
            padding: 1%;
            border: 1px solid #ffffff6e;
            border-radius: 5px;
            font-size: 1vw;
            background: #00000080;
            color: #fff;
        }


        input[type="submit"] {
            background-color: #ff9800;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 1.2% 46%;
            font-size: 1.4vw;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #f57c00;
            color: black;
        }

        select#categorie {
            width: 100%;
        }
    </style>
</head>

<body>
    <?php $title = "Edit Recipe"; ?>
    <?php include 'navbar.php'; ?>

    <div class="container">
    <form class="adding" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?recipe_id=" . $recipe_id); ?>" enctype="multipart/form-data">
            <label for="naam">Naam:</label><br>
            <input type="text" id="naam" name="naam" value="<?php echo $row['naam']; ?>" required><br><br>
            <label for="beschrijving">Beschrijving:</label><br>
            <textarea id="beschrijving" name="beschrijving" rows="4" required><?php echo $row['beschrijving']; ?></textarea><br><br>
            <label for="inkoopprijs">Inkoopprijs (€):</label><br>
            <input type="number" id="inkoopprijs" name="inkoopprijs" step="0.1" min="0" value="<?php echo $row['inkoopprijs']; ?>" required><br><br>
            <label for="verkoopprijs">Verkoopprijs (€):</label><br>
            <input type="number" id="verkoopprijs" name="verkoopprijs" step="0.1" min="0" value="<?php echo $row['verkoopprijs']; ?>" required><br><br>
            <label for="afbeelding">Afbeelding:</label><br>
            <input type="file" id="afbeelding" name="afbeelding">
            <p>Current Image: <?php echo $row['afbeelding']; ?></p>

            <br><br>

            <label for="is_vega">Vegan:</label>
            <br>
            <input type="checkbox" id="is_vega" name="is_vega" <?php echo $row['is_vega'] ? 'checked' : ''; ?>><br><br>
            <label for="categorie">Categorie:</label><br>
            <select id="categorie" name="categorie" required>
                <option value="Hoofdgerecht" <?php echo $row['categorie'] === 'Hoofdgerecht' ? 'selected' : ''; ?>>Hoofdgerecht</option>
                <option value="Dessert" <?php echo $row['categorie'] === 'Dessert' ? 'selected' : ''; ?>>Dessert</option>
                <option value="Drank" <?php echo $row['categorie'] === 'Drank' ? 'selected' : ''; ?>>Drank</option>
                <option value="Tussendoortje" <?php echo $row['categorie'] === 'Tussendoortje' ? 'selected' : ''; ?>>Tussendoortje</option>
            </select><br><br>
            <label for="aantal_voorraad">Aantal voorraad:</label><br>
            <input type="number" id="aantal_voorraad" name="aantal_voorraad" min="0" value="<?php echo $row['aantal_voorraad']; ?>" required><br><br>
            <input type="submit" value="Opslaan">
        </form>
    </div>

</body>

</html>