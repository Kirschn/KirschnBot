<?php
session_start();
if (isset($_GET["token"])) {
    if ($_GET["token"] == $_SESSION["onetimetoken"]) {
        include "../sqlinit.php";
        $sqlconnection->set_charset("utf8");
        if (isset($_GET["commandid"])) {

            if ($_GET["commandid"] !== "") {
                $sql = 'DELETE FROM `commands` WHERE `id`="' . mysqli_real_escape_string($sqlconnection, $_GET["commandid"]) . '" AND channel="#' . $_SESSION["kbot_managementbot"] . '";';
                mysqli_query($sqlconnection, $sql);
                $botname = mysqli_fetch_array(mysqli_query($sqlconnection, 'SELECT ircusername FROM botconfig WHERE channel="#' . $_SESSION["kbot_managementbot"] . '";'))[0];
                mysqli_query($sqlconnection, "INSERT INTO bottodo (chatbot, type, initby, channel) VALUES ('$botname', 'reinit', '" . $_SESSION["kbot_userdisplayname"] . "', '#" . $_SESSION["kbot_managementbot"] . "')");
                echo "Operation complete.";
            } else {
                echo "Please set all Parameters";
            }
        } else {
            echo "Invalid Parameter";
        }
    } else {
        echo "Token invalid";
    }
} else {
    echo "No token";
}
die();