<?php
    session_start();
    require_once("../php/pdo.php");
    unset($_SESSION["register-message"]);
    // info setup
    $email = $_POST["email"];
    $token = $_POST["token"];
    $password = $_POST["pass"];
    $password2 = $_POST["pass2"];
    // check if fields are empty
    if(empty($_POST["pass"]) || empty($_POST["email"]) || empty($_POST["pass2"]) || empty($_POST["token"])){
        $_SESSION["reset-message"] = $_SESSION["reset-message"] . "<p>Vul alle velden in.</p>";
        header("location: ../pages/reset-wachtwoord.php");
        exit();
    }
    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);
    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8 || strlen($password) > 40) {
        $_SESSION["reset-message"] = $_SESSION["reset-message"] . "<p>Het wachtwoord voldoet niet aan de eisen.</p>";
        header("location: ../pages/reset-wachtwoord.php");
        exit();
    }
    // check if the password is typed correctly
    if($password != $password2){
        $_SESSION["reset-message"] = $_SESSION["reset-message"] . "<p>Wachtwoorden komen niet overeen.</p>";
        header("location: ../pages/reset-wachtwoord.php");
        exit();
    }
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->bindParam(':email', $email);
    $stmt->execute(); 
    //fetch result
    $user = $stmt->fetch();
    if ($user) {
        // user exists
        $expiry_date = new DateTime($user["email_reset_expiry"]);
        $current_date = new DateTime();
        if($user["email_reset_token"] == $token && $expiry_date > $current_date){
            $stmt = $conn->prepare("UPDATE users SET Password=:password, email_reset_token=null, email_reset_expiry=null WHERE email=:email");
            // bind parameters
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
            $stmt->execute();
            $_SESSION["reset-message"] = $_SESSION["reset-message"] . "<p>Wachtwoord is vervangen</p>";
            header("location: ../pages/reset-wachtwoord.php");
            exit();
        }else{
            $stmt = $conn->prepare("UPDATE users SET email_reset_token=null, email_reset_expiry=null WHERE email=:email");
            // bind parameters
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $_SESSION["reset-message"] = $_SESSION["reset-message"] . "<p>Token klopt niet/de token is verlopen</p>";
            header("location: ../pages/reset-wachtwoord.php");
            exit();
        }
    }

?>