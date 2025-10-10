<?php
echo "BASE_URL: " . (defined('BASE_URL') ? BASE_URL : 'not defined') . "\n";
echo "PUBLIC_URL: " . (defined('PUBLIC_URL') ? PUBLIC_URL : 'not defined') . "\n";
echo "\n";
echo "CSS URL: " . (defined('PUBLIC_URL') ? PUBLIC_URL : '') . "/css/style.css\n";
echo "JS URL: " . (defined('PUBLIC_URL') ? PUBLIC_URL : '') . "/js/main.js\n";
echo "\n";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "\n";
?>