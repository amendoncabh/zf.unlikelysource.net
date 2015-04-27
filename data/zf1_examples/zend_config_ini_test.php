<?php
require_once 'Zend/Config/Ini.php';
$config = new Zend_Config_Ini('/var/www/php_zff/config.ini','staging');
echo "<table width=60%>\n";
$row = '<tr><th width=80 align=right>%s</th><td width=20>&nbsp;</td><td width=100 align=left>%s</td></tr>' . "\n";
printf("$row $row $row",
		"Web Host", $config->webhost,
		"DB Host", $config->database->params->host,
		"DB Name", $config->database->params->dbname);
echo "</table>\n";
?>
