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


    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php
include "menu.php";
$servername = "localhost";
$username = "root";
$password = "";
$db = "db_dev";


$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_POST) {

    $password_from_u = $_POST["password"];
    $email_from_u = trim($_POST["email"]);


    $sql = "SELECT id, id_role , name , password  FROM user WHERE email = :email";

    if (empty($email_from_u) == false && empty($password_from_u) == false) {
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bindParam(':email', $email_from_u);

            if ($stmt->execute()) {

                if ($stmt->rowCount() != 0) {
                    if ($row = $stmt->fetch()) {
                        $id_user = $row["id"];
                        $id_role = $row["id_role"];
                        $user = $row["name"];
                        $hash_pas = $row["password"];

                        if (password_verify($password_from_u, $hash_pas)) {
                            $_SESSION["loggin"] = true;
                            $_SESSION["id_role"] = $id_role;
                            $_SESSION["name"] = $user;
                            $_SESSION["id"] = $id_user;

                            header("Location: index.php");

                        } else {
                            echo "you NOT are logged in";

                        }

                    }
                }
            }
        }
    } else {
        echo "nebere to heslo";
    }
}


?>

<section class="formCenter">
    <form action="login.php" method="post">

        <div class="row">
            <label>Email: </label>
            <input name="email" type="email">

        </div>

        <div class="row">
            <label>Password: </label>
            <input name="password" type="password">
        </div>

        <div class="button">
            <input name="login" type="submit"
                   value="login">
        </div>
        <
    </form>
</section>
<?php
include "footer.php"

?>
</body>
</html>