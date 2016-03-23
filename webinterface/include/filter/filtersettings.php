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
if (isset($_POST["token"]) && isset($_POST["linkfilter"]) && isset($_POST["blacklistfilter"])) {
    if ($_POST["token"] == $_SESSION["onetimetoken"]) {
            $linkfilter = ($_POST["linkfilter"] == "true") ? 1 : 0;
            $blacklistfilter = ($_POST["blacklistfilter"] == "true") ? 1 : 0;
            mysqli_query($sqlconnection, "UPDATE botconfig SET linkfilter='".$linkfilter."', blacklistfilter='".$blacklistfilter."' WHERE channel LIKE '#" . $username . "';");
            $botname = mysqli_fetch_array(mysqli_query($sqlconnection, 'SELECT ircusername FROM botconfig WHERE channel="#' . $_SESSION["kbot_managementbot"] . '";'))[0];
            mysqli_query($sqlconnection, "INSERT INTO bottodo (chatbot, type, initby, channel) VALUES ('$botname', 'reinit', '" . $_SESSION["kbot_userdisplayname"] . "', '#" . $_SESSION["kbot_managementbot"] . "')");

        echo "200";
        die();
    }

}
$botconfig = mysqli_fetch_assoc(mysqli_query($sqlconnection, "SELECT linkfilter, blacklistfilter FROM botconfig WHERE channel='#" . $username . "';"));

?>
<div class="form-group">
        <div class="checkbox">
            <label>
                <input type="checkbox" <?php echo($botconfig["linkfilter"] == "0" ? "" : "checked") ?> id="linkfilter"
                       name="linkfilter"> Auto-Timeout URLs in your chat
            </label>
        </div>
</div>

<div class="form-group">
        <div class="checkbox">
            <label>
                <input type="checkbox" <?php echo($botconfig["blacklistfilter"] == "0" ? "" : "checked") ?> id="blacklistfilter"
                       name="blacklistfilter"> Auto-Timeout blacklisted phrases in your chat
            </label>
        </div>
</div>
