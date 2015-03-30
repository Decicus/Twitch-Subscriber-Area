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
    $page = 'editor';
    // if( !isset( $_SESSION['isMod'] ) || $_SESSION['isMod'] == 0 ) { header( 'Location: ' . TSA_REDIRECTURL ); }
    
    if( $installFinished && !$installExists ) {
        $con = mysqli_connect( TSA_DB_HOST, TSA_DB_USER, TSA_DB_PASS, TSA_DB_NAME );
        $title = mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='title';" ) )['meta_value'];
        $main_text = mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='main_text';" ) )['meta_value'];
        // Verify the user is a moderator/admin.
        $getMods = json_decode( mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='moderators';" ) )['meta_value'] );
        $getAdmins = json_decode( mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='admins';" ) )['meta_value'] );
        if( !in_array( $_SESSION['user_id'], $getAdmins ) && !in_array( $_SESSION['user_id'], $getMods ) ) {
            $_SESSION['isMod'] = 0;
            header( 'Location: ' . TSA_REDIRECTURL ); // Redirect back to homepage, because at this point they should not have access.
        }
    } else {
        $title = 'Twitch Subscriber Area';
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?> - Editor</title>
        <?php include 'includes/head.php'; ?>
    </head>
    <body>
        <?php include 'includes/nav.php'; ?>
        <div class="container">
        <div class="page-header"><h1><?php echo $title; ?> - Editor</h1></div>
            <div class="jumbotron">
                <p class="text text-info">This is the editor panel of <?php echo $title; ?>. The posts shown on the homepage can be edited here by moderators or admins.</p>
                <?php
                    if( isset( $_GET['edit'] ) ) {
                        
                    } elseif( isset( $_GET['delete'] ) ) {
                        
                    } else {
                        $allPosts = mysqli_query( $con, "SELECT id, title, body FROM " . TSA_DB_PREFIX . "posts;" );
                        while( $row = mysqli_fetch_array( $allPosts ) ) {
                            $postID = $row['id'];
                            $postTitle = $row['title'];
                            $postBody = $row['body'];
                            ?>
                            <div class="panel panel-primary">
                                <div class="panel-heading"><h3 class="panel-title"><?php echo $postTitle; ?></h3></div>
                                <div class="panel-body"><?php echo $postBody; ?></div>
                                <div class="panel-footer">
                                    <a href="<?php echo TSA_REDIRECTURL; ?>/editor.php?edit=<?php echo $postID; ?>" class="btn btn-warning">Edit</a>
                                    <a href="<?php echo TSA_REDIRECTURL; ?>/editor.php?delete=<?php echo $postID; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    mysqli_close( $con );
                ?>
                <a href="<?php echo TSA_REDIRECTURL; ?>/?logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </body>
</html>