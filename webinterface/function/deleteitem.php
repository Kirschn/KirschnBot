<?php
session_start();
if (isset($_GET["token"])) {
    if ($_GET["token"] == $_SESSION["onetimetoken"]) {
        include "../sqlinit.php";
        $sqlconnection->set_charset("utf8");
        if (isset($_GET["commandid"])) {
            if ($_GET["commandid"] !== "") {
                $sql = 'DELETE FROM `useritems` WHERE `id`="' . mysqli_real_escape_string($sqlconnection, $_GET["commandid"]) . '" AND channel="#' . mysqli_real_escape_string($sqlconnection, $_SESSION["kbot_managementbot"]) . '";';
                mysqli_query($sqlconnection, $sql);
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