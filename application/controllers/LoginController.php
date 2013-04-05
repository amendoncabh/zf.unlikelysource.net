<?php
class LoginController extends Zend_Controller_Action
{

	protected $_config;
	protected $_auth;
	
	public function init()
    {
	    $this->_config 	= Zend_Registry::get('options');
	    $this->_auth 	= Zend_Auth::getInstance();
    }

    public function indexAction()
    {
        $request = $this->getRequest();
    	if ($request->isPost()) {
    		$form = new Application_Form_AdminLogin($this->_config['captcha']['font'],
    												$this->_config['captcha']['dir'],
    												$this->_config['captcha']['url']);
    		if ($form->isValid($request->getPost())) {
    			$name = $form->getValue('auth_name');
		        $pwd = $form->getValue('auth_pwd');
		        $fn = $this->_config['auth']['fn'];
		        $realm = $this->_config['auth']['realm'];
				$adapter = new Zend_Auth_Adapter_Digest($fn,$realm,$name,$pwd);
				$this->_auth->authenticate($adapter);
    		} else {
    			$this->_forward('index', 'index');
    		}
    	}
    }

	public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
   	}

   	public function postDispatch()
   	{
    	$this->_redirect('/');
   	}
   	
}
