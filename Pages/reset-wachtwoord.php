<?php include_once "head.php"; ?>
    <title>Dinder - Reset Wachtwoord</title>
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
                <p>Reset Wachtwoord</p>
            </div>
            <?php
                if(isset($_SESSION["reset-message"])){
                    echo "<div class='form-error'>";
                    echo $_SESSION["reset-message"];
                    echo "</div>";
                    unset($_SESSION["reset-message"]);
                }
            ?>
            <form action="../php/resetpassword.php" method="post">
                <div class="form-row">
                    <p>Email: </p><input type="email" name="email" value="<?php if(isset($_GET["email"])){echo $_GET["email"];} ?>">
                </div>
                <div class="form-row">
                    <p>Reset Token: </p><input type="text" name="token" value="<?php if(isset($_GET["token"])){echo $_GET["token"];} ?>">
                </div>
                <div class="form-row">
                    <div class="register-form-tip"><p>Je wachtwoord moet minimaal 8 tekens lang zijn en maximaal 40 tekens lang zijn en minimaal 1 leesteken, cijfer en hoofdletter bevatten.</p></div>
                    <p>Wachtwoord: </p><input type="password" name="pass">
                </div>
                <div class="form-row">
                    <p>Herhaal Wachtwoord: </p><input type="password" name="pass2">
                </div>
                <div class="form-row submit-button form-row-button">
                    <input type="submit" value="Wachtwoord resetten">
                </div>
            </form>
            <div class="register-links">
                <a href="../Pages/aanmelden.php">Registreren</a>
                <a href="../Pages/login.php">Login</a>
                <a href="../Pages/Verifieren.php">Verifi&euml;ren</a>
            </div>
        </div>
    </div>
    <?php include_once "footer.php"; ?>
</body>
</html>