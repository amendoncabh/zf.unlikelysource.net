<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
		$this->view->assign('layoutVar', "This is set in the INDEX controller");
    }

    public function indexAction()
    {
    }

    public function loginAction()
    {
        // action body
    }


}



