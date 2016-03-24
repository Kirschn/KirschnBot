<?php
include 'sqlinit.php';
$sqlconnection->set_charset("utf8");
session_start();
if ($_GET["token"] == $_SESSION["onetimetoken"]) {
    if (isset($_GET["id"])) {
        $sql = "DELETE FROM linkwhitelist WHERE id='".mysqli_real_escape_string($sqlconnection, $_GET["id"])."' AND channel='#".mysqli_real_escape_string($sqlconnection, $_SESSION["kbot_managementbot"])."'";
        echo $sql;
        mysqli_query($sqlconnection, $sql);

    }
    mysqli_close($sqlconnection);
}