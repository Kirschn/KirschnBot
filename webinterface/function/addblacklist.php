<?php
session_start();

if ($_GET["token"] == $_SESSION["onetimetoken"] && isset($_GET["name"])) {
    if (!empty($_GET["name"])) {
        include 'sqlinit.php';
        $sqlconnection->set_charset("utf8");
        mysqli_query($sqlconnection, "INSERT INTO wordblacklist (word, channel) VALUES ('".mysqli_real_escape_string($sqlconnection, strtolower($_GET["name"]))."', '#".mysqli_real_escape_string($sqlconnection, $_SESSION["kbot_managementbot"])."')");
        $botname = mysqli_fetch_array(mysqli_query($sqlconnection, 'SELECT ircusername FROM botconfig WHERE channel="#' . $_SESSION["kbot_managementbot"] . '";'))[0];
        mysqli_query($sqlconnection, "INSERT INTO bottodo (chatbot, type, initby, channel) VALUES ('$botname', 'reinit', '" . $_SESSION["kbot_userdisplayname"] . "', '#" . $_SESSION["kbot_managementbot"] . "')");
        mysqli_close($sqlconnection);
        echo "Phrase added.";
    }

}