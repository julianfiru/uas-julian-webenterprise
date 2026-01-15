<?php
$output = shell_exec('php artisan migrate 2>&1');
file_put_contents('migrate_output.txt', $output);
