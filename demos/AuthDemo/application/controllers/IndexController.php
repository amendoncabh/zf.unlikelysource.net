<?php

class IndexController extends Zend_Controller_Action
{

	public $config;		// Used to hold info from config file
	public $users;
	public $selectUsers;
		
    public function init()
    {
		$this->config = $this->getFrontController()->getParam('bootstrap')->getOptions();
   		$this->users = new Zend_Config_Xml(APPLICATION_PATH . "/files/users.xml","roles");
		$this->view->list = $this->users;
        // build list of users
        $this->selectUsers = array();
        foreach ($this->users->toArray() as $key => $value) {
        	$this->selectUsers[$key] = $key;
        } 
    }

    public function indexAction()
    {
    	$form = new Application_Form_Login($this->selectUsers);
		$label = "<h4>&nbsp;Login</h4>\n";
		$this->view->loginForm = $label . $form;
	    $this->_forward("file","file");   
    }

    public function loginAction()
    {
        // action body
    	$form = new Application_Form_Login($this->selectUsers);
		if ($this->getRequest()->isPost()) {
	        if ($form->isValid($_POST)) {
		        // now try and authenticate....
		    	$name = $form->getValue('name');
		        $pwd = $form->getValue('pwd');
	        	$auth = $this->getAuth($name,$pwd);
	        	$this->_forward("file","file");   
	        } else {
	            // Failed validation; redisplay form
				$label = "<h4>&nbsp;Login</h4>\n";
	        	$this->view->loginForm = $label . $form;
	        }
		} 
    }
    
    public function getAuth($name,$pwd)
    {
    	$sess = new Zend_Session_Namespace("AuthDemo");
    	$auth = Zend_Auth::getInstance();
        $fn = $this->config['auth']['fn'];
        $realm = $this->config['auth']['realm'];
		$adapter = new Zend_Auth_Adapter_Digest($fn,$realm,$name,$pwd);
		$result = $auth->authenticate($adapter);
		$identity = $result->getIdentity();
		// normally don't need to store, already stored as Zend_Session_Namespace('Zend_Auth')
		$sess->name = $identity['username'];
		$sess->role = $this->roleLookup($sess->name);
		if ($result->isValid()) {
        	$sess->auth = TRUE;
        	$this->view->msg = "Successful Login";
		} else {
        	$sess->auth = FALSE;
			$this->view->msg = "Unsuccessful Login<br />";
			$this->view->msg .= Zend_Debug::dump($result, "RESULT OBJECT:", FALSE);
		}
		return $sess->auth;
    }

    public function roleLookup($key)
    {
    	$result = "guest";
   		foreach($this->users as $name => $role) {
   			if ($key == $name ) { 
   				$result = $role; 
   				break;
   			}
   		}
   		return $result;
    }
}
