<?php
session_start();
if (isset($_GET["token"])) {
    if ($_GET["token"] == $_SESSION["kbot_logouttoken"]) {

        session_destroy();
        header("Location: ../index.php");
    } else {
        header("Location: ../index.php");
    }
} else {
    header("Location: ../index.php");
}