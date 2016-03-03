<?php
session_start();
if (isset($_SESSION["kbot_logon"])) {
    $login = true;
} else {
    $login = false;
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
            $canmanage = false;
        }
    }
} else {
    die();
}
$botconfig = mysqli_fetch_assoc(mysqli_query($sqlconnection, "SELECT linkfilter, blacklistfilter FROM botconfig WHERE channel='#" . $username . "';"));

?>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <div class="checkbox">
            <label>
                <input type="checkbox" <?php echo($botconfig["linkfilter"] == "0" ? "" : "checked") ?>
                       name="linkfilter"> Auto-Timeout URLs in your chat
            </label>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <div class="checkbox">
            <label>
                <input type="checkbox" <?php echo($botconfig["blacklistfilter"] == "0" ? "" : "checked") ?>
                       name="blacklistfilter"> Auto-Timeout URLs in your chat
            </label>
        </div>
    </div>
</div>