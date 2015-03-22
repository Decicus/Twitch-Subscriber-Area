<h2>Installation - Step #1</h2>
<p class="text text-warning">NOTE: This install script requires a few things before we start. These requirements are listed below.</p>
<ul class="list-group">
    <li class="list-group-item list-group-item-<?php echo ( PHP_VERSION >= 5.5 ? 'success' : 'danger' ); ?>">PHP 5.5+ &mdash; You have: <strong>PHP <?php echo PHP_VERSION; ?></strong></li>
    <li class="list-group-item list-group-item-<?php echo ( function_exists( 'curl_version' ) ? 'success' : 'danger' ); ?>">cURL extension for PHP &mdash; <strong><?php echo ( function_exists( 'curl_version' ) ? 'Enabled' : 'Disabled' ); ?></strong></li>
    <li class="list-group-item list-group-item-<?php echo ( function_exists( 'mysqli_connect' ) ? 'success' : 'danger' ); ?>">A MySQL database with PHP extension "MySQLi" enabled &mdash; <strong><?php echo ( function_exists( 'mysqli_connect' ) ? 'Enabled' : 'Disabled' ); ?></strong></li>
    <li class="list-group-item list-group-item-success">Twitch API developer application information as described on the main install page.</li>
</ul>

<p class="text text-default">Hopefully all of the things listed above are available (green) on your server. If not, please contact your website host.</p>
<form method="get" action="install.php"><input type="hidden" name="step" value="2" /><button class="btn btn-success">Continue to step #2</button></form>
