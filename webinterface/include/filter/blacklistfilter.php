<?php
session_start();
if (isset($_SESSION["kbot_logon"])) {
    $login = true;
} else {
    die();
}
if (!isset($_GET["channel"])) {
    if ($login) {
        $username = $_SESSION["kbot_managementbot"];
    } else {
        header("Location: login.php");
        die();
    }
} else {
    $username = htmlspecialchars($_GET["channel"]);
}
include "../../sqlinit.php";
$sqlconnection->set_charset("utf8");
$username = mysqli_real_escape_string($sqlconnection, htmlspecialchars($username));
if (isset($_SESSION['kbot_managementbot'])) {
    if ($_SESSION['kbot_managementbot'] == $username) {
        $canmanage = true;
    } else {
        if (isset(mysqli_fetch_array($sqlconnection, mysqli_query($sqlconnection, "SELECT name FROM canmanage WHERE channel='#" . $username . "';"))[0])) {
            $canmanage = true;
        } else {
            die();
        }
    }
} else {
    die();
}
if (isset($_POST["token"]) && isset($_POST["blacklisttolength"]) && isset($_POST["blacklisttotext"]) && isset($_POST["silentblacklistto"])) {
    if ($_POST["token"] == $_SESSION["onetimetoken"] && is_numeric($_POST["blacklisttolength"])) {

        $silentblacklistto = ($_POST["silentblacklistto"] == "true") ? 0 : 1;
        $blacklisttolength = mysqli_real_escape_string($sqlconnection, $_POST["blacklisttolength"]);
        $blacklisttotext = (strlen($_POST["blacklisttotext"]) > 500) ? substr(mysqli_real_escape_string($sqlconnection, $_POST["blacklisttotext"]), 0, 499) : mysqli_real_escape_string($sqlconnection, $_POST["blacklisttotext"]);
        mysqli_query($sqlconnection, "UPDATE botconfig SET blacklisttolength='".$blacklisttolength."', blacklisttotext='".$blacklisttotext."', silentblacklistto='".$silentblacklistto."' WHERE channel LIKE '#" . $username . "';");
        $botname = mysqli_fetch_array(mysqli_query($sqlconnection, 'SELECT ircusername FROM botconfig WHERE channel="#' . $_SESSION["kbot_managementbot"] . '";'))[0];
        mysqli_query($sqlconnection, "INSERT INTO bottodo (chatbot, type, initby, channel) VALUES ('$botname', 'reinit', '" . $_SESSION["kbot_userdisplayname"] . "', '#" . $_SESSION["kbot_managementbot"] . "')");
        echo "200";
        die();
    }

}
$botconfig = mysqli_fetch_assoc(mysqli_query($sqlconnection, "SELECT blacklisttolength, blacklisttotext, silentblacklistto FROM botconfig WHERE channel='#" . $username . "';"));

?>
<div class="form-group">
    <label for="blacklisttolength">Timeout length: </label>
    <select name="blacklisttolength" id="blacklisttolength" class="form-control">
        <option value="1" <?php echo ($botconfig["blacklisttolength"] == "1") ? "selected" : ""; ?>>Purge (1 second)</option>
        <option value="60" <?php echo ($botconfig["blacklisttolength"] == "60") ? "selected" : ""; ?>>1 Minute</option>
        <option value="300" <?php echo ($botconfig["blacklisttolength"] == "300") ? "selected" : ""; ?>>5 Minutes</option>
        <option value="600" <?php echo ($botconfig["blacklisttolength"] == "600") ? "selected" : ""; ?>>10 Minutes</option>
        <option value="1800" <?php echo ($botconfig["blacklisttolength"] == "1800") ? "selected" : ""; ?>>30 Minutes</option>
    </select>
</div>
<div class="form-group">
    <div class="checkbox">
        <label>
            <input type="checkbox" <?php echo($botconfig["silentblacklistto"] == "0" ? "checked" : "") ?> id="silentblacklistto"
                   name="silentblacklistto"> Send Timeout Notification
        </label>
    </div>
</div>
<div class="form-group">
    <label for="blacklisttotext">Timeout Notification Text: </label>
    <input type="text" class="form-control" id="blacklisttotext" value="<?php echo htmlspecialchars($botconfig["blacklisttotext"]);?>" />
</div>
