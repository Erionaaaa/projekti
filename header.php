<?php
session_start();
?>
<header>
    <h1>Bag Boutique</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="per-ne.php">Per Ne</a></li>
            <li><a href="produktet.php">Produktet</a></li>
            <li><a href="news.php">Te rejat</a></li>
            <li><a href="kontakt.php">Na Kontaktoni</a></li>
        </ul>

        <ul>
            <?php
            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                echo '<li>' . htmlspecialchars($_SESSION["email"]) . '</li>';
                echo '<li><a href="logout.php">Dilni</a></li>';
            } else {
                echo '<li><a href="login.php">Kyçuni</a></li>';
                echo '<li><a href="register.php">Regjistrohuni</a></li>';
            }
            ?>
        </ul>
    </nav>
</header>
