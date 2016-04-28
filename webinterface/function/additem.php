<?php
session_start();
if (isset($_POST["token"])) {
    if ($_POST["token"] == $_SESSION["onetimetoken"]) {
        include "../sqlinit.php";
        $sqlconnection->set_charset("utf8");
        if (isset($_POST["commandname"]) && isset($_POST["commandtext"])) {

            if ($_POST["commandname"] !== "" && $_POST["commandtext"] !== "" && $_POST["commandname"] !== "") {
                $duplicatebuffer = mysqli_fetch_array(mysqli_query($sqlconnection, "SELECT id FROM useritems WHERE channel='#".strtolower($_SESSION["kbot_managementbot"])."' AND list='" . mysqli_real_escape_string($sqlconnection, $_POST["commandtext"]). "' AND item='" . mysqli_real_escape_string($sqlconnection, $_POST["commandname"]).  "';"));
                if ($duplicatebuffer == NULL) {
                    $sql = 'INSERT INTO useritems (item, list, channel) VALUES ("' . mysqli_real_escape_string($sqlconnection, $_POST["commandname"]) . '", "' . mysqli_real_escape_string($sqlconnection, $_POST["commandtext"]) . '", "#' . mysqli_real_escape_string($sqlconnection, $_SESSION["kbot_managementbot"]) . '");';
                    mysqli_query($sqlconnection, $sql);
                    echo "Operation complete.";
                } else {
                    echo "This item does already exist";
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