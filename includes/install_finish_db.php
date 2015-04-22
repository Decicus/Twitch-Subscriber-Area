<?php
    $con = mysqli_connect( TSA_DB_HOST, TSA_DB_USER, TSA_DB_PASS, TSA_DB_NAME );
    if( !$con ) {
        echo 'MySQL error - TSA cannot initialize: ' . mysqli_error( $con );
        exit();
    }
    /*try {
        $con = new PDO( 'mysql:host=' . TSA_DB_HOST . ';dbname=' . TSA_DB_NAME, TSA_DB_USER, TSA_DB_PASS, array( PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' ) );
    } catch( PDOException $e ) {
        echo 'MySQL error - TSA cannot initialize: ' . $e->getMessage();
        exit();
    */
    // TODO: Look into fetch mode.
    //$title = $con->query( $con->prepare( "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='title';" ), PDO::FETCH_ASSOC )['meta_value'];
    //$main_text = $con->query( $con->prepare( "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='main_text';" ), PDO::FETCH_ASSOC )['meta_value'];
    $title = mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='title';" ) )['meta_value'];
    $main_text = mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='main_text';" ) )['meta_value'];
    if( !$title || !$main_text ) {
        echo 'MySQL error - TSA cannot initialize: ' . mysqli_error( $con );
        exit();
    }
?>
