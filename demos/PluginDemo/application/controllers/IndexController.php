<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function phoneValidatorTestAction()
    {
        $form = new Custom_Form_Phone();
        $request = $this->getRequest();
        if ($request->isPost()) {
        	if ($form->isValid($request->getPost())) {
        		$this->view->message = 'VALID';
        	} else {
        		$this->view->message = 'TRY AGAIN';
        	}
        } else {
        	$this->view->message = 'ENTER DATA';
        }
        $this->view->form = $form;
        // add custom view helper path
        $this->view->addBasePath(APPLICATION_PATH . '/../library/Custom/View', 'Custom_View_');
    }

    public function ipValidatorTestAction()
    {
        $form = new Custom_Form_Ip();
        $request = $this->getRequest();
        if ($request->isPost()) {
        	if ($form->isValid($request->getPost())) {
        		$this->view->message = 'VALID';
        	} else {
        		$this->view->message = 'TRY AGAIN';
        	}
        } else {
        	$this->view->message = 'ENTER DATA';
        }
        $this->view->form = $form;
        // add custom view helper path
        $this->view->addBasePath(APPLICATION_PATH . '/../library/Custom/View', 'Custom_View_');
    }

    public function bootstrapResourceTestAction()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        $value1 = $bootstrap->getResource('viewplus');
        $this->view->viewplus_from_controller = $value1;
        $value2 = $bootstrap->getResource('viewbase');
        $this->view->viewbase_from_controller = $value2;
    }


}
