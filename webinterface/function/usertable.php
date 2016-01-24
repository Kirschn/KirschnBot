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
    if (isset($_POST["removeuser"]) && isset($_POST["userid"])) {
        // REMOVE USER FROM DATABASE
        mysqli_query($sqlconnection, "DELETE FROM users WHERE id=\"".mysqli_real_escape_string($sqlconnection, $_POST["userid"])."\" AND channel='#" . $username . "';");
    }
    $usersunparsed = mysqli_query($sqlconnection, "SELECT username, userlevel, id FROM users WHERE channel='#" . $username . "';");
    $botconfig = mysqli_fetch_array(mysqli_query($sqlconnection, "SELECT useuserapi, modlevel, regularlevel FROM botconfig WHERE channel='#" . $username . "';"));
    if (isset($_POST["username"]) && isset($_POST["userlevel"]) && isset($_POST["token"])) {
        if ($_POST["token"] == $_SESSION["onetimetoken"]) {
            mysqli_query($sqlconnection, "INSERT INTO `users`(`channel`, `userlevel`, `username`) VALUES ('#" . mysqli_real_escape_string($sqlconnection, $_SESSION["kbot_managementbot"]) . "', '" . mysqli_real_escape_string($sqlconnection, $_POST["userlevel"]) . "', '" . mysqli_real_escape_string($sqlconnection, $_POST["username"]) . "');");

            echo "Operation complete.";
            die();
        }
    }
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
