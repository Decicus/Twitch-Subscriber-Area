<?php
    $installFinished = false;
    $installExists = false;
    $install_dir = './install';
    error_reporting( 0 );
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
        require 'includes' . DIRECTORY_SEPARATOR . 'install_finish_db.php';
        if( isset( $_GET['logout'] ) ) {
            session_destroy();
            header( 'Location: ' . TSA_REDIRECTURL );
        }
    } else {
        $title = 'Twitch Subscriber Area';
    }
    
    if( isset( $_SESSION['access_token'] ) ) {
        $at = $_SESSION['access_token'];
        $username = $_SESSION['username'];
        $displayName = $_SESSION['display_name'];
        $userID = $_SESSION['user_id'];
        $getAdmins = json_decode( mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='admins' LIMIT 1;" ) )['meta_value'], true );
        $getMods = json_decode( mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='moderators' LIMIT 1;" ) )['meta_value'], true );

        if( isset( $getAdmins[ $userID ] ) ) {
            $_SESSION['isAdmin'] = 1;
            $_SESSION['isMod'] = 1; // Admins are automatically "moderators" too.
            $isMod = true;
            $isAdmin = true;
        } elseif( isset( $getMods[ $userID ] ) ) {
            $_SESSION['isAdmin'] = 0;
            $_SESSION['isMod'] = 1;
            $isMod = true;
            $isAdmin = false;
        } else {
            $_SESSION['isAdmin'] = 0;
            $isAdmin = false;
            if( in_array( $userID, $getMods ) ) {
                $_SESSION['isMod'] = 1;
                $isMod = true;
            } else {
                $_SESSION['isMod'] = 0;
                $isMod = false;
            }
        }
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
                <div class="alert alert-danger">Installation appears to be finished and install directory still exists, please delete this directory (preferred) or rename it.</div>
                <?php
                    } else {
                    $Twitch = new Decicus\Twitch( TSA_APIKEY, TSA_APISECRET, TSA_REDIRECTURL );
                    $authenticateURL = $Twitch->authenticateURL( [ 'user_read', 'user_subscriptions' ] );
                ?>
                    <div class="page-header"><h1><?php echo $title; ?> - Home</h1></div>
                    <div class="jumbotron">
                        <p class="text text-info"><?php echo nl2br( $main_text ); ?></p>
                        <?php
                            if( isset( $_SESSION['access_token'] ) ) {
                                ?>
                                <div class="alert alert-success">Welcome <span class="bold"><?php echo $displayName; ?></span>. You are successfully logged in and fully authenticated.</div>
                                <?php
                                $getSubStreams = json_decode( mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='subscriber_streams';" ) )['meta_value'], true );
                                if( !empty( $getSubStreams ) || $isAdmin || $isMod ) {
                                    $streamCount = count( $getSubStreams );
                                    if( $isAdmin ) {
                                        ?>
                                        <div class="alert alert-info">You are an <span class="bold">admin</span>. This means you can edit site settings and modify posts displayed on this page via the <a href="<?php echo TSA_REDIRECTURL; ?>/admin.php" class="alert-link">admin page</a> and the <a href="<?php echo TSA_REDIRECTURL; ?>/editor.php" class="alert-link">page editor</a>.</div>
                                        <?php
                                        if( empty( $getSubStreams ) ) {
                                            ?>
                                            <div class="alert alert-danger">There are no streamers with the subscription program stored in the database. Please add this via the <a href="<?php echo TSA_REDIRECTURL; ?>/admin.php" class="alert-link">admin page</a>.</div>
                                            <?php
                                        }
                                    } elseif( $isMod ) {
                                        ?>
                                        <div class="alert alert-info">You are a <span class="bold">moderator</span>. This means you can modify site posts displayed on this page via the <a href="<?php echo TSA_REDIRECTURL; ?>/editor.php" class="alert-link">editor</a>.</div>
                                        <?php
                                    }
                                    $isSubbed = false;
                                    $atError = NULL;
                                    foreach( $getSubStreams as $UID => $info ) {
                                        $name = $info[ 'name' ];
                                        if( $Twitch->isSubscribed( $at, $username, $name ) == 100 ) {
                                            $isSubbed = true;
                                            break;
                                        } elseif( $Twitch->isSubscribed( $at, $username, $name ) == 401 ) {
                                            $atError = '<div class="alert alert-danger">There was an error retrieving subscriber status, please <a href="' . TSA_REDIRECTURL . '/?logout" class="alert-link">logout</a> and connect with Twitch again.</div>';
                                        }
                                    }

                                    if( $isSubbed || $isMod ) {
                                        $firstStreamer = $getSubStreams[ array_keys( $getSubStreams )[ 0 ] ][ 'name' ];
                                        if( $isSubbed ) {
                                            ?>
                                            <div class="alert alert-success">You are subscribed to <?php echo ( $streamCount == 1 ? $firstStreamer : 'one or more streamers in the list' ); ?> and will now have access to the subscriber posts.</div>
                                            <?php
                                        }
                                        $fetchPosts = mysqli_query( $con, "SELECT id, title, body FROM " . TSA_DB_PREFIX . "posts;" );
                                        $hasPosts = false;
                                        while( $row = mysqli_fetch_array( $fetchPosts ) ) {
                                            $hasPosts = true;
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
                                        if( !$hasPosts ) {
                                            ?>
                                            <div class="alert alert-warning">There are no posts :(</div>
                                            <?php
                                        }
                                    } else {
                                        if( $atError ) {
                                            echo $atError;
                                        } else {
                                            $noSubMessage = [];
                                            if( $streamCount == 1 ) {
                                                $noSubMessage['u'] = $firstStreamer;
                                                $noSubMessage['msg'] = '.';
                                            } else {
                                                $noSubMessage['u'] = 'any of the streamers in the list';
                                                $noSubMessage['msg'] = ' to at least one of them.';
                                            }
                                            ?>
                                            <div class="alert alert-warning">You are not subscribed to <?php echo $noSubMessage['u']; ?> and will not get access unless you subscribe<?php echo $noSubMessage['msg']; ?></div>
                                            <div class="list-group">
                                            <?php
                                            foreach( $getSubStreams as $UID => $info ) {
                                                $name = $info[ 'name' ];
                                                ?>
                                                <a href="http://www.twitch.tv/<?php echo $name; ?>" class="list-group-item list-group-item-success">Subscribe to <?php echo $Twitch->getDisplayNameNoAT( $name ); ?></a>
                                                <?php
                                            }
                                            ?>
                                            </div>
                                            <?php
                                        }
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
