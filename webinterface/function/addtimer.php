<?php
session_start();
if (isset($_POST["token"])) {
    if ($_POST["token"] == $_SESSION["onetimetoken"]) {
        include "../sqlinit.php";
        $sqlconnection->set_charset("utf8");
        if (isset($_POST["commandname"]) && isset($_POST["commandtext"]) && isset($_POST["interval"]) && isset($_POST["lines"])) {

            if ($_POST["commandname"] !== "" && $_POST["commandtext"] !== "" && $_POST["interval"] !== ""&& $_POST["lines"] !== "") {
                $sql = 'INSERT INTO timer (name, text, timerinterval, linex, channel) VALUES ("' . mysqli_real_escape_string($sqlconnection, $_POST["commandname"]) . '", "' . mysqli_real_escape_string($sqlconnection, $_POST["commandtext"]) . '" , "' . mysqli_real_escape_string($sqlconnection, $_POST["interval"]) . '" , "' . mysqli_real_escape_string($sqlconnection, $_POST["lines"]) . '", "#' . $_SESSION["kbot_managementbot"] . '");';
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