<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION["kbot_logon"])) {
    $login = true;
} else {
    die();
}
$username = $_SESSION["kbot_managementbot"];
include "sqlinit.php";
$username = mysqli_real_escape_string($sqlconnection, htmlspecialchars($username));
if (isset($_SESSION['kbot_managementbot'])) {
    if ($_SESSION['kbot_managementbot'] == $username) {
        $canmanage = true;
    } else {
        if (isset(mysqli_fetch_array(mysqli_query($sqlconnection, "SELECT name FROM canmanage WHERE channel='#" . $username . "';"))[0])) {
            $canmanage = true;
        } else {
        }
    }
} else {
}
mysqli_query($sqlconnection, "UPDATE timer SET active = (CASE active WHEN 1 THEN 0 ELSE 1 END) WHERE channel='$username'");
?>