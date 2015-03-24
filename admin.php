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
    $page = 'admin';
    if( !isset( $_SESSION['isAdmin'] ) || $_SESSION['isAdmin'] == 0 ) { header( 'Location: ' . TSA_REDIRECTURL ); }
    
    if( $installFinished && !$installExists ) {
        $con = mysqli_connect( TSA_DB_HOST, TSA_DB_USER, TSA_DB_PASS, TSA_DB_NAME );
        $title = mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='title';" ) )['meta_value'];
        $main_text = mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='main_text';" ) )['meta_value'];
        // Verify the user is admin.
        $getAdmins = json_decode( mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='admins';" ) )['meta_value'] );
        if( !in_array( $_SESSION['user_id'], $getAdmins ) ) {
            $_SESSION['isAdmin'] = 0;
            header( 'Location: ' . TSA_REDIRECTURL ); // Redirect back to homepage, because at this point they should not have access.
        }
    } else {
        $title = 'Twitch Subscriber Area';
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?> - Admin</title>
        <?php include 'includes/head.php'; ?>
    </head>
    <body>
        <?php include 'includes/nav.php'; ?>
        <div class="page-header"><h1><?php echo $title; ?> - Admin</h1></div>
        <div class="container">
            <div class="jumbotron">
                <p class="text text-info">Welcome to the admin settings of <?php echo $title; ?>. Here you will be able to access page settings.</p>
                <?php
                    $pages = [
                        'admins' => 'Modify site administrators (full access users).',
                        'moderators' => 'Modify site moderators (only access to add, edit or delete posts).',
                        'title' => 'Change the title of this website',
                        'description' => 'Modify the homepage description'
                    ];
                ?>
                <a href="<?php echo TSA_REDIRECTURL; ?>/?logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </body>
</html>