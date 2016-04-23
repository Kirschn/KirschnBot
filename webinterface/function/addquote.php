<?php
session_start();
if (isset($_POST["token"])) {
    if ($_POST["token"] == $_SESSION["onetimetoken"]) {
        include "../sqlinit.php";
        $sqlconnection->set_charset("utf8");
        if (isset($_POST["commandname"]) && isset($_POST["commandtext"])) {

            if ($_POST["commandname"] !== "" && $_POST["commandtext"] !== "" && $_POST["commandname"] !== "") {
                $sql = 'INSERT INTO quotes (name, text, channel, username) VALUES ("' . htmlspecialchars($_POST["commandname"]) . '", "' . htmlspecialchars($_POST["commandtext"]) . '", "#' . htmlspecialchars($_SESSION["kbot_managementbot"]) . '", "' . $_SESSION["kbot_userdisplayname"] . '");';
                mysqli_query($sqlconnection, $sql);
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