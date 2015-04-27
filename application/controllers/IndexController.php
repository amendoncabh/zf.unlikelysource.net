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

    public function codeAction()
    {
        $nico = (int) $this->getParam('nico');
        if ($nico) {
            $file = highlight_file(APPLICATION_PATH . '/../data/pdf/Zend_Pdf_Page_Nico_Edtinger.php', TRUE);
        } else {
            $file = '';
        }
        $this->view->nico = $file;
    }


}
