<?php
    include_once "head.php";
    include_once "../php/checklogin.php";
?>
    <title>Dinder - Instellingen</title>
    <!-- style -->
    <link rel="stylesheet" href="../Style/form.css">
    <link rel="stylesheet" href="../Style/settings.css">
</head>
<body>
    <?php
        include_once "header.php";
        // get user
        $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
        if(isset($_SESSION["user"])){
            $stmt->bindParam(':id', $_SESSION["user"]);
        }
        $stmt->execute();
        $row = $stmt->fetch();
        $username = $row["Username"];
        $desc = $row["Description"];
    ?>
    <div class="register-content-wrapper">
        <!-- register form -->
        <div class="register-form">
            <!-- user name -->
            <div class="register-title">
                <p>Gebruikersnaam</p>
            </div>
            <?php
                if(isset($_SESSION["settings-message"])){
                    echo "<div class='form-error'>";
                    echo $_SESSION["settings-message"];
                    echo "</div>";
                    unset($_SESSION["settings-message"]);
                }
            ?>
            <form action="../php/changeusername.php" method="post">
                <div class="form-row">
                    <div class="register-form-tip"><p>Je gebruikersnaam moet tussen de 4 en 30 tekens bevatten en mag alleen letters en numers bevatten.</p></div>
                    <p>Gebruikersnaam: </p><input type="text" name="username" value="<?php echo $username; ?>">
                </div>
                <div class="form-row">
                    <div class="register-form-tip"><p>Je beschrijving mag niet langer dan 255 tekens zijn.</p></div>
                    <p>Beschrijving: </p><textarea name="description"><?php echo $desc; ?></textarea>
                </div>
                <div class="form-row submit-button form-row-button">
                    <input type="submit" value="Opslaan">
                </div>
            </form>
            <!-- profiel foto -->
            <div class="register-title">
                <p>Profiel Foto</p>
            </div>
            <form action="../php/changeprofileimage.php" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="register-form-tip"><p>Je foto kan maximaal 4MB zijn</p></div>
                    <p>Foto: </p><input class="file-upload" type="file" name="image" accept="image/x-png,image/gif,image/jpeg">
                </div>
                <div class="form-row submit-button form-row-button">
                    <input type="submit" value="Upload Profiel Foto">
                </div>
            </form>
            <!-- banner foto -->
            <div class="register-title">
                <p>banner Foto</p>
            </div>
            <form action="../php/changebannerimage.php" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="register-form-tip"><p>Je foto kan maximaal 4MB zijn</p></div>
                    <p>Foto: </p><input class="file-upload" type="file" name="image" accept="image/x-png,image/gif,image/jpeg">
                </div>
                <div class="form-row submit-button form-row-button">
                    <input type="submit" value="Upload Banner Foto">
                </div>
            </form>
            <!-- delete images -->
            <div class="register-title">
                <p>Verwijder Foto's</p>
            </div>
            <form action="../php/deletegalleryimage.php" method="post">
                <?php
                    $stmt = $conn->prepare("SELECT * FROM gallery WHERE image_id=:id");
                    $stmt->bindParam(':id', $_SESSION["user"]);
                    $stmt->execute();
                    if($stmt->rowCount() > 0){
                        echo '<div class="form-row-image-wrapper">';
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                            $id = $row["id"];
                            $img = $row["image_dir"];
                            echo '<button class="form-row-image" type="submit" name="Delete" value="' . $id . '" style="background-image: url('.$img.');"></button>';
                        }
                        echo "</div>";
                    }else{
                        echo "<p>Er zijn nog geen foto's geupload.</p>";
                    }
                ?>
            </form>
            <!-- password -->
            <div class="register-title">
                <p>Wachtwoord</p>
            </div>
            <form action="../php/changepassword.php" method="post">
                <div class="form-row">
                    <div class="register-form-tip"><p>Je wachtwoord moet minimaal 8 tekens lang zijn en maximaal 40 tekens lang zijn en minimaal 1 leesteken, cijfer en hoofdletter bevatten.</p></div>
                    <p>Nieuw Wachtwoord: </p><input type="password" name="newpassword">
                </div>
                <div class="form-row">
                    <p>Oud Wachtwoord: </p><input type="password" name="oldpassword">
                </div>
                <div class="form-row submit-button form-row-button">
                    <input type="submit" value="Wachtwoord Veranderen">
                </div>
            </form>
            <div class="register-links">
                <a href="../Pages/wachtwoord-vergeten.php">Wachtwoord Vergeten</a>
            </div>
        </div>
    </div>
    <?php include_once "footer.php"; ?>
</body>
</html>