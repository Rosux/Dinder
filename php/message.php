<?php
    session_start();
    require_once("../php/pdo.php");
    require_once("../php/checklogin.php");
    // info setup
    $reciever = $_POST["reciever"];
    $sender = $_SESSION["user"];
    $message = $_POST["message"];
    // check if field is empty
    if(strlen($message) > 255 || strlen($message) < 1){
        $_SESSION["msg-message"] = $_SESSION["msg-message"] . "<p>Vul een bericht in.</p>";
        $_SESSION["openmenu"] = true;
        header("location: ../pages/wag.php?user=" . $reciever);
        exit();
    }
    
    // get user by id from database
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
    $stmt->bindParam(':id', $reciever);
    $stmt->execute();
    $row = $stmt->fetch();
    if ($row) {
        // everything is clear upload message
        $stmt = $conn->prepare("INSERT INTO messages (message, sender_id, receiver_id) VALUES (:message, :sender_id, :receiver_id)");
        // bind parameters
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':sender_id', $sender);
        $stmt->bindParam(':receiver_id', $reciever);
        $stmt->execute();
        $row = $stmt->fetch();
        $_SESSION["msg-message"] = $_SESSION["msg-message"] . "<p>Bericht verzonden.</p>";
        $_SESSION["openmenu"] = true;
        header("location: ../pages/wag.php?user=" . $reciever);
        exit();
    }else{
        $_SESSION["msg-message"] = $_SESSION["msg-message"] . "<p>Er is een fout opgetreden, probeer het later opnieuw.</p>";
        $_SESSION["openmenu"] = true;
        header("location: ../pages/wag.php?user=" . $reciever);
        exit();
    }
?>