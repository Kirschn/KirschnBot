<?php
include 'sqlinit.php';
$sqlconnection->set_charset("utf8");
session_start();
if ($_GET["token"] == $_SESSION["onetimetoken"]) {
    if (isset($_GET["name"])) {
        mysqli_query($sqlconnection, "DELETE FROM canmanage WHERE name='".mysqli_real_escape_string($sqlconnection, $_GET["name"])."' AND channel='".mysqli_real_escape_string($sqlconnection, $_SESSION["kbot_managementbot"])."'");
    }
    mysqli_close($sqlconnection);
}