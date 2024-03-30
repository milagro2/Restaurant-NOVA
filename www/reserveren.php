<?php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || ($_SESSION['rol'] !== 'admin' && $_SESSION['rol'] !== 'employee')) {
    header("Location: index.php");
    exit();
}

require_once "database.php";

$datum = $tijd = $aantal = $tafelnummer = "";
$datum_err = $tijd_err = $aantal_err = $tafelnummer_err = "";

$reservations = [];
$sql = "SELECT * FROM Reservering";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reservations[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["datum"]))) {
        $datum_err = "Please enter the date.";
    } else {
        $datum = trim($_POST["datum"]);
    }

    if (empty(trim($_POST["tijd"]))) {
        $tijd_err = "Please enter the time.";
    } else {
        $tijd = trim($_POST["tijd"]);
    }

    if (empty(trim($_POST["aantal"]))) {
        $aantal_err = "Please enter the number of people.";
    } else {
        $aantal = trim($_POST["aantal"]);
    }

    if (empty(trim($_POST["tafelnummer"]))) {
        $tafelnummer_err = "Please enter the table number.";
    } else {
        $tafelnummer = trim($_POST["tafelnummer"]);
    }

    if (empty($datum_err) && empty($tijd_err) && empty($aantal_err) && empty($tafelnummer_err)) {
        $sql = "INSERT INTO Reservering (datum, tijd, aantal, tafelnummer, gebruikerID) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssiii", $param_datum, $param_tijd, $param_aantal, $param_tafelnummer, $param_gebruikerID);

            $param_datum = $datum;
            $param_tijd = $tijd;
            $param_aantal = $aantal;
            $param_tafelnummer = $tafelnummer;
            $param_gebruikerID = $_SESSION['gebruikerID'];

            if (mysqli_stmt_execute($stmt)) {
                header("Location: menu.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserveren</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .form-container {
            max-width: 98%;
            background-color: #00000085;
            border-radius: 10px;
            margin-left: 8%;
            padding-top: 1%;
        }

        .form-group {
            margin-bottom: 2%;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 0.4%;
            margin-left: -4%;
            margin-top: 1%;
        }

        .form-group input[type="date"],
        .form-group input[type="time"],
        .form-group input[type="number"] {
            width: 98%;
            padding: 1%;
            border: 1px solid #ffffff6e;
            border-radius: 5px;
            font-size: 1vw;
            background: #00000080;
            color: #fff;
            border: none;
            margin-top: 2%;
            margin-left: -5%;
        }

        .form-group input[type="submit"] {
            padding: 1% 0%;
            width: 100%;
            background-color: #ff5900;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1vw;
            transition: background-color 0.5s ease;
            margin-left: -5%;
            margin-bottom: 4%;
        }

        .form-group input[type="submit"]:hover {
            background-color: #ff3100;
        }

        table {
            width: 92%;
            border-collapse: collapse;
            margin-left: 8%;
        }

        h2 {
            margin-left: 8%;
        }
    </style>
</head>

<body>
    <?php $title = "Reserveren"; ?>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="form-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="datum">Datum</label>
                    <input type="date" id="datum" name="datum" value="<?php echo $datum; ?>">
                    <span class="error"><?php echo $datum_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="tijd">Tijd</label>
                    <input type="time" id="tijd" name="tijd" value="<?php echo $tijd; ?>">
                    <span class="error"><?php echo $tijd_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="aantal">Aantal personen</label>
                    <input type="number" id="aantal" name="aantal" value="<?php echo $aantal; ?>">
                    <span class="error"><?php echo $aantal_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="tafelnummer">Tafelnummer</label>
                    <input type="number" id="tafelnummer" name="tafelnummer" value="<?php echo $tafelnummer; ?>">
                    <span class="error"><?php echo $tafelnummer_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" value="Reserveren">
                </div>

            </form>
        </div>

        <div class="reservations-container">
            <h2>Bestaande reserveringen</h2>
            <table>
                <tr>
                    <th>Reservering ID</th>
                    <th>Datum</th>
                    <th>Tijd</th>
                    <th>Aantal Personen</th>
                    <th>Tafelnummer</th>
                </tr>
                <?php foreach ($reservations as $reservation) : ?>
                    <tr>
                        <td><?php echo $reservation['reserveringID']; ?></td>
                        <td><?php echo $reservation['datum']; ?></td>
                        <td><?php echo $reservation['tijd']; ?></td>
                        <td><?php echo $reservation['aantal']; ?></td>
                        <td><?php echo $reservation['tafelnummer']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>

</html>