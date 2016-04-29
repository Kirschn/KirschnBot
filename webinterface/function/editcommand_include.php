<?php
if (isset($_POST["onetimetoken"]) && !isset($_POST["action"])) {
    session_start();
    if ($_POST["onetimetoken"] == $_SESSION["onetimetoken"]) {
        if (!empty($_POST["commandid"]) && !empty($_POST["commandname"]) && !empty($_POST["userlevel"]) && !empty($_POST["commandtext"])) {
                include 'sqlinit.php';
                $sqlconnection->set_charset("utf8");
                $res = mysqli_query($sqlconnection, "UPDATE commands SET commandname=\"".mysqli_real_escape_string($sqlconnection, $_POST["commandname"])."\", text=\"".mysqli_real_escape_string($sqlconnection, $_POST["commandtext"])."\", userlevel=\"".mysqli_real_escape_string($sqlconnection, $_POST["userlevel"])."\" WHERE id=\"".mysqli_real_escape_string($sqlconnection, $_POST["commandid"])."\" AND channel=\"#" . mysqli_real_escape_string($sqlconnection, $_SESSION["kbot_managementbot"]) . "\";");
                mysqli_close($sqlconnection);
                echo "Ok.";
        }
    }
    die();
} else if (isset($_POST["id"])) {
    session_start();
    include 'sqlinit.php';
    $sqlconnection->set_charset("utf8");
    $sql = "SELECT commandname, text, userlevel FROM commands WHERE id='" . intval($_POST["id"]) . "' AND channel='#".strtolower($_SESSION["kbot_managementbot"])."'";
    $lol = mysqli_fetch_assoc(mysqli_query($sqlconnection, $sql));
    header('Content-Type: text/html; charset=utf-8');
    ?>
    <form role="form" id="editcommandcommand" method="post" action="function/addcommand.php">
            <div class="form-group">
                <label for="commandname">Command</label>
                <input type="text" class="form-control" id="commandname" name="commandname" placeholder="!mycommand" value="<?php echo htmlspecialchars($lol["commandname"]); ?>">
            </div>
            <div class="form-group">
                <label for="userlevel">Userlevel: </label>
                <input type="text" name="userlevel" value="<?php echo $lol["userlevel"]; ?>" placeholder="000-999">
            </div>
            <input type="hidden" value="<?php echo $_SESSION["onetimetoken"]; ?>" name="onetimetoken"/>
            <input type="hidden" value="<?php echo $_POST["id"]; ?>" name="commandid" />
            <div class="form-group">
                <label>Command Text</label>
                <textarea class="form-control" rows="3" name="commandtext"><?php echo htmlspecialchars($lol["text"]); ?></textarea>
            </div>
        <!-- /.box-body -->
            <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <?php
} else {
    echo "Invalid request";
}
?>