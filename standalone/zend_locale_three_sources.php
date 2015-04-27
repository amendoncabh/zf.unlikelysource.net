<?php
set_include_path('/usr/local/zend/share/ZendFramework/library');
include 'Zend/Locale.php';
include 'Zend/Debug.php';
include 'Zend/Date.php';
// with automatic detection
$date = new Zend_Date('auto');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Zend Locale Test</title>
</head>
<body>
<p>Date Using Auto Locale Detection: <?php echo "\n$date\n"; ?>
</p>
<?php 
Zend_Debug::dump(Zend_Locale::getBrowser(),    'Browser---------------');
Zend_Debug::dump(Zend_Locale::getEnvironment(),'Environment-----------');
Zend_Debug::dump(Zend_Locale::getDefault(),    'ZF Default------------');
?>
</body>
</html>
