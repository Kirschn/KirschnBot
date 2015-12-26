<?php
session_start();
if (isset($_POST["token"])) {
    if ($_POST["token"] == $_SESSION["onetimetoken"]) {
        include "../sqlinit.php";
        if (isset($_POST["commandname"]) && isset($_POST["commandtext"]) && isset($_POST["userlevel"])) {

            if ($_POST["commandname"] !== "" && $_POST["commandtext"] !== "" && $_POST["commandname"] !== "") {
                $sql = 'INSERT INTO commands (commandname, text, userlevel, channel, creator, createtime) VALUES ("' . htmlspecialchars($_POST["commandname"]) . '", "' . htmlspecialchars($_POST["commandtext"]) . '" , "' . htmlspecialchars($_POST["userlevel"]) . '", "#' . htmlspecialchars($_SESSION["kbot_managementbot"]) . '", "' . $_SESSION["kbot_userdisplayname"] . '", "' . date("c") . '");';
                mysqli_query($sqlconnection, $sql);
                $botname = mysqli_fetch_array(mysqli_query($sqlconnection, 'SELECT ircusername FROM botconfig WHERE channel="#' . $_SESSION["kbot_managementbot"] . '";'))[0];
                mysqli_query($sqlconnection, "INSERT INTO bottodo (chatbot, type, initby, channel) VALUES ('$botname', 'reinit', '" . $_SESSION["kbot_userdisplayname"] . "', '#" . $_SESSION["kbot_managementbot"] . "')");
                echo mysqli_error($sqlconnection);
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