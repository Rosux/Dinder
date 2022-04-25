<?php
    session_start();
    require_once("../php/pdo.php");
    unset($_SESSION["settings-message"]);
    // info setup
    $newpass = $_POST["newpassword"];
    $oldpass = $_POST["oldpassword"];
    // check if fields are empty

    if(empty($newpass) || empty($oldpass)){
        $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>Vul alle velden in.</p>";
        header("location: ../pages/instellingen.php");
        exit();
    }
    // check if password is correct
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
    $stmt->bindParam(':id', $_SESSION["user"]);
    $stmt->execute();
    $row = $stmt->fetch();
    if (!password_verify($oldpass, $row["Password"])) {
        $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>Onjuist wachtwoord.</p>";
        header("location: ../pages/instellingen.php");
        exit();
    }
    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $newpass);
    $lowercase = preg_match('@[a-z]@', $newpass);
    $number = preg_match('@[0-9]@', $newpass);
    $specialChars = preg_match('@[^\w]@', $newpass);
    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($newpass) < 8 || strlen($newpass) > 40) {
        $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>Het wachtwoord voldoet niet aan de eisen.</p>";
        header("location: ../pages/instellingen.php");
        exit();
    }
    // check if the newpass is typed correctly
    if($newpass == $oldpass){
        $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>Mag niet oud wactwoord gebruiken.</p>";
        header("location: ../pages/instellingen.php");
        exit();
    }
    // TODO HASH PASS
    // inset stuff into db
    // UPDATE users SET name=:name, surname=:surname, sex=:sex WHERE id=:id
    $stmt = $conn->prepare("UPDATE users SET Password=:password WHERE id=:id");
    $stmt->bindParam(':password', password_hash($newpass, PASSWORD_DEFAULT));
    $stmt->bindParam(':id', $_SESSION["user"]);
    $stmt->execute();
    if($stmt->rowCount() == 0){
        $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>Fout opgetreden.<br>Probeer het opnieuw of neem contact op met dinder.</p>";
    }else{
        $_SESSION["settings-message"] = $_SESSION["settings-message"] . "<p>Wachtwoord is veranderd.</p>";
    }
    header("location: ../pages/instellingen.php");
    exit();
?>