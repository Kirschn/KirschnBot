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
        die();
    }
} else {
    $username = htmlspecialchars($_GET["channel"]);
}
include '../../sqlinit.php';
$sqlconnection->set_charset("utf8");
$username = mysqli_real_escape_string($sqlconnection, htmlspecialchars($username));
$sql = "SELECT id, link FROM linkwhitelist WHERE channel='#".strtolower($username)."';";
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
if (!$canmanage) {
    die();
}
?>
<table class="table no-margin">
    <thead>
    <tr>
        <th>Link</th>
        <th width="130px">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php


    while ($r = mysqli_fetch_assoc($commandsunparsed)) {
        ?>
        <tr>
            <td>
                <?php echo $r["link"]; ?>
            </td>
                <td>
                    <button type="button" class="btn btn-primary" onclick="$.get('function/removelinkwhitelist.php?token=<?php echo $_SESSION['onetimetoken']; ?>&id=<?php echo $r["id"]; ?>').done(function() {$('#linkwhitelist').load('include/filter/linkfiltertable.php')})">Remove</button>
                </td>
        </tr>
        <?php
    }

        mysqli_close($sqlconnection);

    ?>

    </tbody>
</table>
