<?php

class IndexController extends Zend_Controller_Action
{

    protected $config = null;
    protected $users = null;
    protected $form = null;
	protected $_role;
	protected $_name;
    
    public function init()
    {
		$this->config = $this->getFrontController()->getParam('bootstrap')->getOptions();
   		$this->users = new Zend_Config_Xml(APPLICATION_PATH . "/files/users.xml","roles");
		$this->view->list = $this->users;
    	$this->form = new Application_Form_Login();
		// get identity & role from session
    	$sess = new Zend_Session_Namespace("AuthDemo");
		$this->_name = (isset($sess->name)) ? $sess->name : 'guest';
		$this->_role = (isset($sess->role)) ? $sess->role : 'guest';		
		// assign role to navigation
		$this->view->navigation()->setAcl(Zend_Registry::get('acl'))->setRole($this->_role);
    }

    public function indexAction()
    {
        // action body
		$this->view->loginForm = $this->form;
    }

    public function loginAction()
    {
        // action body
    	$form = new Application_Form_Login();
		if ($this->getRequest()->isPost()) {
	        if ($form->isValid($_POST)) {
		        // now try and authenticate....
		    	$name = $form->getValue('name');
		        $pwd = $form->getValue('pwd');
	        	$auth = $this->getAuth($name,$pwd);
	        	$this->_redirect('/');   
	        } else {
	            // Failed validation; redisplay form
				$label = "<h4>&nbsp;Login</h4>\n";
	        	$this->view->loginForm = $label . $form;
	        }
		} 
    }

    public function getAuth($name, $pwd)
    {
    	$sess = new Zend_Session_Namespace("AuthDemo");
    	$auth = Zend_Auth::getInstance();
        $fn = $this->config['auth']['fn'];
        $realm = $this->config['auth']['realm'];
		$adapter = new Zend_Auth_Adapter_Digest($fn,$realm,$name,$pwd);
		$result = $auth->authenticate($adapter);
		$identity = $result->getIdentity();
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

    public function dumpMenuAction()
    {
        $this->view->aclMenu 	= Zend_Registry::get('aclMenu');
        $this->view->aclPlugin 	= Zend_Registry::get('aclPlugin');
    }

}


