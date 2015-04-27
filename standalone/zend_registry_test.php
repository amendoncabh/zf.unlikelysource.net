<?php
require 'Zend/Registry.php';
require 'Zend/Debug.php';
$label = "TESTING------------------------";
$value = "9999999999999999999999999999999";
Zend_Registry::set($label, $value);
$r = new Zend_Registry();
$r->new = "TEST";
Zend_Debug::dump($GLOBALS);
?>
