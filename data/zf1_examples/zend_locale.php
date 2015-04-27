<?php
set_include_path('/usr/local/zend/share/ZendFramework/library');
include 'Zend/Locale.php';
include 'Zend/Date.php';
include 'Zend/Debug.php';
$test = new Zend_Locale('auto');
$date = new Zend_Date($test);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Zend Locale Test</title>
</head>
<body>
<?php 
echo '<br />Time:    ' . $date->getTime() . PHP_EOL;

$en = new Zend_Locale('en_US');
echo '<br />' . $en->toString() . PHP_EOL;
echo '<br />' . Zend_Locale::getTranslation('en', 'language', 'zh') . PHP_EOL; // chinese
echo '<br />' . Zend_Locale::getTranslation('en', 'language', 'th') . PHP_EOL; // thai
echo '<br />' . Zend_Locale::getTranslation('en', 'language', 'fr') . PHP_EOL; // french
echo '<br />' . Zend_Locale::getTranslation('fr', 'language', 'en') . PHP_EOL; // reversed
echo '<br />' . Zend_Locale::getTranslation('US', 'country', 'zh') . PHP_EOL; // chinese
echo '<br />' . Zend_Locale::getTranslation('US', 'country', 'th') . PHP_EOL; // thai
echo '<br />' . Zend_Locale::getTranslation('US', 'country', 'fr') . PHP_EOL; // french
echo '<br />' . Zend_Locale::getTranslation('FR', 'country', 'en') . PHP_EOL; // reversed
print_r($en->getQuestion('zh'));
Zend_Debug::dump(Zend_Locale::getCountryTranslationList(), 'Country Translation List');
Zend_Debug::dump(Zend_Locale::getLocaleList(), 'Locale List');
?>
</body>
</html>
