<?php
$manageingpermissions = mysqli_fetch_assoc(mysqli_query($sqlconnection, "SELECT channel FROM canmanage WHERE name='".$_SESSION["kbot_realusername"]."'"));
if (isset($_POST["channel"]) && isset($_POST["token"])){
    session_start();
    $manageingpermissions[] = $_SESSION["kbot_realusername"];
    if (in_array($_POST["channel"], $manageingpermissions) && $_POST["token"] == $_SESSION["onetimetoken"])  {
        $_SESSION["kbot_managementbot"] = $_POST["channel"];
        echo "ok";
        die();
    }
}
?>

<div class="modal fade" id="switchbot" tabindex="-1" role="dialog" aria-labelledby="success">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="successname">Switch Bot</h4>
                                </div>
                                <div class="modal-body" id="successcontent">
                                    <select id="channelselector">
                                        <?php
                                        $manageingpermissions[] = $_SESSION["kbot_realusername"];

                                    foreach ($manageingpermissions as $currentchan) {
                                        if ($currentchan == $_SESSION["kbot_managementbot"]) {
                                            ?>
                                                <option selected>
                                                    <?php echo $currentchan; ?>
                                                </option>
                                            <?php
                                        } else {
                                            ?>
                                                <option>
                                                    <?php echo $currentchan; ?>
                                                </option>
                                            <?php
                                        }
                                    }
                                    ?>


                                    </select>
                                    <script>
                                        $("#channelselector").on('change', '#channelselector', function() {
                                            $.post("include/switchbot.php", {
                                                onetimetoken: "<?php echo $_SESSION["onetimetoken"]; ?>",
                                                channel: $("#channelselector").value;
                                            }).done(function (data) {
                                                if (data=="ok") {
                                                    location.reload();
                                                }
                                                });
                                            });
                                        });
                                    </script>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>