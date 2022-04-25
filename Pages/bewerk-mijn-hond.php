<?php include_once "head.php"; ?>
    <title>Dinder - Mijn Hond</title>
    <!-- style -->
    <link rel="stylesheet" href="../Style/form.css">
    <link rel="stylesheet" href="../Style/dogs.css">
</head>
<body>
    <?php
        include_once "header.php";
        include_once "../php/checklogin.php";
    ?>
    <div class="register-content-wrapper">
        <!-- register form -->
        <div class="register-form">
            <div class="register-title">
                <p>Verander Hond</p>
            </div> 
            <?php
                if(isset($_SESSION["dog-message"])){
                    echo "<div class='form-error'>";
                    echo $_SESSION["dog-message"];
                    echo "</div>";
                    unset($_SESSION["dog-message"]);
                }
                if(!isset($_GET["hond"])){
                    header("Location: ../pages/mijn-hond.php");
                    exit();
                }
                // // user picture gallery
                $stmt = $conn->prepare("SELECT * FROM dogs WHERE id=:id");
                $stmt->bindParam(':id', $_GET["hond"]);
                $stmt->execute();
                $row = $stmt->fetch();
                $dogname = $row["dogname"];
                $dogyear = $row["dog_birth_year"];
                $dograce = $row["dog_race"];
                $dogdesc = $row["dog_description"];
            ?>
            <form action="../php/dog.php" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="register-form-tip"><p>Je foto kan maximaal 4MB zijn</p></div>
                    <p>Foto: </p><input class="file-upload" type="file" name="image" accept="image/x-png,image/gif,image/jpeg">
                </div>
                <div class="form-row">
                    <div class="register-form-tip"><p>Naam mag niet langer dan 255 tekens zijn</p></div>
                    <p>Naam: </p><input type="text" name="name" value="<?php echo $dogname ?>">
                </div>
                <div class="form-row">
                    <p>Geboorte Datum: </p><input type="date" name="date" value="<?php echo $dogyear ?>">
                </div>
                <div class="form-row">
                    <p>Ras: </p><input type="text" name="race" value="<?php echo $dograce ?>">
                </div>
                <div class="form-row">
                    <div class="register-form-tip"><p>Je beschrijving mag niet langer dan 255 tekens zijn.</p></div>
                    <p>description: </p><textarea name="description"><?php echo $dogdesc ?></textarea>
                </div>
                <div class="form-row submit-button form-row-button">
                    <?php
                        $id = $_GET["hond"];
                        echo '<input style="display: none;" type="text" name="dogID" value="' . $id . '">';
                    ?>
                    <input name="change" type="submit" value="Veranderen">
                </div>
            </form>
        </div>
    </div>
    <?php include_once "footer.php"; ?>
</body>
</html>