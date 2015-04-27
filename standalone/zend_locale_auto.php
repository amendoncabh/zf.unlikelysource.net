<?php
require_once 'Zend/Locale.php';
require_once 'Zend/Date.php';

// with automatic detection
$date = new Zend_Date('auto');
echo "\n$date\n";
$locale = new Zend_Locale('auto');
echo "<pre>\n";
print_r($locale->getQuestion());
echo "</pre>\n";
?>