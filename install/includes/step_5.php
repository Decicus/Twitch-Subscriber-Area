<h2>Installation - Step #5</h2>
<?php
    if( isset( $_POST['admin_username'] ) ) {
        $config = implode( DIRECTORY_SEPARATOR, array( '..', 'includes', 'config.php' ) );
        if( file_exists( $config ) && is_readable( $config ) ) {
            require $config;
            require implode( DIRECTORY_SEPARATOR, array( '..', 'includes', 'Twitch.php' ) );
            $twitch = new Decicus\Twitch( TSA_APIKEY, TSA_APISECRET, TSA_REDIRECTURL );
            $userID = $twitch->getUserID( $_POST['admin_username'] );
            if( $userID ) {
                $con = mysqli_connect( TSA_DB_HOST, TSA_DB_USER, TSA_DB_PASS, TSA_DB_NAME );
                $admin = json_encode( [ $userID ] );
                $query = "INSERT INTO " . TSA_DB_PREFIX . "settings( meta_key, meta_value ) VALUES( 'admins', '$admin' );"; // Setup admin array
                $query .= "INSERT INTO " . TSA_DB_PREFIX . "settings( meta_key, meta_value ) VALUES( 'moderators', '[]' );"; // Empty array for moderators (placeholder).
                $query .= "INSERT INTO " . TSA_DB_PREFIX . "settings( meta_key, meta_value ) VALUES( 'title', 'Twitch Subscriber Area' );"; // Default title
                $query .= "INSERT INTO " . TSA_DB_PREFIX . "settings( meta_key, meta_value ) VALUES( 'main_text', 'Welcome to Twitch Subscriber Area.\nIf you\'re admin, you can modify this text in the admin settings.' );"; // Default description
                $query .= "INSERT INTO " . TSA_DB_PREFIX . "settings( meta_key, meta_value ) VALUES( 'subscriber_streams', '[]' );"; // Empty array for partnered subscriber streams.
                $query .= "INSERT INTO " . TSA_DB_PREFIX . "posts( title, body ) VALUES( 'Post example #1', 'This is a sample post, which will be displayed for subscribed users.\nYou can create more of these or edit/delete this one as an admin or moderator in the page editor.' );"; // Sample post
                if( mysqli_multi_query( $con, $query ) ) {
                    // Ghetto way of verifying installation...
                    $finish = fopen( '.' . DIRECTORY_SEPARATOR . 'finished.txt', 'w' );
                    fwrite( $finish, 'yep.', strlen( 'yep.' ) );
                    fclose( $finish );
                    ?>
                    <div class="alert alert-success">Admin status granted.</div>
                    <p text="text text-success">Clicking the button below will redirect you to the homepage. Please delete the "install" folder from the directory.</p>
                    <a href="/" class="btn btn-success">Finish installation and redirect to homepage.</a>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-danger"><?php echo mysqli_error( $con ); ?></div>
                    <?php
                }
                mysqli_close( $con );
            } else {
                ?>
                <div class="alert alert-danger">Error retrieving user (user most likely doesn't exist).</div>
                <?php
            }
        } else {
            ?>
            <div class="alert alert-danger">Configuration either doesn't exist or can't be read.</div>
            <?php
        }
    } else {
        ?>
        <div class="alert alert-danger">Missing parameter: Twitch admin username.</div>
        <?php
    }
?>
