<?php
    $installFinished = false;
    $installExists = false;
    $install_dir = './install';
    if( is_dir( $install_dir ) ) {
        if( is_file( $install_dir . '/finished.txt' ) ) {
            $installFinished = true;
            $installExists = true;
        } else {
            header( 'Location: ' . $install_dir );
        }
    } else {
        $installFinished = true;
    }
    require 'includes/main.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Twitch Sub Area - Home</title>
        <?php include 'includes/head.php'; ?>
    </head>
    <body>
        <?php include 'includes/nav.php'; ?>
        <div class="container">
        <div class="page-header"><h1>Twitch Subscriber Area</h1></div>
            <div class="jumbotron">
                <?php
                if( $installFinished ) {
                    if( $installExists ) {
                ?>
                <div class="alert alert-danger">Installation appears to be finished and install directory still exists, please delete this directory.</div>
                <?php
                    } else {
                ?>

                <?php
                    }
                } else {
                ?>
                    <div class="alert alert-danger">Please go through the installation script: <a href="./install">Installation script</a></div>
                <?php
                }
                ?>
            </div>
        </div>
    </body>
</html>
