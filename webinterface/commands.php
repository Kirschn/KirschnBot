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
$sql = "SELECT commandname, text, userlevel, id FROM commands WHERE channel='#".strtolower($username)."';";
$commandsunparsed = mysqli_query($sqlconnection, $sql);
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
    $canmanage = false;
}
$botconfig = mysqli_fetch_array(mysqli_query($sqlconnection, "SELECT modlevel, regularlevel FROM botconfig WHERE channel='#" . $username . "';"));
header("Content-Type: text/html; charset=utf-8");
$token = rand(0, 1024);
$_SESSION["kbot_logouttoken"] = $token;
$_SESSION["onetimetoken"] = $token;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="jquery.form.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>KirschnBot</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        $(document).ready(function () {
            $("#addcommand").ajaxForm({url: 'function/addcommand.php', type: "post", success: function(data) {
                $("#addcommodal").html(data);
                $("#commandcreate").modal();
                $("#addcommand").resetForm();
                $("#tablecontainer").load("commandtable.php");
            }});
        });
        function deletecommand(id, name) {
            if(window.confirm("Do you really want to delete " + name + "?")) {
                $.get("function/deletecommand.php?commandname="+name+"&commandid="+id+"&token=<?php echo $_SESSION["onetimetoken"]; ?>", function(data) {
                    $("#deletecommodal").html(data);
                    $("#commanddelete").modal();
                    $("#tablecontainer").load("commandtable.php");
                });

            }
        }
        function editcommanddialog(cid, ctext, cuserlevel, ccommandname) {
            $.post("https://kirschnbot.tk/function/editcommand_include.php", {
                id: cid,
                commandtext: ctext,
                userlevel: cuserlevel,
                commandname: ccommandname,
                onetimetoken: "<?php echo $_SESSION["onetimetoken"]; ?>",
                action: "editform"
            }).done(function (data) {
                $("#editcommmodal").html(data);
                $("#commandedit").modal();
                $("#editcommandcommand").ajaxForm({url: 'https://kirschnbot.tk/function/editcommand_include.php', type: "post", success: function(dataformpost) {
                    $("#editcommmodal").html(dataformpost);
                    $("#tablecontainer").load("commandtable.php");
                }
                });
            });
        }


    </script>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="index.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>Bot</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">Kirschn<b>Bot</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <!-- Menu toggle button -->

                        <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="<?php if ($login) { echo $_SESSION["kbot_profileimglink"]; } else {?>img/anonymous.png<?php }; ?>" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs"><?php if ($login) { echo $_SESSION["kbot_userdisplayname"]; } else {?>Anonymous<?php }; ?></span>
                        </a>
                        <?php if ($login) {
                            ?>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="<?php if ($_SESSION["kbot_profileimglink"] == "") { echo "img/anonymous.png"; } else { echo $_SESSION["kbot_profileimglink"]; }  ?> "class="img-circle" alt="User Image">
                                    <p>
                                        <?php echo $_SESSION["kbot_userdisplayname"]; ?>
                                        <small>Managing Bot in Channel <?php echo $_SESSION["kbot_managementbot"]; ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Switch Bot</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="function/logout.php?token=<?php echo $token; ?>" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                            <?php
                        } else {
                            ?>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="img/anonymous.png" class="img-circle" alt="User Image">
                                    <p>
                                        Anonymous
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <!-- Menu Footer-->
                                <li class="user-footer">

                                </li>
                            </ul>
                            <?php
                        }
                        ?>

                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php if ($login) { echo $_SESSION["kbot_profileimglink"]; } else {?>img/anonymous.png<?php }; ?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php if ($login) { echo $_SESSION["kbot_userdisplayname"]; } else {?>Anonymous<?php }; ?></p>
                </div>
            </div>


            <!-- Sidebar Menu -->
            <?php include 'include/menu.php'; ?>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Commands
                <small><?php if ($canmanage) { echo 'Some help for your Moderators'; } else { echo 'View only!'; } ?></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> KirschnBot</a></li>
                <li class="active">Commands: <?php echo $username; ?></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">User Commands</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive" id="tablecontainer">
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th>Command</th>
                                <th>Return</th>
                                <th>Userlevel</th>
                                <?php if ($canmanage) {?><th width="130px">Actions</th><?php }; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php


                            while ($r = mysqli_fetch_assoc($commandsunparsed)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $r["commandname"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $r["text"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $r["userlevel"]; ?>
                                    </td>
                                    <?php if ($canmanage) {?>
                                        <td>
                                            <a onclick="editcommanddialog('<?php echo $r["id"]; ?>', '<?php echo htmlspecialchars($r["text"]); ?>', '<?php echo htmlspecialchars($r["userlevel"]); ?>', '<?php echo htmlspecialchars($r["commandname"]); ?>')"><i class="fa fa-pencil"></i> Edit </a>
                                            <a onclick="deletecommand('<?php echo $r["id"]; ?>', '<?php echo htmlspecialchars($r["commandname"]); ?>')"><i class="fa fa-ban"></i></i>&nbsp;Delete </a>
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
                    </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
            </div>
            <?php if ($canmanage) {
                ?>

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Command</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="addcommand" method="post" action="function/addcommand.php">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="commandname">Command</label>
                                <input type="text" class="form-control" id="commandname" name="commandname" placeholder="!mycommand">
                            </div>
                            <div class="form-group">
                                <label for="userlevel">Userlevel: </label>
                                <select name="userleveldropdown" id="userleveldropdown">
                                    <option selected>Everyone</option>
                                    <option>Moderator</option>
                                    <option>Streamer</option>
                                    <option>Custom</option>
                                </select>
                                <?php
                                $presets = mysqli_fetch_array(mysqli_query($sqlconnection, "SELECT modlevel, regularlevel FROM botconfig WHERE channel='#". $_SESSION["kbot_managementbot"] . "'"));
                                ?>
                                <input type="hidden" id="userlevel" name="userlevel" value="<?php echo $presets["regularlevel"]; ?>" class="form-control"">
                                <script>
                                    $("#userleveldropdown").change(function() {
                                        var value = document.getElementById("userleveldropdown").value;
                                        if (value == "Everyone") {
                                            document.getElementById("userlevel").value = <?php
                                                $presets = mysqli_fetch_array(mysqli_query($sqlconnection, "SELECT modlevel, regularlevel FROM botconfig WHERE channel='#". $_SESSION["kbot_managementbot"] . "'"));
                                                echo $presets["regularlevel"];
                                            ?>;
                                            document.getElementById("userlevel").type = "hidden";
                                        } else if (value == "Moderator") {
                                            document.getElementById("userlevel").value = "<?php echo $presets["modlevel"]; ?>";
                                            document.getElementById("userlevel").type = "hidden";
                                        } else if (value == "Streamer") {
                                            document.getElementById("userlevel").value = 5;
                                            document.getElementById("userlevel").type = "hidden";
                                        } else if (value == "Custom") {
                                            document.getElementById("userlevel").type = "text";
                                            document.getElementById("userlevel").placeholer = "Custom Userlevel";
                                        }
                                    })
                                </script>
                            </div>
                            <input type="hidden" value="<?php echo $token; ?>" name="token" />
                            <div class="form-group">
                                <label>Command Text</label>
                                <textarea class="form-control" rows="3" name="commandtext"></textarea>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    <!-- Modal -->
                    <div class="modal fade" id="commandcreate" tabindex="-1" role="dialog" aria-labelledby="commandcreate">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="commandaddname">Add Command</h4>
                                </div>
                                <div class="modal-body" id="addcommodal">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="commanddelete" tabindex="-1" role="dialog" aria-labelledby="commanddelete">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="commanddeletename">Delete Command</h4>
                            </div>
                            <div class="modal-body" id="deletecommodal">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="commandedit" tabindex="-1" role="dialog" aria-labelledby="commandedit">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="commandeditname">Commandedit</h4>
                            </div>
                            <div class="modal-body" id="editcommmodal">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } ?>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Main Footer -->
    <?php include 'include/footer.php'; ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
                <?php
                if ($login) {
                    include "include/activity.php";
                } else { ?>
                    Please <a href="login">Sign in</a>
                <?php }; ?>
            </ul><!-- /.control-sidebar-menu -->
        </div>
    </aside><!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->B

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>
