<?php
require "Zend/Log.php";
require "Zend/Log/Writer/Stream.php";
$logger = new Zend_Log();
$writer = new Zend_Log_Writer_Stream('php://output');
$logger->addWriter($writer);
$logger->log("*****TEST MESSAGE*****",Zend_Log::INFO);
?>