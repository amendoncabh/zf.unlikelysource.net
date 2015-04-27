<?php
set_include_path('/usr/local/zend/share/ZendFramework/library');
include 'Zend/Locale.php';
include 'Zend/Date.php';
include 'Zend/Debug.php';
$test = new Zend_Locale('fr_FR');
$def = new Zend_Locale('auto');
$date = Zend_Locale_Format::getDate('41.10.20',
								    array('date_format' => 'ddMMyy',
                                          'fix_date' => true)
                                         );
// instead of 41 for the day, the 41 will be returned as year value
Zend_Debug::dump($date);
$date = Zend_Locale_Format::getDate('41.10.20',
								    array('date_format' => Zend_Locale_Format::STANDARD,
                                          'fix_date' => true,
								    	  'locale' => $test)
                                         );
Zend_Debug::dump($date);
// instead of 41 for the day, the 41 will be returned as year value
$date = Zend_Locale_Format::getDate('11.10.09',
								    array('date_format' => Zend_Locale_Format::STANDARD,
                                          'fix_date' => true,
								    	  'locale' => $test)
                                         );
Zend_Debug::dump($date);
$date = Zend_Locale_Format::getDate('11.10.09',
								    array('date_format' => Zend_Locale_Format::STANDARD,
                                          'fix_date' => true,
								    	  'locale' => $def)
                                         );
Zend_Debug::dump($date);

?>
