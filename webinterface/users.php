<?php
if (isset($_GET["channel"])) {
    header("Location: http://kirschn.de");
    die();
}
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
$sqlconnection->set_charset("utf8");
$username = mysqli_real_escape_string($sqlconnection, htmlspecialchars($username));
$sql = "SELECT id, name, text, username FROM quotes WHERE channel='#".strtolower($username)."';";
$commandsunparsed = mysqli_query($sqlconnection, $sql);
if (isset($_SESSION['kbot_managementbot'])) {
    if ($_SESSION['kbot_managementbot'] == $username) {
        $canmanage = true;
    } else {
        if (isset(mysqli_fetch_array($sqlconnection, mysqli_query($sqlconnection, "SELECT name FROM canmanage WHERE channel LIKE '#" . $username . "';"))[0])) {
            $canmanage = true;
        } else {
            $canmanage = false;
        }
    }
} else {
    $canmanage = false;
}

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
    <link rel="stylesheet" href="dist/css/skins/skin-purple.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        function reload() {
            $("#userconfig").load("function/config_users.php");
            $("#userleveltable").load("function/usertable.php");
        }
        function deleteuserset(id) {
            if(window.confirm("Delete this user from the database?")) {
                $.post("function/usertable.php", {
                    userid: id,
                    removeuser: 1
                }).done(function() {
                    reload();
                })
            }
        }
        $("#adduserform").ajaxForm({url: 'function/usertable.php', type: "post", success: function(data) {
            $("#addusermodalcontent").html(data);
            $("#addusermodel").modal();
            $("#adduserform").resetForm();
            reload();
        }});
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
<body class="hold-transition skin-blue sidebar-mini" onload="reload()">
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
                            <img src="<?php if ($login) { if (!empty($_SESSION["kbot_profileimglink"])) { echo $_SESSION["kbot_profileimglink"]; } else { ?>img/anonymous.png<?php } } else {?>img/anonymous.png<?php }; ?>" class="user-image" alt="User Image">
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
                                        <?php if ($login) { echo $_SESSION["kbot_userdisplayname"]; } else { ?>Anonymous<?php } ?>
                                        <small>Managing Bot in Channel <?php echo $_SESSION["kbot_managementbot"]; ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" onclick="$('#switchbot').modal();" class="btn btn-default btn-flat">Switch Bot</a>
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
                    <img src="<?php if ($login) { if (!empty($_SESSION["kbot_profileimglink"])) { echo $_SESSION["kbot_profileimglink"]; } else { ?>img/anonymous.png<?php } } else {?>img/anonymous.png<?php }; ?>" class="img-circle" alt="User Image">
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
                Users
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> KirschnBot</a></li>
                <li class="active">Users: <?php echo $username; ?></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php
            if ($canmanage) {
            ?>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Configuration</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body" id="userconfig">
                    Loading...
                </div>
                <!-- /.box-body -->
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Custom Userlevel</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body" id="userleveltable">
                    Loading...
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add User</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="adduserform" method="post" action="function/usertable.php">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="thekirschn">
                        </div>
                        <div class="form-group">
                            <label for="userlevel">Userlevel: </label>
                            <select name="userleveldropdown" id="userleveldropdown">
                                <option selected>Chatter</option>
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
                                    if (value == "Chatter") {
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
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <?php
                } else {
                    ?>
                    Please log in to see this information!
                    <?php
                }
                ?>
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
                    Please <a href="login.php">Sign in</a>
                <?php }; ?>
            </ul><!-- /.control-sidebar-menu -->
        </div>
    </aside><!-- /.control-sidebar -->
    <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

</body>
</html>
