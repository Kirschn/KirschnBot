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
    if (isset($_POST["modlevel"]) && isset($_POST["regularlevel"])) {
        $useuserapi = (isset($_POST["useuserapi"]) ? 1 : 0);
        mysqli_query($sqlconnection, "UPDATE botconfig SET modlevel=\"".mysqli_real_escape_string($sqlconnection, $_POST["modlevel"]). "\", regularlevel=\"".mysqli_real_escape_string($sqlconnection, $_POST["regularlevel"]). "\", sublevel=\"".mysqli_real_escape_string($sqlconnection, $_POST["subscriberlevel"]). "\", useuserapi=\"" . $useuserapi . "\" WHERE channel='#" . $username . "';");
        $botname = mysqli_fetch_array(mysqli_query($sqlconnection, 'SELECT ircusername FROM botconfig WHERE channel="#' . $_SESSION["kbot_managementbot"] . '";'))[0];
        mysqli_query($sqlconnection, "INSERT INTO bottodo (chatbot, type, initby, channel) VALUES ('$botname', 'reinit', '" . $_SESSION["kbot_userdisplayname"] . "', '#" . $_SESSION["kbot_managementbot"] . "')");
        $execsql = true;
    }
$botconfig = mysqli_fetch_array(mysqli_query($sqlconnection, "SELECT useuserapi, modlevel, regularlevel, sublevel FROM botconfig WHERE channel='#" . $username . "';"));

    ?>
    <script>
        var config = {
            useuserapi: <?php echo ($botconfig["useuserapi"] == "0" ? "false" : "true") ?>,
            modlevel: <?php echo $botconfig["modlevel"]; ?>,
            regularlevel: <?php echo $botconfig["regularlevel"]; ?>
        }
    </script>

        <form class="form-horizontal" id="userconfigedit" action="function/config_users.php" method="POST">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" <?php echo ($botconfig["useuserapi"] == "0" ? "" : "checked") ?> name="useuserapi"> Read your moderators from the Twitch Chat
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="modlevel" class="col-sm-2 control-label">Standard userlevel for your mods:</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="modlevel" placeholder="100" name="modlevel" value="<?php echo $botconfig["modlevel"]; ?>">
                    </div>
                </div>
            <div class="form-group">
                <label for="userlevel" class="col-sm-2 control-label">Standard userlevel for your subscribers:</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="stduserlevel" placeholder="999" name="subscriberlevel" value="<?php echo $botconfig["sublevel"]; ?>">
                </div>
            </div>
                <div class="form-group">
                    <label for="userlevel" class="col-sm-2 control-label">Standard userlevel for your viewers:</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="stduserlevel" placeholder="999" name="regularlevel" value="<?php echo $botconfig["regularlevel"]; ?>">
                    </div>
                </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Ok</button>
            </div>
            <!-- /.box-footer -->
        </form>
        <?php if (isset($execsql)) { ?>
        <div class="modal fade" id="okdiag" tabindex="-1" role="dialog" aria-labelledby="Ok.">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="okdiagname">Edit successful</h4>
                                </div>
                                <div class="modal-body">
                                      Update successful.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        <script>
        $("#okdiag").modal();
</script>
        <?php } ?>
        <script src="https://kirschnbot.tk/jquery.form.js"></script>
        <script>
        $(document).ready(function() {
        $("#userconfigedit").ajaxForm({url: 'function/config_users.php', type: "post", success: function(data) {
                $("#userconfig").html(data)
        }});
        });

</script>
<?php } else {die();} ?>