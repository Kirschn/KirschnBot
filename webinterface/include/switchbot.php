<?php

if (isset($_POST["channel"]) && isset($_POST["token"])){
    session_start();
    include "../sqlinit.php";
    $manageingpermissions = [];
    $result = mysqli_query($sqlconnection, "SELECT channel FROM canmanage WHERE name='".$_SESSION["kbot_realusername"]."';");
    while ($entry = mysqli_fetch_assoc($result)) {
        $manageingpermissions[] = $entry["channel"];
    }
    $manageingpermissions[] = $_SESSION["kbot_realusername"];
    if (in_array(".global", $manageingpermissions)) {
        $manageingpermissions = [];
        $result = mysqli_query($sqlconnection, "SELECT channel FROM botconfig;");
        while ($entry = mysqli_fetch_assoc($result)) {
            $manageingpermissions[] = str_replace("#", "", $entry["channel"]);
        }
    } else {
        $manageingpermissions[] = $entry["channel"];
    }
    if (in_array($_POST["channel"], $manageingpermissions) && $_POST["token"] == $_SESSION["onetimetoken"])  {
        $_SESSION["kbot_managementbot"] = $_POST["channel"];
        echo "ok";
        header("Location: https://kirschnbot.tk/commands.php");

    } else {
        echo "Request invalid";

    }
    die();
}
$manageingpermissions = [];
$result = mysqli_query($sqlconnection, "SELECT channel FROM canmanage WHERE name='".$_SESSION["kbot_realusername"]."';");
while ($entry = mysqli_fetch_assoc($result)) {
    $manageingpermissions[] = $entry["channel"];
}

if (in_array(".global", $manageingpermissions)) {
    $manageingpermissions = [];
    $result = mysqli_query($sqlconnection, "SELECT channel FROM botconfig;");
    while ($entry = mysqli_fetch_assoc($result)) {
        $manageingpermissions[] = str_replace("#", "", $entry["channel"]);
    }
}
if (isset($_SESSION["kbot_realusername"])) {
?>

<div class="modal fade" id="switchbot" tabindex="-1" role="dialog" aria-labelledby="success">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="successname">Switch Bot</h4>
                                </div>
                                <form method="POST" action="include/switchbot.php">
                                <div class="modal-body" id="successcontent">
                                    <select name="channel">
                                        <?php
                                        $manageingpermissions[] = $_SESSION["kbot_realusername"];

                                    foreach ($manageingpermissions as $currentchan) {
                                        if ($currentchan == $_SESSION["kbot_managementbot"]) {
                                            ?>
                                                <option value="<?php echo $currentchan; ?>" selected>
                                                    <?php echo $currentchan; ?>
                                                </option>
                                            <?php
                                        } else {
                                            ?>
                                                <option value="<?php echo $currentchan; ?>">
                                                    <?php  echo $currentchan; ?>
                                                </option>
                                            <?php
                                        }
                                    }
                                    ?>


                                    </select>
                                    <input type="hidden" name="token" value="<?php echo $_SESSION["onetimetoken"]; ?>" />
                                    <script>
                                    //    $(document).on('change', '#channelselector', function() {
                                     //       console.log("SELECT");
                                     //       $.post("include/switchbot.php", {
                                     //           token: "<?php echo $_SESSION["onetimetoken"]; ?>",
                                      //          channel: $("#channelselector").value
                                       //     }).done(function (data) {
                                        //        if (data=="ok") {
                                         //           location.reload();
                                          //      }
                                           //     });
                                            // });
                                    </script>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Select</button>
                                </div>
                                    </form>
                            </div>
                        </div>
                    </div>
<?php
}
?>
