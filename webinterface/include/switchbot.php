

<div class="modal fade" id="switchbot" tabindex="-1" role="dialog" aria-labelledby="success">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="successname">Switch Bot</h4>
                                </div>
                                <div class="modal-body" id="successcontent">
                                    <select>
                                        <?php
                                    $manageingpermissions = mysqli_fetch_array($sqlconnection, mysqli_query($sqlconnection, "SELECT channel FROM canmanage WHERE name='".$_SESSION["kbot_realusername"]."';"));
                                        echo var_dump($manageingpermissions);
                                        $manageingpermissions[] = $_SESSION["kbot_realusername"];
                                    foreach ($manageingpermissions as $currentchan) {
                                        if ($currentchan == $_SESSION["kbot_managementbot"]) {
                                            ?><option selected><?php echo $currentchan; ?></option><?php
                                        } else {
                                            ?><option><?php echo $currentchan; ?></option><?php
                                        }
                                    }
                                    ?>


                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>