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
    $username = htmlentities($_GET["channel"]);
}
include 'sqlinit.php';
$sqlconnection->set_charset("utf8");
$username = mysqli_real_escape_string($sqlconnection, htmlentities($username));
$sql = "SELECT id, text, name, timerinterval, active, linex FROM timer WHERE channel='#".strtolower($username)."';";
$commandsunparsed = mysqli_query($sqlconnection, $sql);
if (isset($_SESSION['kbot_managementbot'])) {
    if ($_SESSION['kbot_managementbot'] == $username) {
        $canmanage = true;
    } else {
        if (isset(mysqli_fetch_array(mysqli_query($sqlconnection, "SELECT name FROM canmanage WHERE channel='#" . $username . "';"))[0])) {
            $canmanage = true;
        } else {
            die();
        }
    }
} else {
    die();
}
?>
<table class="table no-margin">
    <thead>
    <tr>
        <th>Name</th>
        <th>Text</th>
        <th>Interval</th>
        <th>Lines</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php


    while ($r = mysqli_fetch_assoc($commandsunparsed)) {
        ?>
        <tr>
            <td>
                <?php echo $r["name"]; ?>
            </td>
            <td>
                <?php echo $r["text"]; ?>
            </td>

            <td>
                <?php echo $r["timerinterval"]; ?>
            </td>
            <td>
                <?php echo $r["lines"]; ?>
            </td>
            <?php if ($canmanage) {?>
                <td>
                    <button type="submit" class="btn btn-primary" onclick="$.get('function/togglebot.php?token=<?php echo $_SESSION["onetimetoken"]; ?>&action=0&actiondo=0', function(data) {$('#activatebot').load('function/togglebot.php?action=0')})"><?php echo $vorsilbe; ?>able</button>
                    <a onclick="editcommanddialog('<?php echo $r["id"]; ?>')"><i class="fa fa-pencil"></i> Edit </a>
                    <a onclick="deletecommand('<?php echo $r["id"]; ?>')"><i class="fa fa-ban"></i></i>&nbsp;Delete </a>&nbsp;&nbsp;&nbsp;</td>
                    
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