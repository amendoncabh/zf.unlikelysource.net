<?php

class IndexController extends Zend_Controller_Action
{

	public $sess;
	
	public function init()
    {
		$this->sess = new Zend_Session_Namespace('Demo');
    }

    public function indexAction()
    {
    	$this->view->options = Zend_Registry::get('options');
    }
    
    public function colorAction()
    {
	    $msg = "Choose A Color to Switch";
    	$list = $this->_helper->fruitColorList();
    	$obj = new stdClass();
    	$obj->list = $list;
    	$request = $this->getRequest(); 
    	if ($request->isPost()) {
	        $params = $request->getParams();
	        if (isset($params['submit'])) {
	        	$color = (isset($params['color'])) ? $params['color'] : 'black';
	        	// Need to pass an object otherwise returns params won't get modified
	        	if ($this->_helper->switchColor($color,$obj)) {
	        		$msg = "Switched OK";
	        	} else {
	        		$msg = "Color Not Found";
	        	}
	        }
    	}
    	$this->view->list = $obj->list;
    	$this->view->msg = $msg;
    }
}
