<?php
include 'sqlinit.php';
$sqlconnection->set_charset("utf8");
session_start();
if ($_GET["token"] == $_SESSION["onetimetoken"]) {
    if (is_numeric($_GET["comid"]))
    if ($_GET["setto"] == "true") {
        mysqli_query($sqlconnection, "UPDATE  `kirschnbot`.`commands` SET  `whispercommand` =  '1' WHERE  `commands`.`id`=". $_GET["comid"] ." AND channel='#" . $_SESSION["kbot_managementbot"] . "';");
    } else {
        mysqli_query($sqlconnection, "UPDATE  `kirschnbot`.`commands` SET  `whispercommand` =  '0' WHERE  `commands`.`id`=". $_GET["comid"] ." AND channel='#" . $_SESSION["kbot_managementbot"] . "';");
    }
    mysqli_close($sqlconnection);
}