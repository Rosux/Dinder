<?php
    session_start();
    require_once("../php/pdo.php");
    require_once("../php/checklogin.php");
    unset($_SESSION["settings-message"]);
    // info setup
    $image = $_FILES["image"];
    $imageName = $image["name"];
    $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
    // check if fields are empty
    if(empty($_FILES["image"])){
        $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>Vul alle velden in.</p>";
        header("location: ../pages/instellingen.php");
        exit();
    }
    // check for file size
    if ($image["size"] > 4000000) {
        $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>Bestand te groot.</p>";
        header("location: ../pages/instellingen.php");
        exit();
    }
    // Allow certain file formats
    if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg") {
        $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>Bestand mag alleen png, jpg of jpeg zijn.</p>";
        header("location: ../pages/instellingen.php");
        exit();
    }
    // get user by id from database
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
    $stmt->bindParam(':id', $_SESSION["user"]);
    $stmt->execute();
    $row = $stmt->fetch();
    if ($row) {
        // everything is clear upload img
        unlink($row["profile_pic_dir"]);
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
                $stmt = $conn->prepare("UPDATE users SET profile_pic_dir=:image_dir WHERE id=:id");
                // bind parameters
                $stmt->bindParam(':id', $_SESSION["user"]);
                $stmt->bindParam(':image_dir', $dbImageDirectory);
                $stmt->execute();
                $row = $stmt->fetch();
                $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>Foto geupload.</p>";
                header("location: ../pages/instellingen.php");
                exit();
            }else{
                $dbImageName = bin2hex(random_bytes(8));
                $dbImageDirectory = $directory . $dbImageName.".".$imageExtension;
            }
        }
    }else{
        $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>Er is een fout opgetreden, probeer het later opnieuw.</p>";
        header("location: ../pages/instellingen.php");
        exit();
    }
?>