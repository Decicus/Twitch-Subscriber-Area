<?php
$installFinished = false;
$installExists = false;
if( is_dir( 'includes' ) ) {
    if( is_file( implode( DIRECTORY_SEPARATOR, array( 'includes', 'config.php' ) ) ) ) {
        $installFinished = true;
        $installExists = true;
    } else {
        header( 'Location: ./install' );
    }
} else {
    $installFinished = true;
}
?>
