<?php
    session_start();
    require_once("../php/pdo.php");
    require_once("../php/checklogin.php");
    if(isset($_POST["Delete"])){
        $imgid = $_POST["Delete"];
        $stmt = $conn->prepare("SELECT * FROM dogs WHERE id=:id");
        $stmt->bindParam(':id', $imgid);
        $stmt->execute();
        $row = $stmt->fetch();
        $imgdir = $row["dog_pic_dir"];
        if($row["user_id"] == $_SESSION["user"]){
            $stmt = $conn->prepare("DELETE FROM dogs WHERE id=:id");
            $stmt->bindParam(':id', $imgid);
            $stmt->execute();
            $row = $stmt->fetch();
            if($stmt->rowCount() == 0){
                $_SESSION["dog-message"] = $_SESSION["dog-message"] . "<p>Fout opgetreden.<br>Probeer het opnieuw of neem contact op met dinder.</p>";
                header("location: ../pages/mijn-hond.php");
                exit();
            }else{
                unlink($imgdir);
                $_SESSION["dog-message"] = $_SESSION["dog-message"] . "<p>Hond is verwijderd.</p>";
                header("location: ../pages/mijn-hond.php");
                exit();
            }
        }else{
            header("location: ../pages/login.php");
            exit();
        }
    }elseif(isset($_POST["edit-dog"])){
        header("Location: ../pages/bewerk-mijn-hond.php?hond=" . $_POST["edit-dog"]);
    }elseif(isset($_POST["change"])){
        $dogname = $_POST["name"];
        $race = $_POST["race"];
        $date = $_POST["date"];
        $description = $_POST["description"];
        $imgid = $_POST["dogID"];
        if($_FILES["image"]['size'] != 0){
            $image = $_FILES["image"];
            $imageName = $image["name"];
            $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
            // check for file size
            if ($image["size"] > 4000000) {
                $_SESSION["dog-message"] = $_SESSION["dog-message"] . "<p>Bestand te groot.</p>";
                header("location: ../pages/mijn-hond.php");
                exit();
            }
            // Allow certain file formats
            if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg") {
                $_SESSION["dog-message"] = $_SESSION["dog-message"] . "<p>Bestand mag alleen png, jpg of jpeg zijn.</p>";
                header("location: ../pages/mijn-hond.php");
                exit();
            }
            $imageupload = true;
        }else{
            $imageupload = false;
        }
        // check if fields are empty
        if(empty($race) || empty($dogname) || empty($description) || empty($date)){
            $_SESSION["dog-message"] = $_SESSION["dog-message"] . "<p>Vul alle velden in.</p>";
            header("location: ../pages/mijn-hond.php");
            exit();
        }
        // check if username is longer than 4 and only containts a-Z and numbers
        if(strlen($description)<1 || strlen($description)>255 || preg_match('/[^A-Za-z0-9]/', $description)){
            $_SESSION["register-message"] = $_SESSION["register-message"] . "<p>De Beschrijving voldoet niet aan de eisen.</p>";
            $register = false;
        }
        // check if username is longer than 4 and only containts a-Z and numbers
        if(strlen($dogname)<1 || strlen($dogname)>255 || preg_match('/[^A-Za-z0-9]/', $dogname)){
            $_SESSION["register-message"] = $_SESSION["register-message"] . "<p>De naam voldoet niet aan de eisen.</p>";
            $register = false;
        }
        if(strlen($race)<1 || strlen($race)>255 || preg_match('/[^A-Za-z0-9]/', $race)){
            $_SESSION["register-message"] = $_SESSION["register-message"] . "<p>Het ras voldoet niet aan de eisen.</p>";
            $register = false;
        }
        $stmt = $conn->prepare("SELECT * FROM dogs WHERE id=:id");
        $stmt->bindParam(':id', $imgid);
        $stmt->execute();
        $row = $stmt->fetch();
        if($row["user_id"] == $_SESSION["user"]){
            if($imageupload == true){
                unlink($row["dog_pic_dir"]);
                $directory = "../UserImages/".$_SESSION["user"]."/";
                $dbImageName = bin2hex(random_bytes(8));
                $dbImageDirectory = $directory . $dbImageName.".".$imageExtension;
                $content = file_get_contents($_FILES["image"]["tmp_name"]);
                $nameExists = true;
                while($nameExists){
                    if (!file_exists($directory.$dbImageName.".".$imageExtension)) {
                        file_put_contents($directory . $dbImageName.".".$imageExtension, $content);
                        $stmt = $conn->prepare("UPDATE dogs SET dog_birth_year=:dog_birth_year, dogname=:dogname, dog_race=:dog_race, dog_pic_dir=:dog_pic_dir, dog_description=:dog_description WHERE id=:id ");
                        // bind parameters
                        $stmt->bindParam(':dogname', $dogname);
                        $stmt->bindParam(':dog_description', $description);
                        $stmt->bindParam(':dog_birth_year', $date);
                        $stmt->bindParam(':dog_race', $race);
                        $stmt->bindParam(':dog_pic_dir', $dbImageDirectory);
                        $stmt->bindParam(':id', $imgid);
                        $stmt->execute();
                        $row = $stmt->fetch();
                        $_SESSION["dog-message"] = $_SESSION["dog-message"] . "<p>Hond Bewerkt.</p>";
                        header("location: ../pages/mijn-hond.php");
                        exit();
                    }else{
                        $dbImageName = bin2hex(random_bytes(8));
                        $dbImageDirectory = $directory . $dbImageName.".".$imageExtension;
                    }
                }
            }else{
                $stmt = $conn->prepare("UPDATE dogs SET dog_birth_year=:dog_birth_year, dogname=:dogname, dog_race=:dog_race, dog_description=:dog_description WHERE id=:id ");
                // bind parameters
                $stmt->bindParam(':dogname', $dogname);
                $stmt->bindParam(':dog_birth_year', $date);
                $stmt->bindParam(':dog_description', $description);
                $stmt->bindParam(':dog_race', $race);
                $stmt->bindParam(':id', $imgid);
                $stmt->execute();
                $row = $stmt->fetch();
                $_SESSION["dog-message"] = $_SESSION["dog-message"] . "<p>Hond Bewerkt.</p>";
                header("location: ../pages/mijn-hond.php");
                exit();
            }
        }else{
            header("location: ../pages/login.php");
            exit();
        }
    }elseif(isset($_POST["add"])){
        $dogname = $_POST["name"];
        $race = $_POST["race"];
        $date = $_POST["date"];
        $description = $_POST["description"];
        $image = $_FILES["image"];
        $imageName = $image["name"];
        $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
        // check if fields are empty
        if(empty($_FILES["image"]) || empty($race) || empty($dogname) || empty($date)){
            $_SESSION["dog-message"] = $_SESSION["dog-message"] . "<p>Vul alle velden in.</p>";
            header("location: ../pages/mijn-hond.php");
            exit();
        }
        // check for file size
        if ($image["size"] > 4000000) {
            $_SESSION["dog-message"] = $_SESSION["dog-message"] . "<p>Bestand te groot.</p>";
            header("location: ../pages/mijn-hond.php");
            exit();
        }
        // Allow certain file formats
        if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg") {
            $_SESSION["dog-message"] = $_SESSION["dog-message"] . "<p>Bestand mag alleen png, jpg of jpeg zijn.</p>";
            header("location: ../pages/mijn-hond.php");
            exit();
        }
        // check if username is longer than 4 and only containts a-Z and numbers
        if(strlen($name)<1 || strlen($name)>255 || preg_match('/[^A-Za-z0-9]/', $name)){
            $_SESSION["register-message"] = $_SESSION["register-message"] . "<p>De naam voldoet niet aan de eisen.</p>";
            $register = false;
        }
        if(strlen($description)<1 || strlen($description)>255 || preg_match('/[^A-Za-z0-9]/', $description)){
            $_SESSION["register-message"] = $_SESSION["register-message"] . "<p>Het ras voldoet niet aan de eisen.</p>";
            $register = false;
        }
        if(strlen($race)<1 || strlen($race)>255 || preg_match('/[^A-Za-z0-9]/', $race)){
            $_SESSION["register-message"] = $_SESSION["register-message"] . "<p>Het ras voldoet niet aan de eisen.</p>";
            $register = false;
        }
        // get user by id from database
        $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->bindParam(':id', $_SESSION["user"]);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row) {
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
                    $stmt = $conn->prepare("INSERT INTO dogs (dogname, dog_birth_year, dog_race, dog_pic_dir, user_id, dog_description) VALUES (:dogname, :dog_birth_year, :dog_race, :dog_pic_dir, :user_id, :dog_description)");
                    // bind parameters
                    $stmt->bindParam(':dog_description', $description);
                    $stmt->bindParam(':dogname', $dogname);
                    $stmt->bindParam(':dog_birth_year', $date);
                    $stmt->bindParam(':dog_race', $race);
                    $stmt->bindParam(':dog_pic_dir', $dbImageDirectory);
                    $stmt->bindParam(':user_id', $_SESSION["user"]);
                    $stmt->execute();
                    $row = $stmt->fetch();
                    $_SESSION["dog-message"] = $_SESSION["dog-message"] . "<p>Hond Toegevoegd.</p>";
                    header("location: ../pages/mijn-hond.php");
                    exit();
                }else{
                    $dbImageName = bin2hex(random_bytes(8));
                    $dbImageDirectory = $directory . $dbImageName.".".$imageExtension;
                }
            }
        }else{
            $_SESSION["dog-message"] = $_SESSION["dog-message"] . "<p>Er is een fout opgetreden, probeer het later opnieuw.</p>";
            header("location: ../pages/mijn-hond.php");
            exit();
        }
    }else{
        $_SESSION["dog-message"] = $_SESSION["dog-message"] . "<p>Fout opgetreden.<br>Probeer het opnieuw of neem contact op met dinder.</p>";
        header("location: ../pages/mijn-hond.php");
        exit();
    }
?>