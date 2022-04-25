<?php include_once "head.php"; ?>
    <title>Dinder - Bag</title>
    <!-- style -->
    <link rel="stylesheet" href="../Style/form.css">
    <link rel="stylesheet" href="../Style/bag.css">
</head>
<body>
    <?php
        include_once "header.php";
        require_once("../php/checklogin.php");
    ?>
    <div class="register-content-wrapper">
        <!-- bag form -->
        <div class="register-form">
            <div class="register-title">
                <p>Bag</p>
            </div>
            <?php
                if(isset($_SESSION["bag-message"])){
                    echo "<div class='form-error'>";
                    echo $_SESSION["bag-message"];
                    echo "</div>";
                    unset($_SESSION["bag-message"]);
                }
            ?>
            <form action="../php/bag.php" method="post">
            <?php
                $stmt = $conn->prepare("SELECT * FROM messages WHERE sender_id=:id OR receiver_id=:id ORDER BY date DESC");
                $stmt->bindParam(':id', $_SESSION["user"]);
                $stmt->execute();
                if($stmt->rowCount() != 0){
                    // things exist
                    while($row = $stmt->fetch()){
                        // message data
                        $id = $row["id"];
                        $message = $row["message"];
                        $senderid = $row["sender_id"];
                        $receiverid = $row["receiver_id"];
                        $accepted = $row["accepted"];
                        $date = $row["date"];
                        // get receiver name
                        $getreceiver = $conn->prepare("SELECT * FROM users WHERE id=:id");
                        $getreceiver->bindParam(':id', $receiverid);
                        $getreceiver->execute();
                        $getreceivername = $getreceiver->fetch();
                        // sender data
                        $receivername = $getreceivername["Username"];
                        // get sender data
                        $getsender = $conn->prepare("SELECT * FROM users WHERE id=:id");
                        $getsender->bindParam(':id', $senderid);
                        $getsender->execute();
                        $sender = $getsender->fetch();
                        // sender data
                        $senderprofilepic = $sender["profile_pic_dir"];
                        $senderusername = $sender["Username"];
                        if($accepted){
                            echo '<div class="form-row-bag form-row-bag-green">';
                        }else{
                            echo '<div class="form-row-bag">';
                        }
                        echo '<div class="form-row-bag-top">';
                        echo '<a class="bag-image" href="../pages/profile.php?user=' . $senderid . '">';
                        echo '<img src="';
                        echo $senderprofilepic;
                        echo '">';
                        echo '</a>';
                        echo '<div class="form-row-bag-top-wrapper">';
                        echo '<p>Van: ' . htmlspecialchars($senderusername) . '<br>Voor: ' . $receivername . '</p>';
                        echo '<p>' . $date . '</p>';
                        echo '</div>';
                        echo '<div class="form-row-bag-buttons">';
                        if($senderid != $_SESSION["user"]){
                            if($accepted){
                                echo '<button type="submit" name="accept" value="' . $id . '" style="background-image: url(' . "../Images/cross-white.png" . ');"></button>';
                            }else{
                                echo '<button type="submit" name="accept" value="' . $id . '" style="background-image: url(' . "../Images/check.png" . ');"></button>';
                            }
                        }
                        echo '<button type="submit" name="delete" value="' . $id . '" style="background-image: url(' . "../Images/open-trash-can.png" . ');"></button>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="form-row-bag-message">';
                        echo '<p>Bericht: ';
                        echo htmlspecialchars($message);
                        echo '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                }else{
                    echo "<p>Er zijn nog geen berichten binnen gekomen.</p>";
                }
            ?>
            </form>
        </div>
    </div>
    <?php include_once "footer.php"; ?>
</body>
</html>