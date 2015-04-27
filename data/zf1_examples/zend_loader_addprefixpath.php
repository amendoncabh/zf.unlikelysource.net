<?php
require 'Zend/Loader/PluginLoader.php';
$loader = new Zend_Loader_PluginLoader();
// try switching the last two paths and observe the results
$loader->addPrefixPath('Zend_View_Helper',	'Zend/View/Helper')
	   ->addPrefixPath('Bar_View_Helper',	'Bar/views/helpers')
	   ->addPrefixPath('Foo_View_Helper',	'Foo/views/helpers');
	   
// Produces Foo_View_Helper_HeadTitle
$headTitleClass = $loader->load('HeadTitle');
$test = new $headTitleClass;
// echoes "<title>FOO Test</title>"
echo $test->headTitle('Test');
?>