<?php
    session_start();
    require_once("../php/pdo.php");
    require_once("../php/checklogin.php");
    $stmt = $conn->prepare("SELECT * FROM users WHERE id!=:id AND id!=:idd ORDER BY RAND() LIMIT 1");
    $stmt->bindParam(':id', $_SESSION["user"]);
    $stmt->bindParam(':idd', $_POST["swiperight"]);
    $stmt->execute();
    $row = $stmt->fetch();
    if(isset($_POST["swiperight"])){
        $_SESSION["lastwag"] = $_POST["swiperight"];
        header("Location: ../pages/wag.php?user=" . $row["id"]);
        exit();
    }elseif(isset($_POST["swipeleft"])){
        $lastwag = $_SESSION["lastwag"];
        $_SESSION["lastwag"] = $_POST["swipeleft"];
        header("Location: ../pages/wag.php?user=" . $lastwag);
        exit();
    }
    $_SESSION["lastwag"] = $lastuser;
    header("Location: ../pages/wag.php");
    exit();
?>