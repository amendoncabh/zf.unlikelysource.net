<?php
class QAndA_Form_Search extends Zend_Form
{
	public function init()
	{
		$this->setAction('/qAndA/index/search')
		     ->setMethod('POST');
		$text = new Zend_Form_Element_Text('search');
		$text->setLabel('Search');
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Search')
        	   ->setAttrib('id', 'submitbutton');
        $this->addElements(array($text, $submit));
	}
}