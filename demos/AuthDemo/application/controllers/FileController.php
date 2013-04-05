<?php

class FileController extends Zend_Controller_Action
{

	protected $_config;
	protected  $_users;
	
    public function init()
    {
		$this->_config = $this->getFrontController()->getParam('bootstrap')->getOptions();
   		$this->_users = new Zend_Config_Xml(APPLICATION_PATH . "/files/users.xml","roles");
		$this->view->list = $this->_users;
    }

    public function indexAction()
    {
        $this->_forward("index","index");
    }

	public function fileAction() {
		// Check to see if authorized at all
		$viewSet = array();
		// Note: normally you don't reference $_SESSION directly ...
		//       but this is another way can access a Zend_Session_Namespace value
    	$sess = new Zend_Session_Namespace("AuthDemo");
		if (!isset($sess->role)) {
			$sess->role = 'guest';
		}
		$acl = Zend_Registry::get('acl');
		// Red Files
		if ($acl->isAllowed($sess->role,"redFiles","access")) {
			$viewSet['red'] = $this->_getFileLinks("red");
		}
		// Green Files
		if ($acl->isAllowed($sess->role,"greenFiles","access")) {
			$viewSet['green'] = $this->_getFileLinks("green");
		}
		// Yellow Files
		if ($acl->isAllowed($sess->role,"yellowFiles","access")) {
			$viewSet['yellow'] = $this->_getFileLinks("yellow");
		}
		$this->view->title = "Accessible Resources";
		$this->view->fileSet = $viewSet;
	}
	
	protected function _getFileLinks($loc) {
		// Generate list of files in red or green directory
		$pattern = $this->_config['restricted'][$loc] . "/*";
		$files = glob($pattern);
		$list = array();
		foreach ($files as $item) {
			$list[] = basename($item);
		}
		return $list;
	}

	public function accessAction() {
		$color = $this->getRequest()->getParam('color');
		$fn = APPLICATION_PATH . "/files/" . $color . "/index.html";
		$contents = file_get_contents($fn);
		$this->view->contents = $contents;
	}
	
}
