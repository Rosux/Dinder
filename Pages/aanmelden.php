    <?php include_once "head.php"; ?>
    <title>Dinder - Aanmelden</title>
    <!-- style -->
    <link rel="stylesheet" href="../Style/form.css">
</head>
<body>
    <?php
        include_once "header.php";
    ?>
    <div class="register-content-wrapper">
        <!-- register form -->
        <div class="register-form">
            <div class="register-title">
                <p>Registreer bij <a style="font-family: Dancing Script;">Dinder</a></p>
            </div>
            <?php
                if(isset($_SESSION["register-message"])){
                    echo "<div class='form-error'>";
                    echo $_SESSION["register-message"];
                    echo "</div>";
                    unset($_SESSION["register-message"]);
                }
            ?>
            <form action="../php/register.php" method="post">
                <div class="form-row">
                    <div class="register-form-tip"><p>Je gebruikersnaam moet tussen de 4 en 30 tekens bevatten en mag alleen letters en numers bevatten.</p></div>
                    <p>Gebruikersnaam: </p><input type="text" name="name">
                </div>
                <div class="form-row">
                    <p>E-mail: </p><input type="email" name="email">
                </div>
                <div class="form-row">
                    <div class="register-form-tip"><p>Je wachtwoord moet minimaal 8 tekens lang zijn en maximaal 40 tekens lang zijn en minimaal 1 leesteken, cijfer en hoofdletter bevatten.</p></div>
                    <p>Wachtwoord: </p><input type="password" name="pass">
                </div>
                <div class="form-row">
                    <p>Herhaal Wachtwoord: </p><input type="password" name="pass2">
                </div>
                <div class="form-row form-row-checkboxline">
                    <p><input type="checkbox" name="terms">By clicking you agree with our <a target="_blank" href="../pages/terms-and-conditions.php">terms and conditions</a>.</p>
                </div>
                <div class="form-row submit-button form-row-button">
                    <input type="submit" value="Aanmelden">
                </div>
            </form>
            <div class="register-links">
                <a href="../Pages/login.php">Login</a>
                <a href="../Pages/wachtwoord-vergeten.php">Wachtwoord Vergeten</a>
                <a href="../Pages/Verifieren.php">Verifi&euml;ren</a>
            </div>
        </div>
    </div>
    <?php include_once "footer.php"; ?>
</body>
</html>