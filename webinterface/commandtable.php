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
include 'sqlinit.php';
$sqlconnection->set_charset("utf8");
$username = mysqli_real_escape_string($sqlconnection, htmlspecialchars($username));
$sql = "SELECT commandname, text, userlevel, id, whispercommand FROM commands WHERE channel='#".strtolower($username)."';";
$commandsunparsed = mysqli_query($sqlconnection, $sql);
if (isset($_SESSION['kbot_managementbot'])) {
    if ($_SESSION['kbot_managementbot'] == $username) {
        $canmanage = true;
    } else {
        if (isset(mysqli_fetch_array(mysqli_query($sqlconnection, "SELECT name FROM canmanage WHERE channel='#" . $username . "';"))[0])) {
            $canmanage = true;
        } else {
            $canmanage = false;
        }
    }
} else {
    $canmanage = false;
}
$botconfig = mysqli_fetch_array(mysqli_query($sqlconnection, "SELECT modlevel, regularlevel FROM botconfig WHERE channel='#" . $username . "';"));
?>
<table class="table no-margin">
    <thead>
    <tr>
        <th>Command</th>
        <th>Return</th>
        <th>Userlevel</th>
        <?php if ($canmanage) {?><th width="130px">Actions</th><?php }; ?>
    </tr>
    </thead>
    <tbody>
    <?php


    while ($r = mysqli_fetch_assoc($commandsunparsed)) {
        ?>
        <tr>
            <td>
                <?php echo $r["commandname"]; ?>
            </td>
            <td>
                <?php echo $r["text"]; ?>
            </td>
            <td>
                <?php echo $r["userlevel"]; ?>
            </td>
            <?php if ($canmanage) {?>
                <td>

                    <a onclick="editcommanddialog('<?php echo $r["id"]; ?>', '<?php echo htmlspecialchars($r["text"]); ?>', '<?php echo htmlspecialchars($r["userlevel"]); ?>', '<?php echo htmlspecialchars($r["commandname"]); ?>')"><i class="fa fa-pencil"></i> Edit </a>
                    <a onclick="deletecommand('<?php echo $r["id"]; ?>', '<?php echo $r["commandname"]; ?>')"><i class="fa fa-ban"></i></i> Delete </a>&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-primary" onclick="$.get('function/switchwhispercom.php?token=<?php echo $_SESSION['onetimetoken']; ?>&comid=<?php echo $r["id"]; ?>&setto=<?php echo ($r["whispercommand"] == "0" ? "true" : "false") ?>').done($('#tablecontainer').load('commandtable.php'))"><?php echo ($r["whispercommand"] == "0" ? "Normal Answer" : "Whisper") ?> </button>
                </td>
            <?php } ?>
        </tr>
        <?php
    }
    if (!$login) {
        mysqli_close($sqlconnection);
    }
    ?>

    </tbody>
</table>