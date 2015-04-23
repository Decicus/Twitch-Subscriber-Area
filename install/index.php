<?php
    if( is_file( './finished.txt' ) ) { header( 'Location: ../' ); }
    $TSAURL = ( isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . str_replace(  [ basename( __FILE__ ), 'install/' ], '', $_SERVER['REQUEST_URI'] );
    $TSAURL = ( strpos( $TSAURL, '/', strlen( $TSAURL ) - 1 ) ? substr( $TSAURL, 0, -1 ) : $TSAURL ); // Remove '/' at the end of a URL.
    session_start();
    $_SESSION['TSAURL'] = $TSAURL;
?>
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
                <h2>Hello and welcome!</h2>
                <p class="text text-default">This is the install script for the Twitch Subscriber Area.</p>
                <p class="text text-default">The main point of this project is to be able to setup a simple, yet powerful subscriber area for one or more partnered streamers with a "Subscribe" button.<br />
                If you have not seen a subscriber area before, the idea behind it is pretty simple.<br />
                It's a "locked" area that is only available if a user is verified to be a Twitch subscriber of a streamer.<br /></p>

                <p class="text text-warning">If you have not created a developer application in the Twitch API, please do so on this page: <a href="http://www.twitch.tv/settings/connections" target="_blank">http://www.twitch.tv/settings/connections</a>. <br />
                Keep in mind, the redirect URL needs to match the full URL of TSA (Twitch Subscriber Area) in both step #2 and the developer application settings.<br />
                In this case, it should be: <strong><?php echo $TSAURL; ?></strong> (this should not contain a "/" at the end).</p>
                <p class="text text-default">As stated earlier, this can be one or more partnered streamers. The install script should guide you properly, if multiple streamers are preferred.</p>

                <a href="install.php" class="btn btn-success">Let's go!</a>
            </div>
        </div>
    </body>
</html>
