<?php
require 'Zend/Form.php';
require 'Zend/Form/Element/Text.php';
require 'Zend/Filter/StringTrim.php';
require 'Zend/Filter/StringToLower.php';

$form = new Zend_Form('test');
$input = new Zend_Form_Element_Text('name');
$input->setFilters(array('StringToLower'));
$form->addElement($input);
if ($form->isValid(array('name' => ' TEST '))) {
	echo 'String to Lower Filter in Effect' . PHP_EOL;
	echo 'Valid Name: ' 
		 . $form->getValue('name') 
		 . ' (' . strlen($form->getValue('name')) . ')';
} else {
	echo 'Form Not Valid';
}
echo PHP_EOL;
echo PHP_EOL;
$form->setElementFilters(array(new Zend_Filter_StringTrim()));
if ($form->isValid(array('name' => ' TEST '))) {
	echo 'String Trim in Effect' . PHP_EOL;
	echo 'String to Lower Filter Disabled' . PHP_EOL;
	echo 'Valid Name: ' 
	 	 . $form->getValue('name') 
	 	 . ' (' . strlen($form->getValue('name')) . ')';
} else {
	echo 'Form Not Valid';
}
echo PHP_EOL;
echo PHP_EOL;
echo 'Unfiltered Value: ' 
	 . $form->getUnfilteredValue('name') 
	 . ' (' . strlen($form->getUnfilteredValue('name')) . ')';
