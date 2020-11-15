
<div id="menu">
    <a href="index.php" >Sp</a>
    <div>logo</div>
    <nav>
        <?php
        if (isset($_SESSION["loggin"]) == true) {
            echo '<a href="account.php" > '. $_SESSION["name"] .'</a>';
            echo '<a name="loggout"  href="logout.php">Logout</a>';
        } else {
            echo '<a href="login.php">Login</a>';
            echo '<a href="form.php">Register</a>';
        }
        ?>
    </nav>
</div>