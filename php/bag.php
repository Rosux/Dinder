<?php
    session_start();
    require_once("../php/pdo.php");
    require_once("../php/checklogin.php");
    // info setup
    if(isset($_POST["delete"])){
        $id = $_POST["delete"];
    }elseif(isset($_POST["accept"])){
        $id = $_POST["accept"];
    }else{
        header("location: ../pages/bag.php");
        exit();
    }
    // get user by id from database
    $stmt = $conn->prepare("SELECT * FROM messages WHERE id=:id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch();
    $acceptance = !$row["accepted"];
    if ($row) {
        if($row["sender_id"] == $_SESSION["user"] || $row["receiver_id"] == $_SESSION["user"]){
            if(isset($_POST["delete"])){
                $del = $conn->prepare("DELETE FROM messages WHERE id=:id");
                $del->bindParam(':id', $id);
                $del->execute();
                $_SESSION["bag-message"] = $_SESSION["bag-message"] . "<p>Bericht verwijderd.</p>";
            }elseif(isset($_POST["accept"])){
                $update = $conn->prepare("UPDATE messages SET accepted=:acceptance WHERE id=:id");
                $update->bindParam(':acceptance', $acceptance);
                $update->bindParam(':id', $id);
                $update->execute();
                if($acceptance){
                    $_SESSION["bag-message"] = $_SESSION["bag-message"] . "<p>Bericht geacepteerd.</p>";
                }else{
                    $_SESSION["bag-message"] = $_SESSION["bag-message"] . "<p>Bericht geanuleerd.</p>";
                }
            }
        }else{
            $_SESSION["bag-message"] = $_SESSION["bag-message"] . "<p>Er is een fout opgetreden, probeer het later opnieuw.</p>";
        }
    }else{
        $_SESSION["bag-message"] = $_SESSION["bag-message"] . "<p>Er is een fout opgetreden, probeer het later opnieuw.</p>";
    }
    header("location: ../pages/bag.php");
    exit();
?>