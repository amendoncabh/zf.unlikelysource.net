<?php
require "Zend/Log.php";
require "Zend/Log/Writer/Stream.php";
require "Zend/Log/Formatter/Xml.php";
$logger = new Zend_Log();
$writer = new Zend_Log_Writer_Stream('php://output');
$formatter = new Zend_Log_Formatter_Xml();
$writer->setFormatter($formatter);
$logger->addWriter($writer);
$logger->log("*****XML TEST MESSAGE*****",Zend_Log::INFO);
?>