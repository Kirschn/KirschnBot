<?php
session_start();
if (isset($_POST["token"])) {
    if ($_POST["token"] == $_SESSION["onetimetoken"]) {
        include "../sqlinit.php";
        $sqlconnection->set_charset("utf8");
        if (isset($_POST["commandname"]) && isset($_POST["commandtext"]) && isset($_POST["userlevel"])) {

            if ($_POST["commandname"] !== "" && $_POST["commandtext"] !== "" && $_POST["commandname"] !== "") {
                $sql = 'INSERT INTO commands (commandname, text, userlevel, channel, creator, createtime) VALUES ("' . mysqli_real_escape_string($sqlconnection, $_POST["commandname"]) . '", "' . mysqli_real_escape_string($sqlconnection, $_POST["commandtext"]) . '" , "' . mysqli_real_escape_string($sqlconnection, $_POST["userlevel"]) . '", "#' . mysqli_real_escape_string($sqlconnection, $_SESSION["kbot_managementbot"]) . '", "' . $_SESSION["kbot_userdisplayname"] . '", "' . date("c") . '");';
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