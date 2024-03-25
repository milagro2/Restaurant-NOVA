<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <?php $title = "Menu"; ?>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1>Menu</h1>
        <?php
        // Database connection
        require_once "database.php";

        // Query to select all recipes
        $sql = "SELECT * FROM Product";
        $result = mysqli_query($conn, $sql);

        // Check if there are any recipes
        if (mysqli_num_rows($result) > 0) {
            // Output data of each recipe
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="recipe">';
                echo '<h2>' . $row["naam"] . '</h2>';
                echo '<p><strong>Beschrijving:</strong> ' . $row["beschrijving"] . '</p>';
                echo '<p><strong>Inkoopprijs:</strong> €' . $row["inkoopprijs"] . '</p>';
                echo '<p><strong>Verkoopprijs:</strong> €' . $row["verkoopprijs"] . '</p>';
                echo '<p><strong>Vegan:</strong> ' . ($row["is_vega"] ? "Ja" : "Nee") . '</p>';
                echo '<p><strong>Categorie:</strong> ' . $row["categorie"] . '</p>';
                echo '<p><strong>Aantal voorraad:</strong> ' . $row["aantal_voorraad"] . '</p>';
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