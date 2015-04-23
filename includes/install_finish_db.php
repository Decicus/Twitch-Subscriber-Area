<?php
    $con = mysqli_connect( TSA_DB_HOST, TSA_DB_USER, TSA_DB_PASS, TSA_DB_NAME );
    if( !$con ) {
        echo 'MySQL error - TSA cannot initialize: ' . mysqli_error( $con );
        exit();
    }
    $fetchTitle = mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='title';" ) );
    $title = $fetchTitle['meta_value'];
    $fetchMainText = mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='main_text';" ) );
    $main_text = $fetchMainText['meta_value'];
    if( !$title || !$main_text ) {
        echo 'MySQL error - TSA cannot initialize: ' . mysqli_error( $con );
        exit();
    }
?>
