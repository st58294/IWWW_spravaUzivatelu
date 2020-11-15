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

function isPasswordSame($fPassword, $sPassword)
{
    if ($fPassword == $sPassword && empty($fPassword) == false) {
        return true;
    } else {
        echo "Passwords are not the same, or you left them empty. ";
        return false;
    }
}

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

if ($_SESSION["id_role"] == 1) {
    if ($_POST) {
        if (isPasswordSame($_POST["password"], $_POST["confirmPassword"]) && validateInput($_POST["userName"])) {
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $userName = $_POST["userName"];
                $password = $_POST["password"];
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare(
                    "UPDATE user SET name = :name , password = :password WHERE id = :id");

                $stmt->bindParam(':id', $_SESSION["id"]);
                $stmt->bindParam(':name', $userName);
                $stmt->bindParam(':password', $hashPassword);
                $_SESSION["name"] = $userName;

                $stmt->execute();
                echo "You have been successfully update your account.";
                header("Refresh:0");

            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        } else {
            for ($i = 1; $i < count($validation); $i++) {
                print_r($validation[i]);
            }
            print_r($validation[0]);
        }
    }
}

?>

<?php

if ($_SESSION["id_role"] == 1) {
    ?>
    <section class="formCenter">
        <form action="account.php" method="post">

            <div class="row">
                <label>Name: </label>
                <input name="userName" type="text" value="<?php echo $_SESSION["name"]; ?>">
            </div>
            <div class="row">
                <label>Password: </label>
                <input name="password" type="password">
            </div>

            <div class="row">
                <label>Confirm password </label>
                <input name="confirmPassword" type="password">
            </div>

            <div class="button">
                <input name="Save" type="submit" value="Save">
            </div>
        </form>
    </section>

    <?php

} else {
    ?>
    <section class='formCenter'>
        <form   style="padding-bottom: 10vw"       action="account.php" method="post">
            <table style='border: solid 1px black; margin: auto; text-align: center;'>
                <tr>
                    <th>Id</th>
                    <th>Username</th>
                    <th>email</th>
                </tr>

                <?php
                $i = 0;

                class TableRows extends RecursiveIteratorIterator{
                    private $id;
                    function __construct($it){
                        parent::__construct($it, self::LEAVES_ONLY);
                    }

                    function current(){
                        return "<td style='width:150px; font-size: 1vw;  border:1px solid black;'> " . parent::current() . "</td>";
                    }
                    function beginChildren(){
                        $this->id = parent::current();
                        echo "<tr>";
                    }
                    function endChildren(){
                        echo "<td><a href='editUser.php?id=$this->id' title='Editovat záznam'>&#x270e</a></td>" .
                            "<td><a href='deleteUser.php?id=$this->id' title='Vymazat záznam'>&#x1F5D1</a></td>" . "</tr>" . "\n";
                    }
                }


                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conn->prepare("SELECT id, name, email FROM user");
                    $stmt->execute();

                    // set the resulting array to associative
                    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

                    foreach (new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k => $v) {
                        echo $v;
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                $conn = null;
                ?>

            </table>
        </form>
    </section>

    <?php
}
include "footer.php";
?>

</body>
</html>