<?php
if (isset($_POST["onetimetoken"]) && !isset($_POST["action"])) {
    session_start();
    if ($_POST["onetimetoken"] == $_SESSION["onetimetoken"]) {
        if (!empty($_POST["commandid"]) && !empty($_POST["commandname"]) && !empty($_POST["commandtext"])) {
                include 'sqlinit.php';
                $sqlconnection->set_charset("utf8");
                $username = $_SESSION["kbot_managementbot"];
                $res = mysqli_query($sqlconnection, "UPDATE timer SET name=\"".mysqli_real_escape_string($sqlconnection, $_POST["commandname"])."\", text=\"".mysqli_real_escape_string($sqlconnection, $_POST["commandtext"])."\", timerinterval=\"".mysqli_real_escape_string($sqlconnection, $_POST["interval"])."\", linex=\"".mysqli_real_escape_string($sqlconnection, $_POST["lines"])."\" WHERE id=\"".mysqli_real_escape_string($sqlconnection, $_POST["commandid"])."\" AND channel='#$username';");
                echo "Ok.";
                mysqli_close($sqlconnection);
        }
    }
    die();
} else if (isset($_POST["id"])) {
    session_start();
    if(!isset($_SESSION["kbot_managementbot"])) {
        echo "Session expired";
        die();
    }
    include 'sqlinit.php';
    $sqlconnection->set_charset("utf8");
    $sql = "SELECT name, timerinterval, text, linex FROM timer WHERE id='" . intval($_POST["id"]) . "' AND channel='#".strtolower($_SESSION["kbot_managementbot"])."'";
    $lol = mysqli_fetch_assoc(mysqli_query($sqlconnection, $sql));
    header('Content-Type: text/html; charset=utf-8');
    ?>
    <form role="form" id="editcommandcommand" method="post" action="index.php">
            <div class="form-group">
                <label for="commandname">Name</label>
                <input type="text" class="form-control" id="commandtext" name="commandtext" placeholder="socialmedia" value="<?php echo htmlspecialchars($lol["name"]);?>">
            </div>
        <div class="form-group">
            <label for="interval">Interval</label>
            <input type="text" class="form-control" id="interval" name="interval" placeholder="10" value="<?php echo htmlspecialchars($lol["timerinterval"]);?>">
        </div>
        <div class="form-group">
            <label for="lines">Lines</label>
            <input type="text" class="form-control" id="lines" name="lines" placeholder="5" value="<?php echo htmlspecialchars($lol["linex"]);?>">
        </div>

            <input type="hidden" value="<?php echo $_SESSION["onetimetoken"]; ?>" name="onetimetoken"/>
            <input type="hidden" value="<?php echo $_POST["id"]; ?>" name="commandid" />

            <div class="form-group">
                <label>Text</label>
                <textarea class="form-control" rows="3" name="commandname"><?php echo htmlspecialchars($lol["text"]); ?></textarea>
            </div>
        <!-- /.box-body -->
            <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <?php
} else {
    echo "Invalid request";
}
?>