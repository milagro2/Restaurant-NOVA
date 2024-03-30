<nav>
    <h1><?php echo $title; ?></h1>
    <ul>
        <li><a href="menu.php">Menu</a></li>
        <li><a href="#">Reserveren</a></li>
        <li class="rol">Uw rol is:</li>
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) : ?>

            <?php if ($_SESSION['rol'] === 'admin') : ?>
                <li class="role">Admin</li>
                <li><a href="addrecipe.php">Gerecht toevoegen</a></li>
                <li><a href="gebruikers.php">Gebruikers</a></li>

            <?php elseif ($_SESSION['rol'] === 'employee') : ?>
                <li class="role">Employee</a></li>
                <li><a href="addrecipe.php">Gerecht toevoegen</a></li>
                <li><a href="gebruikers.php">Gebruikers</a></li>
                
                <?php elseif ($_SESSION['rol'] === 'customer') : ?>
                    <li class="role">Customer</a></li>

            <?php endif; ?>
            <li><a href="index.php">Uitloggen</a></li>

        <?php else : ?>
            <li><a href="index.php">Inloggen</a></li>
        <?php endif; ?>
    </ul>
</nav>