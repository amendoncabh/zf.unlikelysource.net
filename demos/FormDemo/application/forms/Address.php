<?php
class Form_Address extends Zend_Form
{
    public function __construct()
    {
        parent::__construct();
        $style = 'font: bold 12pt helvetica, sans;';
		$this->setAction('/form/address')
        	 ->setMethod('post');
		$addr1 = new Zend_Form_Element_Text('addr1');
        $addr1->setLabel('Address Line 1')      		
        		->setAttribs(array('title' => 'Enter First Line of Address','size' => '60'))
	            ->setRequired(true)
	            ->addFilter('StripTags')
	            ->addFilter('StringTrim')
	            ->addValidator('StringLength',array(1, 255));
		$addr1->setDecorators(array(
				'ViewHelper',
				'Errors',
				array(array('data' => 'HtmlTag'), array('tag' => 'td')),
			    array('Label', array('tag' => 'td', 'style' => $style)),
			    array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
				));
		$addr2 = new Zend_Form_Element_Text('addr2');
        $addr2->setLabel('Address Line 2')      		
        		->setAttribs(array('title' => 'Enter Second Line of Address','size' => '60'))
	            ->setRequired(true)
	            ->addFilter('StripTags')
	            ->addFilter('StringTrim')
	            ->addValidator('StringLength',array(1, 255));
		$addr2->setDecorators(array(
				'ViewHelper',
				'Errors',
				array(array('data' => 'HtmlTag'), array('tag' => 'td')),
			    array('Label', array('tag' => 'td', 'style' => $style)),
			    array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
				));
		$city = new Zend_Form_Element_Text('city');
        $city->setLabel('City')      		
        		->setAttribs(array('title' => 'Enter City','size' => '40'))
	            ->setRequired(true)
	            ->addFilter('StripTags')
	            ->addFilter('StringTrim')
	            ->addValidator('StringLength',array(1, 128));
		$city->setDecorators(array(
				'ViewHelper',
				'Errors',
				array(array('data' => 'HtmlTag'), array('tag' => 'td')),
			    array('Label', array('tag' => 'td', 'style' => $style)),
			    array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
				));
		$state_prov = new Zend_Form_Element_Text('state_prov');
        $state_prov->setLabel('State/Province')      		
        		->setAttribs(array('title' => 'Enter State or Province','size' => '16'))
	            ->setRequired(true)
	            ->addFilter('StripTags')
	            ->addFilter('StringTrim')
	            ->addValidator('StringLength',array(1, 64));
		$state_prov->setDecorators(array(
				'ViewHelper',
				'Errors',
				array(array('data' => 'HtmlTag'), array('tag' => 'td')),
			    array('Label', array('tag' => 'td', 'style' => $style)),
			    array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
				));
		$postalcode = new Zend_Form_Element_Text('postalcode');
        $postalcode->setLabel('Postal Code')      		
        		->setAttribs(array('title' => 'Enter postalcode','size' => '16'))
	            ->setRequired(true)
	            ->addFilter('StripTags')
	            ->addFilter('StringTrim')
	            ->addValidator('StringLength',array(1, 16));
		$postalcode->setDecorators(array(
				'ViewHelper',
				'Errors',
				array(array('data' => 'HtmlTag'), array('tag' => 'td')),
			    array('Label', array('tag' => 'td', 'style' => $style)),
			    array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
				));
		$phone = new Zend_Form_Element_Text('phone');
        $phone->setLabel('Phone')      		
        		->setAttribs(array('title' => 'Enter phone','size' => '16'))
	            ->setRequired(true)
	            ->addFilter('Digits')
	            ->addValidator('StringLength',array(1, 16));
		$phone->setDecorators(array(
				'ViewHelper',
				'Errors',
				array(array('data' => 'HtmlTag'), array('tag' => 'td')),
			    array('Label', array('tag' => 'td', 'style' => $style)),
			    array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
				));
		$submit = new Zend_Form_Element_Submit('submit');           
        $submit->setLabel('Submit')
        		->setIgnore(TRUE)
        		->setRequired(FALSE)
	        	->setAttribs(array(
	        		'class' => 'form-button',
	        		'title' => 'Click here to submit form info',
	        		'id' => 'submit'));
		$submit->setDecorators(array(
				'ViewHelper',
				'Errors',
				array(array('data' => 'HtmlTag'), array('tag' => 'td')),
			    array('Label', array('tag' => 'td', 'style' => $style)),
			    array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
				));
	    $this->addElements(	array($addr1,$addr2,$city,$state_prov,$postalcode,$phone,$submit));
		$this->addElement('hash', 'no_csrf_foo', array('salt' => 'FormDemo'));
    }
}
