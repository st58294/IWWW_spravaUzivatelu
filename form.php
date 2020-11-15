<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="theme.css">


</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "db_dev";
$validation[] = NULL;


if($_POST){
    if(empty($_POST["userName"])){
        $validation["userName"] = "Username is empty";
    }
    if(empty($_POST["email"])){
        $validation["email"] = "email is empty";
    }
    if(empty($_POST["password"])){
        $validation["password"] = "password is empty";
    }
        if(count($validation) <= 1){

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $userName = $_POST["userName"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt =   $conn->prepare("INSERT INTO user (name, email, password)
      VALUES ( :userName, :email, :password)");

        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashPassword );


        $stmt->execute();
        echo "You have been successfully registered. Please login to use our library ";

    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    }else {
            print_r($validation);
        }

}

include "menu.php"

?>


<section  class="formCenter" >
    <form action="form.php" method="post">


 <div class="row">
     <label>Name: </label>
     <input name="userName" type="text">
 </div>

     <div class="row">
         <label>Email: </label>
         <input name="email" type="email">

     </div>

    <div class="row">
        <label>Password: </label>
        <input name="password" type="password">
    </div>

    <div class="button" >
        <input name="submit" type="submit" value="Submit"  >
    </div><
    </form>
</section>
   <?php
   include "footer.php"

   ?>

</body>
</html>

<?php
// TO DO
//       <div class="row">
//            <label>Confirm password </label>
//            <input name="confirmPassword" type="password">
//        </div>
//
//    <div class="row">
//        <label>Agree with terms and services:  </label>
//        <input name="agreementWithServices" type="checkbox">
//    </div>

?>