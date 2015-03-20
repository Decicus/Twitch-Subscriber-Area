<!DOCTYPE html>
<html>
    <head>
        <title>Twitch Sub Area - Install</title>
        <?php include '../includes/head.php'; ?>
    </head>
    <body>
        <div class="container">
            <div class="page-header"><h1>Twitch Sub Area - Install</h1></div>
            <div class="jumbotron">
                <?php
                    error_reporting( E_ALL );
                    session_start();

                    $_SESSION['step'] = 1;
                    if( isset( $_POST['db_username'] ) ) {
                        $_SESSION['step'] = 3;
                    } elseif( isset( $_POST['admin_username'] ) ) {
                        $_SESSION['step'] = 5;
                    }

                    if( isset( $_GET['step'] ) && intval( $_GET['step'] ) > 0 && intval( $_GET['step'] ) <= 5 ) {
                        $_SESSION['step'] = intval( $_GET['step'] );
                        $step = $_SESSION['step'];
                    }

                    if( $_SESSION['step'] > 1 ) {
                        $step = $_SESSION['step'];
                        include 'includes/step_' . $step . '.php';
                    } else {
                        include 'includes/step_1.php';
                    }
                ?>
            </div>
        </div>
    </body>
</html>
