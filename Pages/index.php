<?php include_once "head.php"; ?>
    <title>Dinder</title>
    <!-- style -->
    <link rel="stylesheet" href="../Style/header.css">
    <link rel="stylesheet" href="../Style/index.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    <!-- scripts -->
    <script src="../Script/count.js"></script>
    <script src="../Script/scrollto.js"></script>
    <script src="../Script/tryout.js"></script>
    <script src="../Script/header.js"></script>
</head>
<body>
    <?php include_once "header.php"; ?>
    <!-- first page section -->
    <div class="section1">
        <div class="section1-wrapper">
            <p>Laat je hond andere honden ontmoeten</p>
            <div class="section1-buttons">
                <a class="text-button" href="login.php">Login</a>
                <a class="text-button" href="aanmelden.php">Register</a>
            </div>
        </div>
        <div class="section1-counter">
            <?php
                include_once "../php/pdo.php";
                $sql = "SELECT COUNT(*) FROM users";
                $stmt = $conn->query($sql);
                $count = $stmt->fetchColumn();
                echo '<p>Nu al <a class="count">' .  $count . "</a> wandelaars geregistreerd</p>";
            ?>
        </div>
    </div>
    <!-- section 2 -->
    <div class="section2">
        <div class="section2-title">
            <p>Ontmoet nieuwe mensen en dieren</p>
        </div>
        <div class="section2-wrapper">
            <!-- first card -->
            <div id="card-wrapper-1" class="card-wrapper">
                <div class="profile-picture">
                    <img src="../Images/Dogpic.png" alt="Dog Selfie">
                    <div class="profile-text">
                        <div class="profile-dog-name"><p>Jakey, Golden Retriever</p></div>
                        <div class="profile-name"><p>David, 42</p></div>
                        <div class="profile-location"><p>Netherlands, Gouda</p></div>
                    </div>
                </div>
                <div class="profile-tags">
                    <a>Loves Sticks</a>
                    <a>Woofs</a>
                    <a>Likes Treats</a>
                    <a>Long Walks</a>
                </div>
                <div class="profile-button-wrapper">
                    <a onclick="scrollTowards('section3')" class="profile-buttons profile-button-cross"></a>
                    <a onclick="scrollTowards('section3')" class="profile-buttons profile-button-profile"></a>
                    <a onclick="scrollTowards('section3')" class="profile-buttons profile-button-heart"></a>
                </div>
            </div>
            <!-- second card -->
            <div id="card-wrapper-2" class="card-wrapper">
                <div class="profile-picture">
                    <img src="../Images/Dogpic1.gif" alt="Dog Selfie">
                    <div class="profile-premium-star">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="profile-text">
                        <div class="profile-dog-name"><p>Doob, Husky</p></div>
                        <div class="profile-name"><p>Jane, 39</p></div>
                        <div class="profile-location"><p>Netherlands, Gouda</p></div>
                    </div>
                </div>
                <div class="profile-tags">
                    <a>Gives Great Hugs</a>
                    <a>Loves Running</a>
                    <a>Medium-Long Walks</a>
                    <a>Cute Dog</a>
                </div>
                <div class="profile-button-wrapper">
                    <a onclick="scrollTowards('section3')" class="profile-buttons profile-button-cross"></a>
                    <a onclick="scrollTowards('section3')" class="profile-buttons profile-button-profile"></a>
                    <a onclick="scrollTowards('section3')" class="profile-buttons profile-button-heart"></a>
                </div>
            </div>
            <!-- third card -->
            <div id="card-wrapper-3" class="card-wrapper">
                <div class="profile-picture">
                    <img src="../Images/Dogpic2.jpg" alt="Dog Selfie">
                    <div class="profile-text">
                        <div class="profile-dog-name"><p>Nathan, Golden Retriever</p></div>
                        <div class="profile-name"><p>Peter, 34</p></div>
                        <div class="profile-location"><p>Netherlands, Gouda</p></div>
                    </div>
                </div>
                <div class="profile-tags">
                    <a>Very Smart</a>
                    <a>Calm</a>
                    <a>Older</a>
                </div>
                <div class="profile-button-wrapper">
                    <a onclick="scrollTowards('section3')" class="profile-buttons profile-button-cross"></a>
                    <a onclick="scrollTowards('section3')" class="profile-buttons profile-button-profile"></a>
                    <a onclick="scrollTowards('section3')" class="profile-buttons profile-button-heart"></a>
                </div>
            </div>
        </div>
    </div>
    <!-- section 3 -->
    <div id="section3" class="section3">
        <div class="section3-title">
            <p>Probeer het uit</p>
        </div>
        <div class="section3-wrapper">
            <!-- first test card -->
            <div id="card1" class="card-wrapper tryout-card">
                <div class="profile-picture">
                    <img src="../Images/Dogpic.png" alt="Dog Selfie">
                    <div class="profile-text">
                        <div class="profile-dog-name"><p>Jakey, Golden Retriever</p></div>
                        <div class="profile-name"><p>David, 42</p></div>
                        <div class="profile-location"><p>Netherlands, Gouda</p></div>
                    </div>
                </div>
                <div class="profile-tags">
                    <a>Loves Sticks</a>
                    <a>Woofs</a>
                    <a>Likes Treats</a>
                    <a>Long Walks</a>
                </div>
                <div class="profile-button-wrapper">
                    <a onclick="deny('card1');lastcard()" class="profile-buttons profile-button-cross"></a>
                    <a href="login.php" class="profile-buttons profile-button-profile"></a>
                    <a onclick="like('card1');lastcard()" class="profile-buttons profile-button-heart"></a>
                </div>
            </div>
            <!-- second test card -->
            <div id="card2" class="card-wrapper tryout-card">
                <div class="profile-picture">
                    <img src="../Images/Dogpic1.gif" alt="Dog Selfie">
                    <div class="profile-premium-star">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="profile-text">
                        <div class="profile-dog-name"><p>Doob, Husky</p></div>
                        <div class="profile-name"><p>Jane, 39</p></div>
                        <div class="profile-location"><p>Netherlands, Gouda</p></div>
                    </div>
                </div>
                <div class="profile-tags">
                    <a>Gives Great Hugs</a>
                    <a>Loves Running</a>
                    <a>Medium-Long Walks</a>
                    <a>Cute Dog</a>
                </div>
                <div class="profile-button-wrapper">
                    <a onclick="deny('card2')" class="profile-buttons profile-button-cross"></a>
                    <a href="login.php" class="profile-buttons profile-button-profile"></a>
                    <a onclick="like('card2')" class="profile-buttons profile-button-heart"></a>
                </div>
            </div>
            <!-- third test card -->
            <div id="card3" class="card-wrapper tryout-card">
                <div class="profile-picture">
                    <img src="../Images/Dogpic2.jpg" alt="Dog Selfie">
                    <div class="profile-text">
                        <div class="profile-dog-name"><p>Nathan, Golden Retriever</p></div>
                        <div class="profile-name"><p>Peter, 34</p></div>
                        <div class="profile-location"><p>Netherlands, Gouda</p></div>
                    </div>
                </div>
                <div class="profile-tags">
                    <a>Very Smart</a>
                    <a>Calm</a>
                    <a>Older</a>
                </div>
                <div class="profile-button-wrapper">
                    <a onclick="deny('card3')" class="profile-buttons profile-button-cross"></a>
                    <a href="login.php" class="profile-buttons profile-button-profile"></a>
                    <a onclick="like('card3')" class="profile-buttons profile-button-heart"></a>
                </div>
            </div>
            <div class="section3-chat">
                <div class="chat-header">
                    <a>&lsaquo;</a>
                    <div id="chat-name" class="chat-name">Jakey</div>
                </div>
                <div id="chat-window" class="chat-window">
                    <div class="chat-element">
                        <div class="chat-pic"></div>
                        <div class="chat-text">
                            Hey welkom bij Dinder.
                        </div>
                    </div>
                </div>
            </div>
            <div id="spacer-card" style="box-shadow: none;z-index: -1;display: hidden;" class="card-wrapper tryout-card">
                <div class="profile-picture"></div>
                <div class="profile-tags"></div>
                <div class="profile-button-wrapper" style="height: 60px;"></div>
            </div>
        </div>
    </div>
    <!-- section 4 -->
    <div class="section4">
        <div class="section4-wrapper">
            <!-- first timer description -->
            <div class="section4-row">
                <div class="section4-circle-overlay">
                    <!-- date -->
                    <p>19/02/2021</p>
                </div>
                <div class="section4-circle"></div>
                <div class="section4-text">
                    <p>
                        Het idee was ontstaan, een wandel app voor jou en je hond.
                    </p>
                </div>
                <!-- line -->
                <div class="section4-top-line section4-line"></div>
            </div>
            <!-- second timer description -->
            <div class="section4-row section4-text-left">
                <div class="section4-circle-overlay">
                    <!-- date -->
                    <p>04/08/2021</p>
                </div>
                <div class="section4-circle"></div>
                <div class="section4-text">
                    <p>
                        De documenten waren geregeld en klaar voor gebruik, rond deze tijd hadden wij ook een server en website idee opgebouwt. Ook zou er een app komen om via je telefoon een wandeling voor de hond en jou te regelen.
                    </p>
                </div>
                <!-- line -->
                <div class="section4-middle-line section4-line"></div>
            </div>
            <!-- third timer description -->
            <div class="section4-row">
                <div class="section4-circle-overlay">
                    <!-- date -->
                    <p>09/02/2022</p>
                </div>
                <div class="section4-circle"></div>
                <div class="section4-text">
                    <p>
                        Het website en mockup idee is beter uitgewerkt en er is een style gekozen die wij kunnen gebruiken op alle apps en websites.
                    </p>
                </div>
                <!-- line -->
                <div class="section4-bottom-line section4-line"></div>
            </div>
        </div>
    </div>
    <?php include_once "footer.php"; ?>
</body>
</html>
<!-- me working on this project -> ಠ︵ಠ -->