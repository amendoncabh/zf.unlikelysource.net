<?php

class AclpluginController extends Zend_Controller_Action
{

	protected $_config;
	protected $_users;
	protected $_role;
	protected $_name;
	
    public function init()
    {
		$this->_config = $this->getFrontController()->getParam('bootstrap')->getOptions();
   		$this->_users = new Zend_Config_Xml(APPLICATION_PATH . "/files/users.xml","roles");
		$this->view->list = $this->_users;
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
    }

    public function viewGreenAction()
    {
		$viewSet['green'] = $this->_getFileLinks("green");
    	$this->view->title = "View Green";
		$this->view->fileSet = $viewSet;
    }

    public function editGreenAction()
    {
		$viewSet['green'] = $this->_getFileLinks("green");
    	$this->view->title = "Edit Green";
		$this->view->fileSet = $viewSet;
    }

    public function viewRedAction()
    {
		$viewSet['red'] = $this->_getFileLinks("red");
    	$this->view->title = "View Red";
		$this->view->fileSet = $viewSet;
    }

    public function editRedAction()
    {
		$viewSet['red'] = $this->_getFileLinks("red");
    	$this->view->title = "Edit Red";
		$this->view->fileSet = $viewSet;
    }

    public function viewYellowAction()
    {
		$viewSet['yellow'] = $this->_getFileLinks("yellow");
    	$this->view->title = "View Yellow";
		$this->view->fileSet = $viewSet;
    }

    public function editYellowAction()
    {
		$viewSet['yellow'] = $this->_getFileLinks("yellow");
    	$this->view->title = "Edit Yellow";
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

}

