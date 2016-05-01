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
$botconfig = mysqli_fetch_assoc(mysqli_query($sqlconnection, "SELECT isactive, ircusername FROM  botconfig WHERE channel='#" . $username . "';"));
if ($botconfig["isactive"] !== NULL) {
    $vorsilbe = "Dis";
} else {
    $vorsilbe = "En";
}
if (isset($_GET["actiondo"])) {
    $botconfig = mysqli_fetch_assoc(mysqli_query($sqlconnection, "SELECT isactive, ircusername FROM  botconfig WHERE channel='#" . $username . "';"));
    $botname = $botconfig["ircusername"];
    if ($botconfig["isactive"] == NULL) {
        mysqli_query($sqlconnection, "UPDATE  `kirschnbot`.`botconfig` SET  `isactive` =  'true' WHERE channel='#" . $username . "';");
        mysqli_query($sqlconnection, "INSERT INTO bottodo (chatbot, type, initby, channel) VALUES ('kirschnbot', 'join', '" . $_SESSION["kbot_realusername"] . "', '#" . $_SESSION["kbot_managementbot"] . "')");
        echo "active";
    } else {
        mysqli_query($sqlconnection, "UPDATE  `kirschnbot`.`botconfig` SET  `isactive` =  NULL WHERE channel='#" . $username . "';");
        mysqli_query($sqlconnection, "INSERT INTO bottodo (chatbot, type, initby, channel) VALUES ('$botname', 'part', '" . $_SESSION["kbot_realusername"] . "', '#" . $_SESSION["kbot_managementbot"] . "')");
        echo "inactive";
    }
    mysqli_close($sqlconnection);

}
?>
<br>
<div id="activatebot" style="width: 100%; text-align:center;"><button type="submit" class="btn btn-primary" onclick="$.get('function/togglebot.php?token=<?php echo $_SESSION["onetimetoken"]; ?>&action=0&actiondo=0', function(data) {$('#activatebot').load('function/togglebot.php?action=0')})"><?php echo $vorsilbe; ?>able Bot</button></div>

