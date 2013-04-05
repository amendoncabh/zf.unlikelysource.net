<?php

class Form_UserinfoWithSubforms extends Zend_Form
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
    public function __construct($name, $config, $countries)
    {
    	parent::__construct($name);
    	Zend_Registry::set('countries', $countries);
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

        // Add subforms
        $this->addSubForm(new Form_NameSubform(), 'Name');
        $this->addSubForm(new Form_AddressSubform(), 'Address');
        
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

        					   
    }
}
