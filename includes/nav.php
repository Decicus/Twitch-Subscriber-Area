<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a href="<?php echo TSA_REDIRECTURL; ?>" class="navbar-brand"><?php echo $title; ?></a>
        </div>

        <ul class="nav navbar-nav">
            <li <?php echo ( $page == 'index' ? 'class="active"' : '' ); ?>><a href="<?php echo TSA_REDIRECTURL; ?>">Home</a></li>
            <?php
                if( isset( $_SESSION['isMod'] ) && $_SESSION['isMod'] == 1 ) {
                    ?>
                    <li <?php echo ( $page == 'editor' ? 'class="active"' : '' ); ?>><a href="<?php echo TSA_REDIRECTURL; ?>/editor.php">Editor</a></li>
                    <?php
                }
                if( isset( $_SESSION['isAdmin'] ) && $_SESSION['isAdmin'] == 1 ) {
                    ?>
                    <li <?php echo ( $page == 'admin' ? 'class="active"' : '' ); ?>><a href="<?php echo TSA_REDIRECTURL; ?>/admin.php">Admin</a></li>
                    <?php
                }
            ?>
        </ul>
    </div>
</nav>
