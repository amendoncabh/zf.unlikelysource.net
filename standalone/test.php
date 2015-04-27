

	<?php 
	require_once 'Zend/Config/Ini.php';
	$config = new Zend_Config_Ini('/path/to/config.ini', 'staging');
	echo $config->database->adapter;			// prints 'pdo_mysql'
	echo $config->database->params->host;		// prints 'dev.example.com'
	?>