<?php
    $pageDescription = mysqli_fetch_array( mysqli_query( $con, "SELECT meta_value FROM " . TSA_DB_PREFIX . "settings WHERE meta_key='main_text' LIMIT 1;" ) )['meta_value'];
    if( !empty( $_POST['pageDesc'] ) ) {
        $newPageDesc = mysqli_real_escape_string( $con, $_POST['pageDesc'] );
        $newPageDescQuery = "UPDATE " . TSA_DB_PREFIX . "settings SET meta_value='" . $newPageDesc . "' WHERE meta_key='main_text';";
        if( !mysqli_query( $con, $newPageDescQuery ) ) {
            ?>
            <div class="alert alert-danger">MySQL error: <?php echo mysqli_error( $con ); ?></div>
            <?php
        } else {
            ?>
            <div class="alert alert-success">Success! Website description has been updated. You can find it on the <a href="<?php echo TSA_REDIRECTURL; ?>" class="alert-link">homepage</a>.</div>
            <?php
        }
        $pageDescription = $_POST['pageDesc'];
    }
?>
<div class="panel panel-primary">
    <div class="panel-heading">Update website description:</div>
    <div class="panel-body">
        <form method="post" action="admin.php?page=description">
            <div class="form-group">
                <label for="pageDesc">Website description:</label>
                <textarea rows="5" class="form-control" name="pageDesc" id="pageDesc"><?php echo $pageDescription; ?></textarea>
            </div>
            <button type="submit" class="btn btn-success">Update description</button>
        </form>
    </div>
</div>
