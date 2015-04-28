<?php
    $checkWhitelist = mysqli_query( $con, "SHOW TABLES LIKE " . TSA_DB_PREFIX . "whitelist;" );
    if( mysqli_num_rows( $checkWhitelist ) == 0 ) {
        $createWhitelist = mysqli_query( $con, "CREATE TABLE " . TSA_DB_PREFIX . "whitelist( id int NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), name varchar(25), uid int UNIQUE );" );
    }
    $fetchWhitelist = mysqli_fetch_array( mysqli_query( $con, "SELECT name,uid FROM " . TSA_DB_PREFIX . "whitelist;" ) );
?>
<div class="panel panel-success">
    <div class="panel-heading">Add whitelisted user</div>
    <div class="panel-body">
        <form method="post" action="admin.php?page=whitelist">
            <div class="form-group">
                <label for="addWhitelist">Twitch username:</label>
                <input type="text" name="addWhitelist" id="addWhitelist" class="form-control" />
            </div>
            <button type="submit" class="btn btn-success">Add to whitelist</button>
        </form>
    </div>
</div>

<div class="panel panel-danger">
    <div class="panel-heading">Remove whitelisted user</div>
    <div class="panel-body">
        <form method="post" action="admin.php?page=whitelist">
            <div class="form-group">
                <label for="delWhitelist">Twitch username:</label>
                <select name="delWhitelist" id="delWhitelist" class="form-control">
                    <option>Select user</option>
                    <?php
                        while( $row = mysqli_fetch_array( $fetchWhitelist ) ) {
                            ?>
                            <option value="<?php echo $row['uid']; ?>"><?php echo $row['name']; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </form>
        <button type="submit" class="btn btn-danger" onclick='confirm( "Are you sure you want to remove this user from the whitelist?" );' )>Remove from whitelist</button>
    </div>
</div>
