<?php
    session_start();
    require_once("../php/pdo.php");
    unset($_SESSION["register-message"]);
    // info setup
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["pass"];
    $password2 = $_POST["pass2"];
    $terms = $_POST["terms"];
    // check if fields are empty
    if(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["pass"]) || empty($_POST["pass2"]) || empty($_POST["terms"])){
        $_SESSION["register-message"] = $_SESSION["register-message"] . "<p>Vul alle velden in.</p>";
        header("location: ../pages/aanmelden.php");
        exit();
    }
    // check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["register-message"] = $_SESSION["register-message"] . "<p>Voer een geldige email in.</p>";
    }
    // check if username is longer than 4 and only containts a-Z and numbers
    if(strlen($name)<4 || strlen($name)>30 || preg_match('/[^A-Za-z0-9]/', $name)){
        $_SESSION["register-message"] = $_SESSION["register-message"] . "<p>De gebruikersnaam voldoet niet aan de eisen.</p>";
        $register = false;
    }
    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);
    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8 || strlen($password) > 40) {
        $_SESSION["register-message"] = $_SESSION["register-message"] . "<p>Het wachtwoord voldoet niet aan de eisen.</p>";
        header("location: ../pages/aanmelden.php");
        $register = false;
    }
    // check if the password is typed correctly
    if($password != $password2){
        $_SESSION["register-message"] = $_SESSION["register-message"] . "<p>Wachtwoorden komen niet overeen.</p>";
        $register = false;
    }
    if(!isset($register)){
        $register = true;
    }
    if($register){
        // user is clear to register
        // check if user exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
        //execute
        $stmt->bindParam(':email', $email);
        $stmt->execute(); 
        //fetch result
        $user = $stmt->fetch();
        if ($user) {
            // email already in use
            $_SESSION["register-message"] = "<p>Email is al in gebruik.</p>";
            header("location: ../pages/aanmelden.php");
            exit();
        } else {
            // user is clear to register
            // bind values
            $dbusername = $name;
            $dbemail = $email;
            $dbpassword = password_hash($password, PASSWORD_DEFAULT);
            $activationcode = bin2hex(random_bytes(16));
            // email data
            $subject =  "Dinder Email Confirmation";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $message = '<!DOCTYPE html>
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <style>
                        @import url("https://fonts.googleapis.com/css2?family=Dancing+Script&family=Montserrat&display=swap");
                        body{
                            padding: 0 !important;
                            margin: 0 !important;
                            font-family: "Montserrat", sans-serif !important;
                            color: #000000 !important;
                        }
                        .title{
                            width: 100%  !important;
                            padding: 10px 0  !important;
                            border-bottom: solid 4px #000000  !important;
                            margin-bottom: 30px  !important;
                        }
                        .dinder{
                            font-size: 50px  !important;
                            text-decoration: none  !important;
                            color: #000000 !important;
                            font-family: "Dancing Script", cursive !important;
                        }
                        .title > .title-wrap > p{
                            font-size: 15px  !important;
                            line-height: 40px  !important;
                            margin: 0  !important;
                            padding: 0  !important;
                        }
                        p{
                            padding: 10px 0  !important;
                        }
                        a{
                            text-decoration: none  !important;
                            text-decoration: underline  !important;
                            color: inherit  !important;
                        }
                        .button{
                            font-size: 1.5em;
                            border: solid 3px #000000;
                            border-radius: 25px;
                            padding: 10px;
                        }
                        .lasttable{
                            padding-bottom: 200px;
                        }
                    </style>
                </head>
                    <body>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" class="title">
                                    <a class="dinder" href="../index.html">Dinder</a>
                                </td>
                            </tr>
                        </table>
                        <table class="lasttable" width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center">
                                    <p>Klik hier om uw account te verifi&euml;ren<br>U moet uw account binnen 3 dagen verifi&euml;ren.<br>Als de link niet werkt moet u de code kopi&euml;ren en <a href="localhost/dinder/pages/verifi&euml;ren.php">hier</a> de code invoeren</p>
                                    <p>Uw activatie code is: ' . $activationcode . '</p>
                                    <a class="button" href="localhost/dinder/pages/verifieren.php?email=' . $dbemail . '&activation_code=' . $activationcode . '">Verifie&euml;r Account</a>
                                    <p>Als u geen account heeft aangemaakt kunt u deze email negeren.</p>
                                </td>
                            </tr>
                        </table>
                    </body>
                </html>';
            if (mail($dbemail, $subject, $message, $headers)) {
                // mail is send so insert into db
                // prepare insert statement
                $stmt = $conn->prepare("INSERT INTO users (Username, Description, Email, Password, activation_code, activation_expiry, updated_at) VALUES (:username, :Description, :email, :password, :activation_code, :activation_expiry, CURRENT_TIMESTAMP())");
                // bind parameters
                $stmt->bindParam(':username', htmlspecialchars($dbusername));
                $stmt->bindParam(':email', $dbemail);
                $stmt->bindParam(':password', $dbpassword);
                $stmt->bindParam(':activation_code', $activationcode);
                $stmt->bindParam(':Description', $desc);
                $stmt->bindParam(':activation_expiry', $activationExpiry);
                // set expiry to today +3 days
                $d=strtotime("+3 days");
                $activationExpiry = date("Y/m/d/h/m/s", $d);
                $desc = "Hey ik ben nieuw bij Dinder.";
                $stmt->execute();
                // set message
                $_SESSION["register-message"] = "<p>Verificatie Email is verzonden.</p>";
                header("location: ../pages/aanmelden.php");
                exit();
            } else {
                // mail not send
                $_SESSION["register-message"] = "<p>Fout opgetreden.<br>Probeer het opnieuw of neem contact op met dinder.</p>";
                header("location: ../pages/aanmelden.php");
                exit();
            }
        }
    }else{
        header("location: ../pages/aanmelden.php");
        exit();
    }
?>