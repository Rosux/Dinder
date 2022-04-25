<?php
    session_start();
    require_once("../php/pdo.php");
    require_once("../php/checklogin.php");
    unset($_SESSION["settings-message"]);
    // info setup
    $name = $_POST["username"];
    $desc = $_POST["description"];
    // check if fields are empty
    if(empty($_POST["username"])){
        $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>Gebruikersnaam kan niet leeg zijn</p>";
        header("location: ../pages/instellingen.php");
        exit();
    }
    // check if username is longer than 4 and only containts a-Z and numbers
    if(strlen($name)<4 || strlen($name)>30 || preg_match('/[^A-Za-z0-9]/', $name)){
        $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>De gebruikersnaam voldoet niet aan de eisen.</p>";
        header("location: ../pages/instellingen.php");
        exit();
    }
    if(strlen($desc) > 255){
        $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>De beschrijving is te lang.</p>";
        header("location: ../pages/instellingen.php");
        exit();
    }
    // inset stuff into db
    // UPDATE users SET name=:name, surname=:surname, sex=:sex WHERE id=:id
    $stmt = $conn->prepare("UPDATE users SET Description=:desc, Username=:username WHERE id=:id");
    $stmt->bindParam(':desc', $desc);
    $stmt->bindParam(':username', $name);
    $stmt->bindParam(':id', $_SESSION["user"]);
    $stmt->execute();
    if($stmt->rowCount() == 0){
        $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>Fout opgetreden.<br>Probeer het opnieuw of neem contact op met dinder.</p>";
    }
    header("location: ../pages/instellingen.php");
    exit();
?>