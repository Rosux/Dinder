<?php
    session_start();
    require_once("../php/pdo.php");
    unset($_SESSION["login-message"]);
    // info setup
    $email = $_POST["email"];
    $password = $_POST["password"];
    // check if fields are empty
    if(empty($_POST["email"]) || empty($_POST["password"])){
        $_SESSION["login-message"] = $_SESSION["login-message"] . "<p>Vul alle velden in.</p>";
        header("location: ../pages/login.php");
        exit();
    }
    // get user by email from database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $row = $stmt->fetch();
    $dbpassword = $row["Password"];
    if ($row) {
        // user exists
        if($row["active"] != 1){
            header("location: ../pages/Verifieren.php");
            exit();
        }
        if (password_verify($password, $dbpassword)) { 
            // user can login
            if($_POST["keep_logged"] == true){
                // remember me turned on
                ini_set('session.gc_maxlifetime', 86400 * 30);
                session_set_cookie_params(86400 * 30);
            }
            $token = bin2hex(random_bytes(32));
            // prepare insert statement that inserts user login token
            $stmt = $conn->prepare("UPDATE `users` SET `login_token`=:token  WHERE email=:email");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', password_hash($token, PASSWORD_DEFAULT));
            $stmt->execute();
            $affectedRows = $stmt->rowCount();
            if($affectedRows > 0){
                $_SESSION["user"] = $row["id"];
                // make a cookie token
                setcookie("Dinder__Token", $token, time() + (86400 * 30), "/");
                header("Location: ../pages/profile.php?user=" . $_SESSION["user"]);
                exit();
            }else{
                session_unset();
                session_destroy();
                // destroy cookie token
                $_SESSION["login-message"] = "<p>Fout opgetreden.<br>Probeer het opnieuw of neem contact op met dinder.</p>";
                header("location: ../pages/login.php");
                exit();
            }
        } else {
            // password is wrong
            $_SESSION["login-message"] = $_SESSION["login-message"] . "<p>Email of wachtwoord is onjuist.</p>";
            header("location: ../pages/login.php");
            exit();
        }
    }else{
        // email is wrong
        $_SESSION["login-message"] = $_SESSION["login-message"] . "<p>Email of wachtwoord is onjuist.</p>";
        header("location: ../pages/login.php");
        exit();
    }
?>