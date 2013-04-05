<?php
class Custom_Form_Phone extends Zend_Form
{
	public function init()
	{
		$this->setMethod('POST');
		$phone = new Zend_Form_Element_Text('phone');
		$phone->addPrefixPath('Custom_Plugin_Validator', "Custom/Plugin/Validator", 'validate');
		$phone->setLabel('Phone Number')
			  ->addValidator('Phone');
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Validate');
		$this->addElements(array($phone, $submit));
	}
}