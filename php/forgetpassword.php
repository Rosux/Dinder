<?php
    session_start();
    require_once("../php/pdo.php");
    unset($_SESSION["reset-message"]);
    $email = $_POST["email"];

    // check if fields are empty
    if(empty($_POST["email"])){
        $_SESSION["reset-message"] = $_SESSION["reset-message"] . "<p>Vul alle velden in.</p>";
        header("location: ../pages/wachtwoord-vergeten.php");
        exit();
    }
    // check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["reset-message"] = $_SESSION["reset-message"] . "<p>Voer een geldige email in.</p>";
        header("location: ../pages/wachtwoord-vergeten.php");
        exit();
    }
    
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->bindParam(':email', $email);
    $stmt->execute(); 
    //fetch result
    $user = $stmt->fetch();
    if ($user) {
        




        // bind values
        $username = $user["username"];
        
        $resettoken = bin2hex(random_bytes(16));
        // email data
        $subject =  "Dinder Reset Wachtwoord";
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
                                <p>Klik hier om uw wachtwoord opnieuw in te stelen.<br>U moet uw wachtwoord binnen 1 dag instellen.<br>Als de link niet werkt moet u de code kopi&euml;ren en <a href="localhost/dinder/pages/reset-wachtwoord.php">hier</a> de code invoeren</p>
                                <p>Uw activatie code is: ' . $resettoken . '</p>
                                <a class="button" href="localhost/dinder/pages/reset-wachtwoord.php?email=' . $email . '&token=' . $resettoken . '">Verifie&euml;r Account</a>
                                <p>Als u geen account heeft aangemaakt kunt u deze email negeren.</p>
                            </td>
                        </tr>
                    </table>
                </body>
            </html>';
        if (mail($email, $subject, $message, $headers)) {
            // mail is send so insert into db
            $d=strtotime("+1 days");
            $activationExpiry = date("Y/m/d/h/m/s", $d);
            $stmt = $conn->prepare("UPDATE users SET email_reset_token=:email_reset_token, email_reset_expiry=:email_reset_expiry WHERE email=:email");
            // bind parameters
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':email_reset_token', $resettoken);
            $stmt->bindParam(':email_reset_expiry', $activationExpiry);
            $stmt->execute();
            // set message
            $_SESSION["reset-message"] = "<p>Reset-Email is verzonden.</p>";
            header("location: ../pages/wachtwoord-vergeten.php");
            exit();
        } else {
            // mail not send
            $_SESSION["reset-message"] = "<p>Fout opgetreden.<br>Probeer het opnieuw of neem contact op met dinder.</p>";
            header("location: ../pages/wachtwoord-vergeten.php");
            exit();
        }
    } else {
        $_SESSION["reset-message"] = "<p>Gebruiker bestaat niet.</p>";
        header("location: ../pages/wachtwoord-vergeten.php");
        exit();
    }
?>