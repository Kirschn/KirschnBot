<?php
session_start();
include 'twitchtv.php';
$twitchtv = new TwitchTV;
if (isset($_SESSION["kbot_logon"])) {
    header("Location: commands.php");
    die();
} else {

    if (isset($_GET["code"])) {
        $ttv_code = $_GET['code'];
        $access_token = $twitchtv->get_access_token($ttv_code);
        $username = $twitchtv->authenticated_user($access_token);
        $useroptions = $twitchtv->load_channel($username);
        $_SESSION["kbot_logon"] = true;
        $_SESSION["kbot_profileimglink"] = str_replace("http://", "https://", $useroptions["logo"]);
        $_SESSION["kbot_userdisplayname"] = $useroptions["display_name"];
        $_SESSION["kbot_managementbot"] = $username;

        include "sqlinit.php";
        $botexissresults = mysqli_query($sqlconnection, "SELECT id FROM botconfig WHERE channel='#".$username."'");
        if (isset(mysqli_fetch_array($botexissresults)[0])) {
            header("Location: index.php");
            mysqli_close($sqlconnection);
            die();
        } else {
            echo "Bot not existant";
            mysqli_query($sqlconnection, "INSERT INTO  `kirschnbot`.`botconfig` (`channel` , `isactive`, `editoroauth`) VALUES ('#".$username."' , NULL, '" . $access_token ."' );");
            header("Location: index.php");
            mysqli_close($sqlconnection);
            die();
        }
    } else {

    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <B>KirschnBot</B>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <a href="<?php echo $twitchtv->authenticate() ?>">Authenticate Me</a>

        <!-- /.social-auth-links -->


    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../../plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
