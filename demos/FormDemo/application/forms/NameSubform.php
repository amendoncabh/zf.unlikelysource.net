<?php

//require_once 'Zend/Form/SubForm.php';

class Form_NameSubform extends Zend_Form_Subform
{
	
    public function init()
    {
        // Add an email element
        $this->addElement('text', 'email', array(
            'label'      => 'Your email address:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            )
        ));

        // Add a name element
        $this->addElement('text', 'firstName', array(
            'label'      => 'Your first name:',
            'required'   => false,
            'filters'    => array('StringTrim'),
            'validators' => array(
        		array('validator' => 'StringLength', 'options' => array(0, 64))
                )
        ));

        // Add a family name element
        $this->addElement('text', 'familyName', array(
            'label'      => 'Your family name (last name or surname):',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
        		array('alnum'),
        		array('validator' => 'StringLength', 'options' => array(1, 64))
                )
        ));

        // Add prefix path for custom filter
        $this->addElementPrefixPath('Custom_Filter', APPLICATION_PATH . '/../library/Custom/Filter', 'filter');
        
        // Add a US Social Security Number element w/ custom filter
        $this->addElement('text', 'ssn', array(
            'label'      => 'Enter US Social Security Number:',
            'required'   => true,
            'filters'    => array('Ssn')
        ));

    }
}
