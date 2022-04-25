<?php
    session_start();
    // check if fields are empty
    if(!empty($_GET["email"]) || !empty($_GET["activation_code"])){
        // data email + activation key
        $email = $_GET["email"];
        $activationCode = $_GET["activation_code"];
        verifyUser($email, $activationCode);
    }
    if(isset($_POST["verify"])){
        // data email + activation key
        if(!empty($_POST["email"]) && !empty($_POST["activation_code"])){
            // data email + activation key
            $email = $_POST["email"];
            $activationCode = $_POST["activation_code"];
            verifyUser($email, $activationCode);
        }else{
            $_SESSION["verify-message"] = $_SESSION["verify-message"] . "<p>Vul alle velden in.</p>";
            header("location: ../pages/Verifieren.php");
            exit();
        }
    }
    // function to verify user
    function verifyUser($email, $activationCode) {
        require_once("../php/pdo.php");
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row) {
            // user exists
            $stmt = $conn->prepare("SELECT * FROM `users` WHERE email=:email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $row = $stmt->fetch();
            $expiry_date = new DateTime($row["activation_expiry"]);
            $current_date = new DateTime();
            // check if activating code is expired
            if($expiry_date < $current_date) {
                // code is expired
                $_SESSION["verify-message"] = "<p>Activerings code is verlopen.</p>";
                $newActivationCode = bin2hex(random_bytes(16));
                // email data
                $subject = "Dinder Email Confirmation";
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
                                        <p>Klik hier om uw account te verifi&euml;ren<br>U moet uw account binnen 3 dagen verifiëren.<br>Als de link niet werkt moet u de code kopi&euml;ren en <a href="localhost/dinder/pages/Verifieren.php">hier</a> de code invoeren</p>
                                        <p>Uw nieuwe activatie code is: ' . $newActivationCode . '</p>
                                        <a class="button" href="localhost/dinder/pages/Verifieren.php?email=' . $email . '&activation_code=' . $newActivationCode . '">Verifie&euml;r Account</a>
                                        <p>Als u geen account heeft aangemaakt kunt u deze email negeren.</p>
                                    </td>
                                </tr>
                            </table>
                        </body>
                    </html>';
                if (mail($email, $subject, $message, $headers)) {
                    // mail is send
                    $_SESSION["verify-message"] = $_SESSION["verify-message"] . "<p>Email met nieuwe code is verzonden.</p>";
                    // update verification code in db
                    // update activated_at end remove activation_expiry
                    $stmt = $conn->prepare("UPDATE `users` SET `activation_code`=:activation_code, `activation_expiry`=:activation_expiry, `updated_at` = CURRENT_TIMESTAMP() WHERE email=:email");
                    //execute
                    $stmt->bindParam(':activation_code', $newActivationCode);
                    $stmt->bindParam(':activation_expiry', $activationExpiry);
                    $stmt->bindParam(':email', $email);
                    // set expiry to today +3 days
                    $d=strtotime("+3 days");
                    $activationExpiry = date("Y/m/d/h/m/s", $d);
                    // execute
                    $stmt->execute();
                    $affectedRows = $stmt->rowCount();
                    if($affectedRows > 0){
                        header("location: ../pages/Verifieren.php");
                        exit();
                    }else{
                        $_SESSION["verify-message"] = "<p>Fout opgetreden.<br>Probeer het opnieuw of neem contact op met dinder.</p>";
                        header("location: ../pages/Verifieren.php");
                        exit();
                    }
                } else {
                    // mail not send
                    $_SESSION["verify-message"] = $_SESSION["verify-message"] . "<p>Fout opgetreden tijdens het versturen van email.<br>Probeer het opnieuw of neem contact op met dinder.</p>";
                    header("location: ../pages/Verifieren.php");
                    exit();
                }
            }
            // check if active is already set
            if($row["active"] == 1){
                // user is already activated
                $_SESSION["verify-message"] = "<p>Uw account is al geactiveerd.</p>";
                header("location: ../pages/Verifieren.php");
                exit();
            } elseif ($activationCode == $row["activation_code"]) {
                // update activated_at end remove activation_expiry
                $stmt = $conn->prepare("UPDATE `users` SET `active` = '1', `activation_expiry`=NULL, `activation_code` = NULL, `activated_at` = CURRENT_TIMESTAMP(), `updated_at` = CURRENT_TIMESTAMP() WHERE email=:email");
                //execute
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $affectedRows = $stmt->rowCount();
                if($affectedRows > 0){
                    header("location: ../pages/login.php");
                    exit();
                }else{
                    $_SESSION["verify-message"] = "<p>Fout opgetreden.<br>Probeer het opnieuw of neem contact op met dinder.</p>";
                    header("location: ../pages/Verifieren.php");
                    exit();
                }
            } else {
                $_SESSION["verify-message"] = "<p>Verificatie code is onjuist.</p>";
                header("location: ../pages/Verifieren.php");
                exit();
            }
        } else {
            // user doesnt exist
            $_SESSION["verify-message"] = "<p>Email is niet in gebruik.</p>";
            header("location: ../pages/Verifieren.php");
            exit();
        }
    }  
?>