<?php

class Ops_CalcController extends Zend_Controller_Action
{

	protected $_op1 = 0;
	protected $_op2 = 0;
	
    public function init()
    {
        $this->_op1 = (float) $this->_getParam('op1');
        $this->_op2 = (float) $this->_getParam('op2');
	    $this->view->op1 = $this->_op1;
	    $this->view->op2 = $this->_op2;
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
        $this->view->res = $this->_op1 + $this->_op2;
    }

    public function subAction()
    {
        $this->view->res = $this->_op1 - $this->_op2;
    }

    public function mulAction()
    {
    	$this->view->res = $this->_op1 * $this->_op2;
    }

    public function divAction()
    {
        $this->view->res = ($this->_op2 == 0) ? 'ERROR: divide by zero' : $this->_op1 / $this->_op2;
    }

}
