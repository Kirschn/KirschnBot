<?php
if (isset($_SESSION["kbot_logon"])) {
    header("Location: commands.php");
    die();
} else {
    header("Location: login.php");
    die();
}