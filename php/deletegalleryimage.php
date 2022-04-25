<?php
    session_start();
    require_once("../php/pdo.php");
    require_once("../php/checklogin.php");
    if(isset($_POST["Delete"])){
        $imgid = $_POST["Delete"];
        $stmt = $conn->prepare("SELECT * FROM gallery WHERE id=:id");
        $stmt->bindParam(':id', $imgid);
        $stmt->execute();
        $row = $stmt->fetch();
        $imgdir = $row["image_dir"];
        if($row["image_id"] == $_SESSION["user"]){
            $stmt = $conn->prepare("DELETE FROM gallery WHERE id=:id");
            $stmt->bindParam(':id', $imgid);
            $stmt->execute();
            $row = $stmt->fetch();
            if($stmt->rowCount() == 0){
                $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>Fout opgetreden.<br>Probeer het opnieuw of neem contact op met dinder.</p>";
                header("location: ../pages/instellingen.php");
                exit();
            }else{
                unlink($imgdir);
                $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>Foto is verwijderd.</p>";
                header("location: ../pages/instellingen.php");
                exit();
            }
        }else{
            header("location: ../pages/login.php");
            exit();
        }
    }else{
        $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>Fout opgetreden.<br>Probeer het opnieuw of neem contact op met dinder.</p>";
        header("location: ../pages/instellingen.php");
        exit();
    }
?>