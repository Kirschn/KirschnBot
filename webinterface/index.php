<?php
session_start();
if (isset($_SESSION["kbot_logon"])) {
    header("Location: commands.php");
} else {
    include 'startpage/index.php';
}
die();