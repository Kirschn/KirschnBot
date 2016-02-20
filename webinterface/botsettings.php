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
    $canmanage = false;
}
$botconfig = mysqli_fetch_array(mysqli_query($sqlconnection, "SELECT modlevel, regularlevel FROM botconfig WHERE channel='#" . $username . "';"));
if (isset($_POST["token"]) && isset($_POST["username"]) && isset($_POST["onetimetoken"])) {
    if ($_POST["onetimetoken"] == $_SESSION["onetimetoken"]) {
        if ($_POST["submit"] == "reset") {
            mysqli_query($sqlconnection, "UPDATE botconfig SET ircusername=DEFAULT,ircoauthtoken=DEFAULT  WHERE channel='#" . $username . "';");
        } else {
            mysqli_query($sqlconnection, "UPDATE botconfig SET ircusername='" . mysqli_real_escape_string($sqlconnection, $_POST["username"]) . "', ircoauthtoken='" . mysqli_real_escape_string($sqlconnection, $_POST["token"]) . "' WHERE channel='#" . $username . "';");
        }
        echo "Operation successfull";
        mysqli_close($sqlconnection);
        die();
    }
}
$token = rand(0, 1024);
$_SESSION["kbot_logouttoken"] = $token;
$_SESSION["onetimetoken"] = $token;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
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
            $("#editbotform").ajaxForm({url: 'botsettings.php', type: "post", success: function(data) {
                $("#successcontent").html(data);
                $("#success").modal();
                $("#editbotform").resetForm();
            }});
        });



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
                                        <?php if (!empty($_SESSION["kbot_profileimglink"])) { echo $_SESSION["kbot_profileimglink"]; } else { ?>img/anonymous.png<?php } ?>
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
                    <img src="<?php if ($login) {  if (!empty($_SESSION["kbot_profileimglink"])) { echo $_SESSION["kbot_profileimglink"]; } else { ?>img/anonymous.png<?php }  } else {?>img/anonymous.png<?php }; ?>" class="img-circle" alt="User Image">
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
                Settings
                <small><?php if ($canmanage) { echo 'Settings'; } else { echo 'Just some general stuff'; } ?></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> KirschnBot</a></li>
                <li class="active">Settings: <?php echo $username; ?></li>
            </ol>
        </section>

        <!-- Main content -->

        <section class="content"><div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Command</h3>
                </div>
            <form role="form" id="editbotform" method="post" action="function/botsettings.php">
                <div class="box-body">
                    Generate an OAuth Token here: <a href="https://twitchapps.com/tmi/">https://twitchapps.com/tmi/</a><br>
                    <div class="form-group">
                        <label for="username">Username</label>

                        <input type="text" class="form-control" id="username" name="username" placeholder="kirschnbot">
                        <label for="token">OAuth Token</label>
                        <input type="password" class="form-control" id="token" name="token" placeholder="aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa">
                        <input type="hidden" name="onetimetoken" value="<?php echo $token; ?>">
                    </div>
                    </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" name="submit" class="btn btn-primary" value="submit">Submit</button>
                    <button type="submit" name="submit" class="btn btn-primary" value="reset">Reset to "KirschnBot"</button>
                </div>
            </form>
        </div>


                    <!-- Modal -->
                    <div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="success">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="successname">Operation Success</h4>
                                </div>
                                <div class="modal-body" id="successcontent">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
    <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

</body>
</html>
