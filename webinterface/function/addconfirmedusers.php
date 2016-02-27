<?php
session_start();

if ($_GET["token"] == $_SESSION["onetimetoken"] && isset($_GET["name"])) {
    if (!empty($_GET["name"])) {
        include 'sqlinit.php';
        $sqlconnection->set_charset("utf8");
        mysqli_query($sqlconnection, "INSERT INTO canmanage (name, channel) VALUES ('".mysqli_real_escape_string($sqlconnection, $_GET["name"])."', '".mysqli_real_escape_string($sqlconnection, $_SESSION["kbot_managementbot"])."')");
        mysqli_close($sqlconnection);
        echo "User added.";
    }

}