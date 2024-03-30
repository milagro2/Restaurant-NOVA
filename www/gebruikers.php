<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'employee')) {
    header("Location: index.php");
    exit();
}

require_once "database.php";

// Handle deleting a user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user_id'])) {
    $user_id = $_POST['delete_user_id'];

    $delete_sql = "DELETE FROM Gebruiker WHERE gebruikerID = $user_id";
    if (mysqli_query($conn, $delete_sql)) {
        header("Refresh:0");
        exit();
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
}

// Handle adding a new user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $naam = $_POST['naam'];
    $adres = $_POST['adres'];
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord']; // You may want to hash the password for security
    $rol = $_POST['rol'];

    $insert_sql = "INSERT INTO Gebruiker (naam, adres, email, wachtwoord, rol) VALUES ('$naam', '$adres', '$email', '$wachtwoord', '$rol')";
    if (mysqli_query($conn, $insert_sql)) {
        header("Refresh:0");
        exit();
    } else {
        echo "Error adding user: " . mysqli_error($conn);
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


    input[type="text"],
    input[type="number"],
    input[type="password"],
    input[type="email"],
    textarea,
    select {
        width: 98%;
        padding: 1%;
        border: 1px solid #ffffff6e;
        border-radius: 5px;
        font-size: 1vw;
        background: #00000080;
        color: #fff;
        border: none;
        margin-top: 2%;
        margin-left: -8%;
    }

    button[type="submit"] {
        margin-left: -8%;
    }

    label {
        margin-left: -8%;
    }
</style>
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

        <!-- Add User Form -->
        <?php if ($_SESSION['rol'] === 'admin') : ?>
            <div class="add-user-form">
                <h3>Nieuwe gebruiker toevoegen</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <label for="naam">Naam:</label>
                    <input type="text" id="naam" name="naam" required><br><br>
                    <label for="adres">Adres:</label>
                    <input type="text" id="adres" name="adres" required><br><br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br><br>
                    <label for="wachtwoord">Wachtwoord:</label>
                    <input type="password" id="wachtwoord" name="wachtwoord" required><br><br>
                    <label for="rol">Rol:</label>
                    <select name="rol" id="rol" required>
                        <option value="admin">Admin</option>
                        <option value="employee">Employee</option>
                        <option value="customer">Customer</option>
                    </select><br><br>
                    <button type="submit" name="add_user">Toevoegen</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>