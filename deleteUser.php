<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "db_dev";
$validation[] = NULL;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare(
        " DELETE FROM user WHERE id = :id");
    $stmt->bindParam(':id', $_GET["id"]);
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        header("location: account.php");
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>