<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a href="<?php echo TSA_REDIRECTURL; ?>" class="navbar-brand"><?php echo $title; ?></a>
        </div>
        
        <ul class="nav navbar-nav">
            <li <?php echo ( $page == 'index' ? 'class="active"' : '' ); ?>><a href="<?php echo TSA_REDIRECTURL; ?>">Home</a></li>
        </ul>
    </div>
</nav>