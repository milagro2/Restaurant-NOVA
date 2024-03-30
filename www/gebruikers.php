<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'employee')) {
    header("Location: index.php");
    exit();
}

require_once "database.php";

// Check if delete button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user_id'])) {
    $user_id = $_POST['delete_user_id'];

    // Delete user from the database
    $delete_sql = "DELETE FROM Gebruiker WHERE gebruikerID = $user_id";
    if (mysqli_query($conn, $delete_sql)) {
        // User deleted successfully
        header("Refresh:0"); // Refresh the page to reflect changes
        exit();
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM Gebruiker";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruikers</title>
    <link rel="stylesheet" href="styles.css">
</head>

<style>
    .container {
        max-width: 71%;
        margin: 2% 2%;
        background-color: #00000085;
        border-radius: 10px;
        margin-left: 23%;

    }
</style>

<body>
    <?php $title = "Gebruikers"; ?>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <table>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Adres</th>
                <th>Email</th>
                <th>Rol</th>
                <?php if ($_SESSION['rol'] === 'admin') : ?>
                    <th>Actie</th>
                <?php endif; ?>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['gebruikerID'] . "</td>";
                    echo "<td>" . $row['naam'] . "</td>";
                    echo "<td>" . $row['adres'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['rol'] . "</td>";
                    if ($_SESSION['rol'] === 'admin') {
                        echo '<td>';
                        echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post" onsubmit="return confirm(\'Weet je zeker dat je deze gebruiker wilt verwijderen?\');">';
                        echo '<input type="hidden" name="delete_user_id" value="' . $row["gebruikerID"] . '">';
                        echo '<button type="submit">Verwijderen</button>';
                        echo '</form>';
                        echo '</td>';
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Geen gebruikers gevonden.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>