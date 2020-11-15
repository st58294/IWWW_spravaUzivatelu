<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="theme.css">
    <meta name="viewport"
          content="width=device-width,
          initial-scale=1.0">

</head>
<body>

<?php

include "menu.php";

$servername = "localhost";
$username = "root";
$password = "";
$db = "db_dev";
$validation[] = NULL;
$name = "";
$email= "";
function validateInput($string)
{
    echo $string;
    if (empty($string) == false) {
        return true;
    } else {
        echo "You cant have empty username. ";
        return false;
    }
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare(
        " SELECT name, email FROM user WHERE id = :id");
    $stmt->bindParam(':id', $_GET["id"]);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch();
        $name = $row["name"];
        $email = $row["email"];
        $_SESSION["edit_id"] = $_GET["id"];
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $userName = $_POST["userName"];
            $emailnew = $_POST["email"];

            echo $emailnew;
            echo $userName;
            echo $_SESSION["edit_id"];

            $stmt = $conn->prepare(
                "UPDATE user SET name = :name , email = :email WHERE id = :id");

            $stmt->bindParam(':id', $_SESSION["edit_id"]);
            $stmt->bindParam(':name', $userName);
            $stmt->bindParam(':email', $emailnew);
            $stmt->execute();
            echo "You have been successfully update your account.";
            header("Location: account.php");

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }



?>
<section class="formCenter">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <div class="row">
            <label>Name: </label>
            <input name="userName" type="text" value="<?php echo $name; ?>">
        </div>
        <div class="row">
            <label>Email: </label>
            <input name="email" type="email" value="<?php echo $email; ?>">
        </div>

        <div class="button">
            <input name="Save" type="submit" value="Save">
        </div>
    </form>
</section>

<?php
include "footer.php";
?>

</body>
</html>