<?php
session_start();
if (isset($_POST["token"])) {
    if ($_POST["token"] == $_SESSION["onetimetoken"]) {
        include "../sqlinit.php";
        $sqlconnection->set_charset("utf8");
        if (isset($_POST["commandname"]) && isset($_POST["commandtext"])) {

            if ($_POST["commandname"] !== "" && $_POST["commandtext"] !== "" && $_POST["commandname"] !== "") {
                $duplicatebuffer = mysqli_fetch_array(mysqli_query($sqlconnection, "SELECT id FROM quotes WHERE channel='#".strtolower($_SESSION["kbot_managementbot"])."' AND name='" . mysqli_real_escape_string($sqlconnection, $_POST["commandname"]).  "';"));
                if ($duplicatebuffer == NULL) {
                    $sql = 'INSERT INTO quotes (name, text, channel, username) VALUES ("' . mysqli_real_escape_string($sqlconnection, $_POST["commandname"]) . '", "' . mysqli_real_escape_string($sqlconnection, $_POST["commandtext"]) . '", "#' . mysqli_real_escape_string($sqlconnection, $_SESSION["kbot_managementbot"]) . '", "' . $_SESSION["kbot_userdisplayname"] . '");';
                    mysqli_query($sqlconnection, $sql);
                    echo "Operation complete.";
                } else {
                    echo "This Quote does already exist";
                }

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