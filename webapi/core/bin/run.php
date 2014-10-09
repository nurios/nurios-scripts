#!/usr/bin/env php
<?php
require_once 'app/config.php';
$addr = RUNTIME_IP.":".RUNTIME_PORT;
echo "Server running... ".$addr."\n";
system("php -c php.ini -S ".$addr." core/bootstrap.php");
?>
