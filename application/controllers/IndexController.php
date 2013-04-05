<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
		// right column ads
		$this->view->position_6   = Application_Model_RightColAds::getAds();
    }

    public function indexAction()
    {
    	$auth = Zend_Auth::getInstance();
    	if ($auth->hasIdentity()) {
    		$form = new Application_Form_AdminLogout();
    	} else {
	    	$config = Zend_Registry::get('options');
	        $form = new Application_Form_AdminLogin($config['captcha']['bold'], 
	        										$config['captcha']['dir'], 
	        										$config['captcha']['url']);
    	}
        array_push($this->view->position_7, $form);
    }


}

