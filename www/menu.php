<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="styles.css">
    <style>


    </style>
</head>

<body>

    <?php $title = "Menu"; ?>
    <?php include 'navbar.php'; ?>

    <div class="container">

        <?php
        // Database connection
        require_once "database.php";

        $sql = "SELECT * FROM Product";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="recipe">';
                echo '<div class="recipe-details">';
                echo '<h2>' . $row["naam"] . '</h2>';
                echo '<p><strong>Beschrijving:</strong> ' . $row["beschrijving"] . '</p>';
                echo '<p><strong>Inkoopprijs:</strong> €' . $row["inkoopprijs"] . '</p>';
                echo '<p><strong>Verkoopprijs:</strong> €' . $row["verkoopprijs"] . '</p>';
                echo '<p><strong>Vegan:</strong> ' . ($row["is_vega"] ? "Ja" : "Nee") . '</p>';
                echo '<p><strong>Categorie:</strong> ' . $row["categorie"] . '</p>';
                echo '<p><strong>Aantal voorraad:</strong> ' . $row["aantal_voorraad"] . '</p>';
                echo '</div>';
                echo '<img src="fotos/' . $row["afbeelding"] . '" alt="' . $row["naam"] . '">';
                echo '</div>';
            }
        } else {
            echo "<p>Geen recepten gevonden.</p>";
        }

        // Close database connection
        mysqli_close($conn);
        ?>
    </div>

</body>

</html>