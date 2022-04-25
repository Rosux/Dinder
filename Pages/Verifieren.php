<?php include_once "head.php"; ?>
    <title>Dinder - Verifiëren</title>
    <!-- style -->
    <link rel="stylesheet" href="../Style/form.css">
</head>
<body>
    <?php
        include_once "header.php";
        include_once "../php/verify.php";
    ?>
    <div class="register-content-wrapper">
        <!-- register form -->
        <div class="register-form">
            <div class="register-title">
                <p>Verifiëren</p>
            </div>
            <?php
                if(isset($_SESSION["verify-message"])){
                    echo "<div class='form-error'>";
                    echo $_SESSION["verify-message"];
                    echo "</div>";
                    unset($_SESSION["verify-message"]);
                }
            ?>
            <form action="../php/verify.php" method="post">
                <div class="form-row">
                    <p>E-mail: </p><input type="email" name="email">
                </div>
                <div class="form-row">
                    <p>Verificatie Code: </p><input type="password" name="activation_code">
                </div>
                <div class="form-row submit-button form-row-button">
                    <input type="submit" value="verifieër" name="verify">
                </div>
            </form>
            <div class="register-links">
                <a href="../Pages/login.php">Login</a>
                <a href="../Pages/wachtwoord-vergeten.php">Wachtwoord Vergeten</a>
                <a href="../Pages/aanmelden.php">Registreren</a>
            </div>
        </div>
    </div>
    <?php include_once "footer.php"; ?>
</body>
</html>