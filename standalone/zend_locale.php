<?php
include 'Zend/Locale.php';
include 'Zend/Date.php';
include 'Zend/Debug.php';
$test = new Zend_Locale();
echo $test->toString();