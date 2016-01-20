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
        echo "Invalid Token";
        die();
    }
} else {
    $username = htmlspecialchars($_GET["channel"]);
}
include "../sqlinit.php";
$username = mysqli_real_escape_string($sqlconnection, htmlspecialchars($username));
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

if ($canmanage) {
    $usersunparsed = mysqli_query($sqlconnection, "SELECT username, userlevel, id FROM users WHERE channel='#" . $username . "';");
    $botconfig = mysqli_fetch_array(mysqli_query($sqlconnection, "SELECT useuserapi, modlevel, regularlevel FROM botconfig WHERE channel='#" . $username . "';"));
} else {
    header("Location: https://kirschnbot.tk");
    die();
}
    ?>
<table class="table no-margin">
    <thead>
    <tr>
        <th>User</th>
        <th>Level</th>
        <?php if ($canmanage) {?><th width="180px">Actions</th><?php }; ?>
    </tr>
    </thead>
    <tbody>
    <?php


    while ($r = mysqli_fetch_assoc($usersunparsed)) {
        ?>
        <tr>
            <td>
                <?php echo $r["username"]; ?>
            </td>
            <td>
                <?php echo $r["userlevel"]; ?>
            </td>
            <?php if ($canmanage) {?>
                <td>
                    <a onclick="deleteuserset('<?php echo $r["id"]; ?>', '<?php echo $r["username"]; ?>')"><i class="fa fa-ban"></i> Delete </a>
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
