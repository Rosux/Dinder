<?php include_once "head.php"; ?>
    <title>Dinder - Wachtwoord Vergeten</title>
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
                <p>Wachtwoord Vergeten</p>
            </div>
            <?php
                if(isset($_SESSION["reset-message"])){
                    echo "<div class='form-error'>";
                    echo $_SESSION["reset-message"];
                    echo "</div>";
                    unset($_SESSION["reset-message"]);
                }
            ?>
            <form action="../php/forgetpassword.php" method="post">
                <div class="form-row">
                    <p>E-mail: </p><input type="email" name="email">
                </div>
                <div class="form-row submit-button form-row-button">
                    <input type="submit" value="Wachtwoord resetten">
                </div>
            </form>
            <div class="register-links">
                <a href="../Pages/aanmelden.php">Registreren</a>
                <a href="../Pages/wachtwoord-vergeten.php">Wachtwoord Vergeten</a>
                <a href="../Pages/Verifieren.php">Verifi&euml;ren</a>
            </div>
        </div>
    </div>
    <?php include_once "footer.php"; ?>
</body>
</html>