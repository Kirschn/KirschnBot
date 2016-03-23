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
if (isset($_POST["token"]) && isset($_POST["linktolength"]) && isset($_POST["linktotext"]) && isset($_POST["silentlinkto"])) {
    if ($_POST["token"] == $_SESSION["onetimetoken"] && is_numeric($_POST["linktolength"])) {

        $silentlinkto = ($_POST["silentlinkto"] == "true") ? 0 : 1;
        $linktolength = mysqli_real_escape_string($sqlconnection, $_POST["linktolength"]);
        $linktotext = (strlen($_POST["linktotext"]) > 500) ? substr(mysqli_real_escape_string($sqlconnection, $_POST["linktotext"]), 0, 499) : mysqli_real_escape_string($sqlconnection, $_POST["linktotext"]);
        mysqli_query($sqlconnection, "UPDATE botconfig SET linktolength='".$linktolength."', linktotext='".$linktotext."', silentlinkto='".$silentlinkto."' WHERE channel LIKE '#" . $username . "';");
        $botname = mysqli_fetch_array(mysqli_query($sqlconnection, 'SELECT ircusername FROM botconfig WHERE channel="#' . $_SESSION["kbot_managementbot"] . '";'))[0];
        mysqli_query($sqlconnection, "INSERT INTO bottodo (chatbot, type, initby, channel) VALUES ('$botname', 'reinit', '" . $_SESSION["kbot_userdisplayname"] . "', '#" . $_SESSION["kbot_managementbot"] . "')");
        echo "200";
        die();
    }

}
$botconfig = mysqli_fetch_assoc(mysqli_query($sqlconnection, "SELECT linktolength, linktotext, silentlinkto FROM botconfig WHERE channel='#" . $username . "';"));

?>
<div class="form-group">
    <label for="linktolength">Timeout length: </label>
    <select name="linktolength" id="linktolength">
        <option value="1" <?php echo ($botconfig["linktolength"] == "1") ? "selected" : ""; ?>>Purge (1 second)</option>
        <option value="60" <?php echo ($botconfig["linktolength"] == "60") ? "selected" : ""; ?>>1 Minute</option>
        <option value="300" <?php echo ($botconfig["linktolength"] == "300") ? "selected" : ""; ?>>5 Minutes</option>
        <option value="600" <?php echo ($botconfig["linktolength"] == "600") ? "selected" : ""; ?>>10 Minutes</option>
        <option value="1800" <?php echo ($botconfig["linktolength"] == "1800") ? "selected" : ""; ?>>30 Minutes</option>
    </select>
</div>
<div class="form-group">
    <div class="checkbox">
        <label>
            <input type="checkbox" <?php echo($botconfig["silentlinkto"] == "0" ? "checked" : "") ?> id="silentlinkto"
                   name="silentlinkto"> Send Timeout Notification
        </label>
    </div>
</div>
<div class="form-group">
    <label for="linktotext">Timeout text: </label>
    <input type="text" id="linktotext" value="<?php echo htmlspecialchars($botconfig["linktotext"]);?>" />
</div>
