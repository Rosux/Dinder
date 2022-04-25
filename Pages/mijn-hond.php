<?php include_once "head.php"; ?>
    <title>Dinder - Mijn Hond</title>
    <!-- style -->
    <link rel="stylesheet" href="../Style/form.css">
    <link rel="stylesheet" href="../Style/dogs.css">
    <link rel="stylesheet" href="../Style/settings.css">
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
                <p>Honden</p>
            </div>
            <?php
                if(isset($_SESSION["dog-message"])){
                    echo "<div class='form-error'>";
                    echo $_SESSION["dog-message"];
                    echo "</div>";
                    unset($_SESSION["dog-message"]);
                }
            ?>
            <!-- add -->
            <form action="../php/dog.php" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="register-form-tip"><p>Je foto kan maximaal 4MB zijn</p></div>
                    <p>Foto: </p><input class="file-upload" type="file" name="image" accept="image/x-png,image/gif,image/jpeg">
                </div>
                <div class="form-row">
                    <div class="register-form-tip"><p>Naam mag niet langer dan 255 tekens zijn</p></div>
                    <p>Naam: </p><input type="text" name="name">
                </div>
                <div class="form-row">
                    <p>Geboorte Datum: </p><input type="date" name="date">
                </div>
                <div class="form-row">
                    <p>Ras: </p><input type="text" name="race">
                </div>
                <div class="form-row">
                    <div class="register-form-tip"><p>Je beschrijving mag niet langer dan 255 tekens zijn.</p></div>
                    <p>description: </p><textarea name="description"></textarea>
                </div>
                <div class="form-row submit-button form-row-button">
                    <input name="add" type="submit" value="Toevoegen">
                </div>
            </form>
            <div class="register-title">
                <p>Verander Hond</p>
            </div>
            <!-- edit -->
            <form action="../php/dog.php" method="post" enctype="multipart/form-data">
                <?php
                    // // user picture gallery
                    $stmt = $conn->prepare("SELECT * FROM dogs WHERE user_id=:user_id");
                    $stmt->bindParam(':user_id', $_SESSION["user"]);
                    $stmt->execute();
                    if($stmt->rowCount() > 0){
                        echo '<div class="form-row-image-wrapper">';
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                            $id = $row["id"];
                            $img = $row["dog_pic_dir"];
                            echo '<button class="form-row-image-edit" type="submit" name="edit-dog" value="' . $id . '" style="background-image: url('.$img.');"></button>';
                        }
                        echo "</div>";
                    }else{
                        echo "<p>Er zijn nog geen honden geupload.</p>";
                    }

                ?>
            </form>
            <div class="register-title">
                <p>Verwijder Hond</p>
            </div>
            <!-- delete -->
            <form action="../php/dog.php" method="post">
                <?php
                    // // user picture gallery
                    $stmt = $conn->prepare("SELECT * FROM dogs WHERE user_id=:user_id");
                    $stmt->bindParam(':user_id', $_SESSION["user"]);
                    $stmt->execute();
                    if($stmt->rowCount() > 0){
                        echo '<div class="form-row-image-wrapper">';
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                            $id = $row["id"];
                            $img = $row["dog_pic_dir"];
                            echo '<button class="form-row-image" type="submit" name="Delete" value="' . $id . '" style="background-image: url('.$img.');"></button>';
                        }
                        echo "</div>";
                    }else{
                        echo "<p>Er zijn nog geen honden geupload.</p>";
                    }

                ?>
            </form>
        </div>
    </div>
    <?php include_once "footer.php"; ?>
</body>
</html>
<!-- 
    toevoegen
    verwijderen
    veranderen
 -->