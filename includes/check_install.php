<?php
$installFinished = false;
$installExists = false;
if( defined( 'TSA_DB_HOST' ) ) {
    $installFinished = true;
    if( is_dir( 'install' ) ) {
        $installExists = true;
    }
} else {
    header( 'Location: ./install' );
}
?>
