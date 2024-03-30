<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'employee')) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "database.php";

    $naam = $_POST["naam"];
    $beschrijving = $_POST["beschrijving"];
    $inkoopprijs = $_POST["inkoopprijs"];
    $verkoopprijs = $_POST["verkoopprijs"];

    $afbeelding_name = $_FILES["afbeelding"]["name"];
    $afbeelding_tmp = $_FILES["afbeelding"]["tmp_name"];
    $afbeelding_path = "fotos/" . $afbeelding_name;
    move_uploaded_file($afbeelding_tmp, $afbeelding_path);

    $is_vega = isset($_POST["is_vega"]) ? 1 : 0;
    $categorie = $_POST["categorie"];
    $aantal_voorraad = $_POST["aantal_voorraad"];

    $sql = "INSERT INTO Product (naam, beschrijving, inkoopprijs, verkoopprijs, afbeelding, is_vega, categorie, aantal_voorraad) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssddsiid", $naam, $beschrijving, $inkoopprijs, $verkoopprijs, $afbeelding_name, $is_vega, $categorie, $aantal_voorraad);

    if ($stmt->execute()) {
        header("Location: menu.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
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
    <title>Voeg recept toe aan menu</title>
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
    </style>
</head>

<body>
    <?php $title = "Voeg gerecht toe"; ?>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <form class="adding" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <label for="naam">Naam:</label><br>
            <input type="text" id="naam" name="naam" required><br><br>
            <label for="beschrijving">Beschrijving:</label><br>
            <textarea id="beschrijving" name="beschrijving" rows="4" required></textarea><br><br>
            <label for="inkoopprijs">Inkoopprijs (€):</label><br>
            <input type="number" id="inkoopprijs" name="inkoopprijs" step="0.1" min="0" required><br><br>
            <label for="verkoopprijs">Verkoopprijs (€):</label><br>
            <input type="number" id="verkoopprijs" name="verkoopprijs" step="0.1" min="0" required><br><br>
            <label for="afbeelding">Afbeelding:</label><br>
            <input type="file" id="afbeelding" name="afbeelding" required><br><br>
            <label for="is_vega">Vegan:</label>
            <br>
            <input type="checkbox" id="is_vega" name="is_vega"><br><br>
            <label for="categorie">Categorie:</label><br>
            <select id="categorie" name="categorie" required>
                <option value="">Selecteer categorie</option>
                <option value="Voorgerecht">Voorgerecht</option>
                <option value="Hoofdgerecht">Hoofdgerecht</option>
                <option value="Dessert">Dessert</option>
                <option value="Drank">Drank</option>
                <option value="Tussendoortje">Tussendoortje</option>
            </select>

            <br><br>
            <label for="aantal_voorraad">Aantal voorraad:</label><br>
            <input type="number" id="aantal_voorraad" name="aantal_voorraad" min="0" required><br><br>
            <input type="submit" value="Opslaan">
        </form>
    </div>

</body>

</html>