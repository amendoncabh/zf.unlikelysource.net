<?php
class QAndA_Form_Add extends Zend_Form
{
	public function init()
	{
		$this->setAction('/qAndA/index/add')
		     ->setMethod('POST');
		$title = new Zend_Form_Element_Text('title');
		$title->setLabel('Title')
			  ->addFilter('StringTrim');
		$text = new Zend_Form_Element_Textarea('text');
		$text->setLabel('Search')
			 ->setAttribs(array('cols' => 40, 'rows' => 8))
			 ->addFilter('StringTrim');
        $submit = new Zend_Form_Element_Submit('add');
        $submit->setLabel('Add')
        	   ->setAttrib('id', 'submitbutton');
        $this->addElements(array($title, $text, $submit));
	}
}