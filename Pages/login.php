<?php include_once "head.php"; ?>
    <title>Dinder - Login</title>
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
                <p>Login</p>
            </div>
            <?php
                if(isset($_SESSION["login-message"])){
                    echo "<div class='form-error'>";
                    echo $_SESSION["login-message"];
                    echo "</div>";
                    unset($_SESSION["login-message"]);
                }
            ?>
            <form action="../php/login.php" method="post">
                <div class="form-row">
                    <p>E-mail: </p><input type="email" name="email">
                </div>
                <div class="form-row">
                    <p>Wachtwoord: </p><input type="password" name="password">
                </div>
                <div class="form-row form-row-checkboxline">
                    <p><input type="checkbox" name="keep_logged">Ingelogd blijven.</p>
                </div>
                <div class="form-row submit-button form-row-button">
                    <input type="submit" value="Login">
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