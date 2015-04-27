<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Zend_Locale Translate</title>
</head>
<body>
<?php
//require_once 'Zend/Debug/Dump.php';
require_once 'Zend/Locale.php';

$sourceLanguage = 'fr_CH'; // set to your native language code
$locale = new Zend_Locale($sourceLanguage);
echo "\n<table>\n";
echo '<tr><td colspan=2><h3>Translation of Language Name</h3></td></tr>';
echo '<tr><th>English in Chinese</th><td>' 	. Zend_Locale::getTranslation('en', 'language', 'zh') . PHP_EOL; // chinese
echo '<tr><th>English in Thai</th><td>' 	. Zend_Locale::getTranslation('en', 'language', 'th') . '</td></tr>' . PHP_EOL; // thai
echo '<tr><th>English in French</th><td>' 	. Zend_Locale::getTranslation('en', 'language', 'fr') . '</td></tr>' . PHP_EOL; // french
echo '<tr><th>French in English</th><td>' 	. Zend_Locale::getTranslation('fr', 'language', 'en') . '</td></tr>' . PHP_EOL; // reversed
echo '<tr><td colspan=2><h3>Translation of Country Name</h3></td></tr>';
echo '<tr><th>Australia in Chinese</th><td>' . Zend_Locale::getTranslation('AU', 'country', 'zh') . '</td></tr>' . PHP_EOL; // chinese
echo '<tr><th>Australia in Thai</th><td>' 	 . Zend_Locale::getTranslation('AU', 'country', 'th') . '</td></tr>' . PHP_EOL; // thai
echo '<tr><th>Australia in French</th><td>'  . Zend_Locale::getTranslation('AU', 'country', 'fr') . '</td></tr>' . PHP_EOL; // french
echo '<tr><th>France in English</th><td>' 	 . Zend_Locale::getTranslation('FR', 'country', 'en') . '</td></tr>' . PHP_EOL; // reversed
// NOTE: this was used in 1.5 but is now deprecated: 
//$list = $locale->getLanguageTranslationList();
$list = $locale->getTranslationList('language');

// Prints a list of languages, each in their native language
// Prints 'yes' and 'no' in different languages
echo '<tr><td colspan=2><h3>Translation of Languages and Yes/No</h3></td></tr>';
foreach($list as $language => $content) {
    try {
        $lang = $locale->getTranslation($language, 'language', $language);
        if (is_string($lang)) {
            print "<tr><td>[" . $language ."] " . $lang . "</td>";
	        $yesNo = $locale->getQuestion($language);
	        if (is_array($yesNo)) {
	            printf("<td>%s</td><td>%s</td></tr>\n", $yesNo['yes'], $yesNo['no']); 
	        }
        }
    } catch (Exception $e) {
        continue;
    }
}
echo "</table>\n";
//$days = $locale->getTranslationList('days');
var_dump(Zend_Locale::getTranslation(1, 'month', 'th'));
//Zend_Debug::dump($days);
?>

</body>
</html>
