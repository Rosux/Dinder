<?php
    include_once "head.php";
    include_once "../php/checklogin.php";
?>
    <title>Dinder - Profile</title>
    <!-- style -->
    <link rel="stylesheet" href="../Style/profile.css">
    <link rel="stylesheet" href="../Style/imageUpload.css">
    <link rel="stylesheet" href="../Style/message.css">
    <link rel="stylesheet" href="../Style/form.css">

    
</head>
<body>
    <?php
        include_once "header.php";
    ?>
    <?php
        // user profile data
        $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
        if(isset($_GET["user"])){
            $stmt->bindParam(':id', $_GET["user"]);
            $visitor = true;
            $userId = $_GET["user"];
            if($_SESSION["user"] == $_GET["user"]){
                $visitor = false;
            }
        }else{
            $stmt->bindParam(':id', $_SESSION["user"]);
            $visitor = false;
            $userId = $_SESSION["user"];
        }
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $row = $stmt->fetch();
            $profilepic = $row["profile_pic_dir"];
            $bannerpic = $row["banner_pic_dir"];
            $username = $row["Username"];
            $desc = $row["Description"];
        }else{
            header("Location: ../Pages/Profile.php");
            exit();
        }
        if($visitor){
            echo '<div class="message-menu" id="message-menu"';
            if(isset($_SESSION["openmenu"]) && $_SESSION["openmenu"] == true){
                echo "style='display: flex;'";
                unset($_SESSION["openmenu"]);
            }
            echo '>';
            echo '<div class="message-wrapper">';
            echo '<div class="register-form">';
            echo '<div class="register-title">';
            echo '<p>Stuur een bericht naar ' . htmlspecialchars($username) . ' </p>';
            echo '</div>';
            if(isset($_SESSION["msg-message"])){
                echo "<div class='form-error'>";
                echo $_SESSION["msg-message"];
                echo "</div>";
                unset($_SESSION["msg-message"]);
            }
            echo '<form action="../php/message.php" method="post">';
            echo '<div class="form-row">';
            echo '<input name="reciever" type="number" value="' . $_GET["user"] . '" style="display: none;">';
            echo '<p>Bericht: </p><textarea name="message"></textarea>';
            echo '</div>';
            echo '<div class="form-row submit-button form-row-button">';
            echo '<input type="submit" value="Send">';
            echo '</div>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    ?>
    <div class="profile-wrapper">
        <!-- profile image name and desc -->
        <div class="profile-banner">
            <div class="profile-banner-image" style="background-image: url(' <?php if($bannerpic != null){ echo $bannerpic; }else{ echo "../Images/section1dog.png"; } ?> ');">
                <div class="profile-banner-user">
                    <div class="profile-banner-wrapper">
                        <div class="profile-user-image" style="background-image: url('<?php echo $profilepic; ?>');"></div>
                        <div class="profile-banner-user-wrapper">
                            <div class="profile-name"><p><?php echo htmlspecialchars($username); ?></p></div>
                            <div class="profile-description"><p><?php echo htmlspecialchars($desc); ?></p></div>
                        </div>
                    </div>
                    <div class="profile-banner-tags">
                        <?php
                            if($visitor){
                                echo '<a id="sendmessage" onclick="openMessageMenu()">Bericht Sturen</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-title">
            <p>Foto's</p>
        </div>
        <!-- profile gallery -->
        <div class="profile-gallery">
            <div class="profile-gallery-error">
                <?php
                    if(isset($_SESSION["profile-upload-message"])){
                        echo "<div class='form-error'>";
                        echo $_SESSION["profile-upload-message"];
                        echo "</div>";
                        unset($_SESSION["profile-upload-message"]);
                    }
                ?>
            </div>
            <?php
                // user picture gallery
                $stmt = $conn->prepare("SELECT * FROM gallery WHERE image_id=:image_id ORDER BY created DESC");
                $stmt->bindParam(':image_id', $userId);
                $stmt->execute();
                if($visitor){
                    if($stmt->rowCount() == 0){
                    echo '<div class="gallery-wrapper" style="justify-content: center;">';
                    echo "<p>Deze gebruiker heeft nog geen foto's toegevoegd.</p>";
                    }else{
                        echo '<div class="gallery-wrapper" style="justify-content: flex-start;">';
                    }
                }else{
                    echo '<div class="gallery-wrapper" style="justify-content: flex-start;">';
                    echo '<div class="gallery-image gallery-image-upload" onclick="openImageUploadMenu()"><div></div></div>';
                }
                while($row = $stmt->fetch()){
                    echo '<img src="' . $row["image_dir"] . '" onclick="imgclick(this)" class="gallery-image">';
                }
                echo "</div>";
            ?>
        </div>
        <!-- image upload menu -->
        <div class="image-upload-menu" id="image-upload-menu">
            <div class="image-upload-wrapper">
                <div class="register-form">
                    <div class="register-title">
                        <p>Foto Uploaden</p>
                    </div>
                    <form action="../php/uploadgalleryimage.php" method="post" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="register-form-tip"><p>Je foto kan maximaal 4MB zijn</p></div>
                            <p>Foto: </p><input class="file-upload" type="file" name="image" accept="image/x-png,image/gif,image/jpeg">
                        </div>
                        <div class="form-row submit-button form-row-button">
                            <input type="submit" value="Upload">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="../Script/imageUploadMenu.js"></script>
        <div id="view-image">
            <div id="view-image-wrapper">
                <img src="#" id="view-image-image">
            </div>
        </div>
        <div class="profile-title">
            <p><?php echo htmlspecialchars($username); ?>'s Honden</p>
        </div>
        <!-- Dogs -->
        <div class="dog-section">
            <div class="dog-wrapper">
                <?php
                    // user picture gallery
                    $stmt = $conn->prepare("SELECT * FROM dogs WHERE user_id=:user_id");
                    $stmt->bindParam(':user_id', $userId);
                    $stmt->execute();
                    while($row = $stmt->fetch()){
                        echo '<div class="dog-card">';
                        echo '<div class="dog-card-image"><img src="' . $row["dog_pic_dir"] . '"></div>';
                        echo '<div class="dog-card-name"><p>' . htmlspecialchars($row["dogname"]) . '</p></div>';
                        echo '<div class="dog-card-desc"><p>' . htmlspecialchars($row["dog_description"]) . '</p></div>';
                        echo '<div class="dog-card-race"><p>' . htmlspecialchars($row["dog_race"]) . '</p></div>';
                        echo '<div class="dog-card-age"><p>' . htmlspecialchars($row["dog_birth_year"]) . '</p></div>';
                        echo '</div>';
                    }
                    if($stmt->rowCount() == 0){
                        echo "<p>Deze gebruiker heeft nog geen honden toegevoegd.</p>";
                    }
                ?>
            </div>
        </div>
    </div>
        <script>
            var view = document.getElementById("view-image-wrapper");
            view.addEventListener('click', e => {
                if(e.target == e.currentTarget) {
                    document.getElementById("view-image").style.display = "none";
                }
            });
            function imgclick(obj) {
                let x = obj.src;
                document.getElementById("view-image-image").src = x;
                document.getElementById("view-image").style.display = "flex";
            }
        </script>
    </div>
    <?php if($visitor){ echo '<script src="../Script/messageMenu.js"></script>';} ?>
    <?php include_once "footer.php"; ?>
</body>
</html>