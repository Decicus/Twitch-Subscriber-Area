<?php
$installFinished = false;
$installExists = false;
if( defined( 'TSA_DB_HOST' ) ) {
    $installFinished = true;
    $installExists = true;
} else {
    header( 'Location: ./install' );
}
?>
