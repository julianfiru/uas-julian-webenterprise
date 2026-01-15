<?php
$output = shell_exec('php artisan test tests/Feature/OAuthCheckTest.php 2>&1');
file_put_contents('test_output.txt', $output);
