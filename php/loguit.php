<?php
    session_start();
    if(isset($_SESSION["user"])){
        unset($_SESSION["user"]);
        session_unset();
        session_destroy();
        session_regenerate_id(true);
    }
    if (isset($_COOKIE["Dinder__Token"])) {
        unset($_COOKIE["Dinder__Token"]);
    }
    header("location: ../pages/login.php");
    exit();
?>