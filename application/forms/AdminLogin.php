<?php
class Application_Form_AdminLogin extends Zend_Form
{
    public function __construct($font, $dir, $url)
    {
        parent::__construct();
		$this->setAction('/login/index')
        	->setMethod('post');
        $name = new Zend_Form_Element_Text('auth_name');
        $name->setLabel('Login Name')
               ->setRequired(true)
               ->setAttrib('size', 20)
               ->addFilter('StripTags')
               ->addFilter('StringTrim')
               ->addValidator('StringLength',array(1, 64))
               ->addValidator('NotEmpty');
        $password = new Zend_Form_Element_Password('auth_pwd');
        $password->setLabel('Password')
               ->setRequired(true)
               ->setAttrib('size', 20)
               ->addFilter('StripTags')
               ->addFilter('StringTrim')
               ->addValidator('StringLength',array(1, 64))
               ->addValidator('NotEmpty');
		$captcha = new Zend_Form_Element_Captcha('auth_captcha', array(
		    'label' 	=> "Please type these 5 letters:",
			'required' 	=> true,
			'size'		=> 20,
		    'captcha' => array(
		        'captcha'    => 'image',
		        'wordLen'    => 5,
		        'font'       => $font,
		        'fontSize'   => 24,
		        'imgDir'     => $dir,
		        'imgUrl'     => $url,
				'height'     => 80,
		        'expiration' => 60,
		        'timeout'    => 300)
		   		));        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Login')
        		->setAttrib('id', 'submitbutton');
        $this->addElements(array($name,$password,$captcha,$submit));
		$this->addElement('hash', 'no_csrf_foo', array('salt' => 'codeArchive'));
    }
}
