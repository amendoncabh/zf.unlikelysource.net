<?php

/**
 * This is the userinfo form.  It is in its own directory in the application 
 * structure because it represents a "composite asset" in your application.  By 
 * "composite", it is meant that the form encompasses several aspects of the 
 * application: it handles part of the display logic (view), it also handles 
 * validation and filtering (controller and model).  
 *
 * @uses       Zend_Form
 * @package    QuickStart
 * @subpackage Form
 */
class Form_Userinfo extends Zend_Form
{
    /**
     * init() is the initialization routine called when Zend_Form objects are 
     * created. In most cases, it make alot of sense to put definitions in this 
     * method, as you can see below.  This is not required, but suggested.  
     * There might exist other application scenarios where one might want to 
     * configure their form objects in a different way, those are best 
     * described in the manual:
     *
     * @see    http://framework.zend.com/manual/en/zend.form.html
     * @param	$config = comes from Zend_Config = comes from application.ini
     * @param	$countries = comes from [countries] section of application.ini
     * @return void
     */ 
    public function __construct($config,$countries)
    {
    	// Name and location of the font file
		$font = $config['font'];		
		
		// Directory where the captcha will be written
		$dir = $config['dir'];	
		
		// Base URL where captcha can be accessed
		// i.e. http://example.com/images
		$url = $config['url'];	
		
		// This sets the "action" attribute on the <form> tag
		$this->setAction('/form/process');
		
    	// Set the method for the display form to POST
        $this->setMethod('post');

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
        
        // Add an image captcha
        $this->addElement('captcha', 'captcha', array(
		    'label' => "Please enter these characters in the box:",
			'required' => true,
		    'captcha' => array(
		        'captcha'    => 'image',
		        'wordLen'    => 4,
		        'font'       => $font,
		        'fontSize'   => 32,
		        'imgDir'     => $dir,
		        'imgUrl'     => $url,
		        'timeout'    => 300)
		   		));        
                
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Submit User Info',
        ));

        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));

        // Display Groups
        $this->addDisplayGroup(array('email',
        							 'firstName',
        							 'familyName', 
        							 'ssn'),
        					   'Name',
        					   array('legend' => 'Name', 'class' => 'nameClass'));
        $this->addDisplayGroup(array('address',
        							 'city',
        							 'state_prov_cty',
        							 'postalCode',
        							 'country'),
        					   'Address',
        					   array('legend'=>'Address', 'class' => 'addressClass'));
        $this->addDisplayGroup(array('captcha',
        							 'submit'),
        					   'Remainder',
        					   array('legend'=>'', 'class' => 'remainderClass'));
        					   
    }
}
