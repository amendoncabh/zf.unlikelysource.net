<?php

require_once 'Zend/Form/SubForm.php';

class Form_AddressSubform extends Zend_Form_SubForm
{

	public function init()
    {
    	$countries = Zend_Registry::get('countries');
        // Add the address element
        $this->addElement('textarea', 'address', array(
        	'rows'		=> 4,
        	'cols'		=> 40,
            'label'      => 'Street Address:',
            'required'   => true,
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 20))
                )
        ));
        
        // Add a city element
        $this->addElement('text', 'city', array(
            'label'      => 'City:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
        		array('alnum'),
        		array('validator' => 'StringLength', 'options' => array(1, 128))
                )
        ));

        // Add a state/province/county element
        $this->addElement('text', 'state_prov_cty', array(
            'label'      => 'State/Province/County:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
        		array('alnum'),
        		array('validator' => 'StringLength', 'options' => array(1, 128))
                )
        ));

        // Add a postalCode element
        $this->addElement('text', 'postalCode', array(
            'label'      => 'Postal (Zip) Code:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
        		array('alnum'),
        		array('validator' => 'StringLength', 'options' => array(1, 16))
                )
        ));
        
        // Supported countries
        $this->addElement(new Zend_Form_Element_Select('country'));
        $this->country->setLabel('Country:')
        		->setRequired(true)
        		->setMultiOptions($countries);
        
    }
}
