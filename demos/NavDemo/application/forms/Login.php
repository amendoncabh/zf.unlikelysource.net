<?php
class Application_Form_Login extends Zend_Form {
	
	function __construct() {
        parent::__construct();
		$this->setMethod("POST")
			 ->setAction("/index/login");
		$header = new Zend_Form_Element_Hidden('header');
		$header->setDescription("<h4>&nbsp;Login</h4>\n");
		$username = new Zend_Form_Element_Text('name');
		$username->addValidator('alnum')
		         ->addValidator('regex', false, array('/^[a-z]+/'))
		         ->addValidator('StringLength', false, array(2,7))
		         ->setRequired(true)
		         ->addFilter('StringToLower')
		         ->setLabel('Login Name');	
		$password = new Zend_Form_Element_Password('pwd');
		$password->addValidator('StringLength', false, array(2,7))
		         ->setRequired(true)
		         ->setLabel('Password');

		$this->addElements(array($username,$password));
		     // use addElement() as a factory to create 'Login' button:
		$this->addElement('submit', 'login', array('label' => 'Login'));	
		$this->addElement('hash', 'no_csrf_garbage', array('salt' => 'AuthDemo'));
	}
	
}