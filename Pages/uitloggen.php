<?php include_once "head.php"; ?>
    <title>Dinder - Uitloggen</title>
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
                <p>Uitloggen</p>
            </div>
            <form action="../php/loguit.php" method="post">
                <div class="form-row submit-button form-row-button">
                    <input type="submit" value="Uitloggen">
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