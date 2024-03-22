<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link the dashboard CSS file -->
</head>

<body>

    <?php include 'navbar.php'; ?> <!-- Include the navbar -->

    <div class="dashboard-container">
        <h1 class="dashboard-title">Dashboard</h1>
        <?php
        for ($i = 0; $i < 30; $i++) {
            echo "<br>";
        }
        ?>
        <p>hello</p>
    </div>
</body>

</html>