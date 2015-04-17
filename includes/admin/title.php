<?php
    if( !empty( $_POST['pageTitle'] ) ) {
        $newTitle = mysqli_real_escape_string( $con, $_POST['pageTitle'] );
        $newTitleQuery = "UPDATE " . TSA_DB_PREFIX . "settings SET meta_value='" . $newTitle . "' WHERE meta_key='title';";
        if( !mysqli_query( $con, $newTitleQuery ) ) {
            ?>
            <div class="alert alert-danger">MySQL error: <?php echo mysqli_error( $con ); ?></div>
            <?php
        } else {
            ?>
            <div class="alert alert-success">Success! Title has been updated to <strong><?php echo $_POST['pageTitle']; ?></strong>. Changes will take effect when you visit a new page.</div>
            <?php
        }
    }
?>
<div class="panel panel-primary">
    <div class="panel-heading">Update website title:</div>
    <div class="panel-body">
        <form method="post" action="admin.php?page=title">
            <div class="form-group">
                <label for="pageTitle">Website title:</label>
                <input type="text" value="<?php echo $title; ?>" name="pageTitle" id="pageTitle" class="form-control" />
            </div>
            <button type="submit" class="btn btn-success">Update title</button>
        </form>
    </div>
</div>
