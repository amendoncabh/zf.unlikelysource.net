<?php

class UserController extends Zend_Controller_Action
{
	protected  $_users;
	
    public function init()
    {
		$this->_config = $this->getFrontController()->getParam('bootstrap')->getOptions();
   		$this->_users = new Zend_Config_Xml(APPLICATION_PATH . "/files/users.xml","roles");
		$this->view->list = $this->_users;
    }
    
	public function loginAction()
    {
    	// see: https://github.com/thebestsolution/TBS-Zend-Library
    	// or: http://thebestsolution.org
        $auth = TBS_Auth::getInstance();

        $providers = $auth->getIdentity();

        // Here the response of the providers are registered
        if ($this->_hasParam('provider')) {
            $provider = $this->_getParam('provider');

            switch ($provider) {
                case "facebook":
                    if ($this->_hasParam('code')) {
                        $adapter = new TBS_Auth_Adapter_Facebook(
                                $this->_getParam('code'));
                        $result = $auth->authenticate($adapter);
                    }
                    break;
                case "twitter":
                    if ($this->_hasParam('oauth_token')) {
                        $adapter = new TBS_Auth_Adapter_Twitter($_GET);
                        $result = $auth->authenticate($adapter);
                    }
                    break;
                case "google":
                    if ($this->_hasParam('code')) {
                        $adapter = new TBS_Auth_Adapter_Google(
                                $this->_getParam('code'));
                        $result = $auth->authenticate($adapter);
                    }
                    break;

            }
            // What to do when invalid
            if (!$result->isValid()) {
                $auth->clearIdentity($this->_getParam('provider'));
                throw new Exception('Error!!');
            } else {
                $this->_redirect('/user/connect');
            }
        } else { // Normal login page
            $this->view->googleAuthUrl = TBS_Auth_Adapter_Google::getAuthorizationUrl();

            $this->view->facebookAuthUrl = TBS_Auth_Adapter_Facebook::getAuthorizationUrl();

            $this->view->twitterAuthUrl = TBS_Auth_Adapter_Twitter::getAuthorizationUrl();
        }

    }
    public function connectAction()
    {
        $auth = TBS_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            throw new Zend_Controller_Action_Exception('Not logged in!', 404);
        }
        $this->view->providers = $auth->getIdentity();
    }

    public function logoutAction()
    {
        TBS_Auth::getInstance()->clearIdentity();
    	$auth = Zend_Auth::getInstance();
    	$auth->clearIdentity();
        Zend_Session::destroy();
        $this->_redirect('/');
    }
}
