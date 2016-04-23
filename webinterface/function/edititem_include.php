<?php
if (isset($_POST["onetimetoken"]) && !isset($_POST["action"])) {
    session_start();
    if ($_POST["onetimetoken"] == $_SESSION["onetimetoken"]) {
        if (!empty($_POST["commandid"]) && !empty($_POST["commandname"]) && !empty($_POST["commandtext"])) {
                include 'sqlinit.php';
                $sqlconnection->set_charset("utf8");
                $res = mysqli_query($sqlconnection, "UPDATE useritems SET list=\"".mysqli_real_escape_string($sqlconnection, $_POST["commandname"])."\", item=\"".mysqli_real_escape_string($sqlconnection, $_POST["commandtext"])."\" WHERE id=\"".mysqli_real_escape_string($sqlconnection, $_POST["commandid"])."\";");
                echo "Ok.";
                mysqli_close($sqlconnection);
        }
    }
    die();
} else if (isset($_POST["id"]) && isset($_POST["commandtext"]) && isset($_POST["commandname"])) {
    session_start();
    header('Content-Type: text/html; charset=utf-8');
    ?>
    <form role="form" id="editcommandcommand" method="post" action="function/addcommand.php">
            <div class="form-group">
                <label for="commandname">List</label>
                <input type="text" class="form-control" id="commandtext" name="commandtext" placeholder="teas" value="<?php echo str_replace('"', '\"', $_POST["commandtext"]);?>">
            </div>
            <input type="hidden" value="<?php echo $_SESSION["onetimetoken"]; ?>" name="onetimetoken"/>
            <input type="hidden" value="<?php echo $_POST["id"]; ?>" name="commandid" />
            <div class="form-group">
                <label>Item</label>
                <textarea class="form-control" rows="3" name="commandname"><?php echo $_POST["commandname"]; ?></textarea>
            </div>
        <!-- /.box-body -->
            <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <?php
} else {
    echo "Invalid request";
}
?>