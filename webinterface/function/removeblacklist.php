<?php
include 'sqlinit.php';
$sqlconnection->set_charset("utf8");
session_start();
if ($_GET["token"] == $_SESSION["onetimetoken"]) {
    if (isset($_GET["id"])) {
        $sql = "DELETE FROM wordblacklist WHERE id='".mysqli_real_escape_string($sqlconnection, $_GET["id"])."' AND channel='#".mysqli_real_escape_string($sqlconnection, $_SESSION["kbot_managementbot"])."'";
        $botname = mysqli_fetch_array(mysqli_query($sqlconnection, 'SELECT ircusername FROM botconfig WHERE channel="#' . $_SESSION["kbot_managementbot"] . '";'))[0];
        mysqli_query($sqlconnection, "INSERT INTO bottodo (chatbot, type, initby, channel) VALUES ('$botname', 'reinit', '" . $_SESSION["kbot_userdisplayname"] . "', '#" . $_SESSION["kbot_managementbot"] . "')");
        mysqli_query($sqlconnection, $sql);

    }
    mysqli_close($sqlconnection);
}