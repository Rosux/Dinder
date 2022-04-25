<?php
    // this file is for checking if user is logged in
    if(!isset($_SESSION["user"])){
        header("location: ../pages/login.php");
        exit();
    }
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
    $stmt->bindParam(':id', $_SESSION["user"]);
    $stmt->execute();
    $row = $stmt->fetch();
    $loginToken = $row["login_token"];
    if (!password_verify($_COOKIE["Dinder__Token"], $loginToken)) {
        // user can login
        header("location: ../pages/login.php");
        exit();
    }
    if($row["active"] != 1){
        header("location: ../pages/Verifieren.php");
        exit();
    }
?>