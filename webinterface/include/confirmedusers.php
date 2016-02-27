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
include "sqlinit.php";
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
$botconfig = mysqli_fetch_array(mysqli_query($sqlconnection, "SELECT modlevel, regularlevel FROM botconfig WHERE channel='#" . $username . "';"));
$result = mysqli_query($sqlconnection, "SELECT name FROM canmanage WHERE name='".$username."';");

?>
<div class="table-responsive" id="tablecontainer">
    All users you add here have <b>full</b> access to this webinterface!
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php


                            while ($r = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $r["name"]; ?>
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                                <?php
                            }
                            if (!$login) {
                                mysqli_close($sqlconnection);
                            }
                            ?>

</tbody>
</table>
</div><!-- /.table-responsive -->