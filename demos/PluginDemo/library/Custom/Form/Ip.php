<?php
class Custom_Form_Ip extends Zend_Form
{
	public function init()
	{
		$this->setMethod('POST');
		$ip1 = new Zend_Form_Element_Text('ip1');
		$ip1->addPrefixPath('Custom_Plugin_Validator', 'Custom/Plugin/Validator', 'validate');
		$ip1->setLabel('IP Address with Custom Validator')
		    ->addValidator('Ip');
		$ip2 = new Zend_Form_Element_Text('ip2');
		$ip2->setLabel('IP Address with Zend IP Validator')
		    ->addValidator('Ip');
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Validate');
		$this->addElements(array($ip1, $ip2, $submit));
	}
}