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
    $page = 'index';
    
    if( $installFinished && !$installExists ) {
        $con = mysqli_connect( TSA_DB_HOST, TSA_DB_USER, TSA_DB_PASS, TSA_DB_NAME );
        $title = mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='title';" ) )['meta_value'];
        $main_text = mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='main_text';" ) )['meta_value'];
        if( isset( $_GET['logout'] ) ) {
            session_destroy();
            header( 'Location: ' . TSA_REDIRECTURL );
        }
    } else {
        $title = 'Twitch Subscriber Area';
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?> - Home</title>
        <?php include 'includes/head.php'; ?>
    </head>
    <body>
        <?php include 'includes/nav.php'; ?>
        <div class="container">

                <?php
                if( $installFinished ) {
                    if( $installExists ) {
                ?>
                <div class="alert alert-danger">Installation appears to be finished and install directory still exists, please delete this directory.</div>
                <?php
                    } else {
                    $Twitch = new Decicus\Twitch( TSA_APIKEY, TSA_APISECRET, TSA_REDIRECTURL );
                    $authenticateURL = $Twitch->authenticateURL( [ 'user_read', 'user_subscriptions' ] );
                ?>
                    <div class="page-header"><h1><?php echo $title; ?></h1></div>
                    <div class="jumbotron">
                        <p class="text text-info"><?php echo nl2br( $main_text ); ?></p>
                        <?php
                            if( isset( $_SESSION['access_token'] ) ) {
                                $at = $_SESSION['access_token'];
                                $username = $_SESSION['username'];
                                $displayName = $_SESSION['display_name'];
                                $userID = $_SESSION['user_id'];
                                ?>
                                <div class="alert alert-success">Welcome <span class="bold"><?php echo $displayName; ?></span>. You are successfully logged in and fully authenticated.</div>
                                <?php
                                $getAdmins = json_decode( mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='admins';" ) )['meta_value'] );
                                if( in_array( $userID, $getAdmins ) ) {
                                    $isAdmin = true;
                                } else {
                                    $isAdmin = false;
                                }
                                $inEditor = false;
                                $getSubStreams = json_decode( mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='subscriber_streams';" ) )['meta_value'] );
                                if( !empty( $getSubStreams ) || $isAdmin ) {
                                    if( $isAdmin ) {
                                        ?>
                                        <div class="alert alert-info">You are an <span class="bold">admin</span>. This means you can edit site settings and posts displayed on this page.</div>
                                        <?php
                                        if( empty( $getSubStreams ) ) {
                                            // TODO: Actually setup the damn admin page.
                                            ?>
                                            <div class="alert alert-danger">There are no streamers with the subscription program stored in the database. Please add this via the <a href="<?php echo TSA_REDIRECTURL; ?>/admin.php" class="alert-link">admin page</a>.</div>
                                            <?php
                                        }
                                    }
                                    $fetchPosts = mysqli_query( $con, "SELECT id, title, body FROM " . TSA_DB_PREFIX . "posts;" );
                                    while( !$inEditor && $row = mysqli_fetch_array( $fetchPosts ) ) {
                                        $postID = $row['id'];
                                        $postTitle = $row['title'];
                                        $postText = nl2br( $row['body'] );
                                        ?>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading"><?php echo $postTitle; ?></div>
                                            <div class="panel-body"><?php echo $postText; ?></div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="alert alert-danger">This website currently does not contain any streamers with a subscription program. Please contact the owners to fix this issue.</div>
                                    <?php
                                }
                                ?>
                                <a href="<?php echo TSA_REDIRECTURL; ?>/?logout" class="btn btn-danger">Logout</a>
                                <?php
                            } elseif( isset( $_GET['code'] ) ) {
                                $code = $_GET['code'];
                                $at = $Twitch->getAccessToken( $code );
                                $username = $Twitch->getName( $at );
                                $displayName = $Twitch->getDisplayName( $at );
                                $userID = $Twitch->getUserIDFromAT( $at );
                                if( $at && $username && $displayName && $userID ) {
                                    $_SESSION['access_token'] = $at;
                                    $_SESSION['username'] = $username;
                                    $_SESSION['display_name'] = $displayName;
                                    $_SESSION['user_id'] = $userID;
                                    header( 'Location: ' . TSA_REDIRECTURL );
                                } else {
                                    ?>
                                    <div class="alert alert-danger">Invalid authorization code. Please <a href="<?php echo $authenticateURL; ?>" class="alert-link">re-authenticate</a>.</div>
                                    <?php
                                }
                            } else {
                                ?>
                                <a href="<?php echo $authenticateURL ?>"><img src="images/twitch_connect.png" alt="Connect with Twitch" /></a>
                                <?php
                            }
                        ?>
                    </div>
                <?php
                    mysqli_close( $con );
                    }
                } else {
                ?>
                    <div class="alert alert-danger">Please go through the installation script: <a href="./install">Installation script</a></div>
                <?php
                }
                ?>
        </div>
    </body>
</html>
