<?php
    session_start();
    require_once("../php/pdo.php");
    require_once("../php/checklogin.php");
    unset($_SESSION["profile-upload-message"]);
    // info setup
    $image = $_FILES["image"];
    $imageName = $image["name"];
    $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
    // check if fields are empty
    if(empty($_FILES["image"])){
        $_SESSION["profile-upload-message"] = $_SESSION["profile-upload-message"] . "<p>Vul alle velden in.</p>";
        header("location: ../pages/profile.php?user=" . $_SESSION["user"]);
        exit();
    }
    // check for file size
    if ($image["size"] > 4000000) {
        $_SESSION["profile-upload-message"] = $_SESSION["profile-upload-message"] . "<p>Bestand te groot.</p>";
        header("location: ../pages/profile.php?user=" . $_SESSION["user"]);
        exit();
    }
    // Allow certain file formats
    if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg") {
        $_SESSION["profile-upload-message"] = $_SESSION["profile-upload-message"] . "<p>Bestand mag alleen png, jpg of jpeg zijn.</p>";
        header("location: ../pages/profile.php?user=" . $_SESSION["user"]);
        exit();
    }
    // get user by email from database
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
    $stmt->bindParam(':id', $_SESSION["user"]);
    $stmt->execute();
    $row = $stmt->fetch();
    if ($row) {
        // user exists
        if($row["active"] != 1){
            header("location: ../pages/Verifieren.php");
            exit();
        }else{
            // everything is clear upload img
            if (!file_exists("../UserImages/" . $_SESSION["user"])) {
                mkdir("../UserImages/" . $_SESSION["user"]);
            }
            $directory = "../UserImages/".$_SESSION["user"]."/";
            $dbImageName = bin2hex(random_bytes(8));
            $dbImageDirectory = $directory . $dbImageName.".".$imageExtension;
            $content = file_get_contents($_FILES["image"]["tmp_name"]);
            $nameExists = true;
            while($nameExists){
                if (!file_exists($directory.$dbImageName.".".$imageExtension)) {
                    file_put_contents($directory . $dbImageName.".".$imageExtension, $content);
                    $stmt = $conn->prepare("INSERT INTO gallery (image_id, image_dir, created) VALUES (:image_id, :image_dir, CURRENT_TIMESTAMP())");
                    // bind parameters
                    $stmt->bindParam(':image_id', $_SESSION["user"]);
                    $stmt->bindParam(':image_dir', $dbImageDirectory);
                    $stmt->execute();
                    $row = $stmt->fetch();
                    $_SESSION["profile-upload-message"] = $_SESSION["profile-upload-message"] . "<p>Foto geupload.</p>";
                    header("location: ../pages/profile.php?user=" . $_SESSION["user"]);
                    exit();
                }else{
                    $dbImageName = bin2hex(random_bytes(8));
                    $dbImageDirectory = $directory . $dbImageName.".".$imageExtension;
                }
            }
        }
    }else{
        $_SESSION["profile-upload-message"] = $_SESSION["profile-upload-message"] . "<p>Er is een fout opgetreden, probeer het later opnieuw.</p>";
        header("location: ../pages/profile.php?user=" . $_SESSION["user"]);
        exit();
    }
?>