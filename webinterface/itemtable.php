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
if (isset($_GET["list"])) {
    $sql = "SELECT id, item FROM useritems WHERE channel='#".strtolower($username)."' AND list='".mysqli_real_escape_string($sqlconnection, strtolower($_GET["list"]))."' ORDER BY list ASC, item ASC;";
} else {
    $sql = "SELECT id, item, list FROM useritems WHERE channel='#".strtolower($username)."' ORDER BY list ASC, item ASC;";
}
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
<label for="listselect">List: </label> <select id="listselect"><option <?php if (!isset($_GET["list"])) {?>selected<?php }?>>All</option>
    <?php
    // Read lists
    $sql = "SELECT DISTINCT list FROM useritems WHERE channel='#".strtolower($username)."' ORDER BY list ASC";
    $channelsunparsed = mysqli_query($sqlconnection, $sql);
    while ($r = mysqli_fetch_assoc($channelsunparsed)) {
        ?><option <?php if(isset($_GET["list"])) {if($_GET["list"] == $r["list"]) {echo "selected";}} ?>><?php echo $r["list"]; ?></option><?php
    }
    ?>
</select>
<script type="text/javascript">
    $("#listselect").change(function() {
        console.log(this);
        if ($("#listselect").val() == "All") {
            reloadurl = "itemtable.php";
        } else {
            reloadurl = "itemtable.php?list=" + $("#listselect").val();
        }

        $("#tablecontainer").load(reloadurl);
    })
</script>
<table class="table no-margin">
    <thead>
    <tr>
        <?php if (!isset($_GET["list"])) { ?><th>List</th><?php } ?>
        <th>Item</th>
        <th width="130px">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php


    while ($r = mysqli_fetch_assoc($commandsunparsed)) {
        ?>
        <tr>
            <?php if (!isset($_GET["list"])) { ?>
            <td>
                <?php echo $r["list"]; ?>
            </td><?php } ?>
            <td>
                <?php echo $r["item"]; ?>
            </td>
            <?php if ($canmanage) { ?>
                <td>
                    <a onclick="editcommanddialog('<?php echo $r["id"]; ?>', '<?php echo htmlspecialchars($r["item"]); ?>', '<?php echo htmlspecialchars($r["list"]); ?>')"><i class="fa fa-pencil"></i> Edit </a>
                    <a onclick="deletecommand('<?php echo $r["id"]; ?>', '<?php echo htmlspecialchars($r["item"]); ?>')"><i class="fa fa-ban"></i></i>&nbsp;Delete </a>&nbsp;&nbsp;&nbsp;
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