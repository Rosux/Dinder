<!-- header -->
<div class="header" id="header">
    <div class="header-left header-wrapper"></div>
    <div class="header-center header-wrapper">
        <a href="index.php">Dinder</a>
    </div>
    <div class="header-right header-wrapper">
        <div class="header-text-right">
            <a href="terms-and-conditions.php">Terms & Conditions</a>
            <a> - </a>
            <?php
                if(isset($_SESSION["user"])){
                    echo '<a href="../Pages/wag.php?user=' . $_SESSION["user"] . '">Wag</a>';
                    echo '<a> - </a>';
                    echo '<a href="../Pages/bag.php"><i class="fa-solid fa-comment"></i></a>';
                    echo '<a> - </a>';
                    echo '<a href="../Pages/mijn-hond.php"><i class="fa-solid fa-paw"></i></a>';
                    echo '<a> - </a>';
                    echo '<a href="../Pages/profile.php?user=' . $_SESSION["user"] . '"><i class="fa-solid fa-user"></i></a>';
                    echo '<a> - </a>';
                    echo '<a href="../Pages/instellingen.php"><i class="fa-solid fa-gear"></i></a>';
                    echo '<a> - </a>';
                    echo '<a href="../Pages/uitloggen.php"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>';
                }else{
                    echo '<a href="../Pages/login.php">Login</a>';
                    echo '<a> - </a>';
                    echo '<a href="../Pages/aanmelden.php">Register</a>';
                }
            ?>
        </div>
        <div class="header-mobilebutton" id="header-mobilebutton" onclick="headermenu();">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div id="mobile-header-list" class="mobile-header-list">
        <a href="index.php">Home</a>
        <a href="terms-and-conditions.php">Terms & Conditions</a>
        <?php
            if(isset($_SESSION["user"])){
                echo '<a href="../Pages/wag.php?user=' . $_SESSION["user"] . '">Wag</a>';
                echo '<a href="../Pages/bag.php"><i class="fa-solid fa-comment"></i></a>';
                echo '<a href="../Pages/uitloggen.php"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>';
                echo '<a href="../Pages/mijn-hond.php"><i class="fa-solid fa-paw"></i></a>';
                echo '<a href="../Pages/profile.php?user=' . $_SESSION["user"] . '"><i class="fa-solid fa-user"></i></a>';
                echo '<a href="../Pages/instellingen.php"><i class="fa-solid fa-gear"></i></a>';
                echo '<a href="mijn-hond.php"><i class="fa-solid fa-paw"></i></a>';
            }else{
                echo '<a href="../Pages/login.php">Login</a>';
                echo '<a href="../Pages/aanmelden.php">Register</a>';
            }
        ?>
        <a href="wachtwoord-vergeten.php">Wachtwoord Vergeten</a>
    </div>
</div>