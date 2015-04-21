<?php

class IndexController extends Zend_Controller_Action
{

    public function indexAction()
    {
    	$this->view->test .= '<br >' . __METHOD__;
    	$name = $this->getRequest()->getParam('name');
		$options = $this->getFrontController()->getParam('bootstrap')->getOption('new');
        // action body
        $this->view->options = $options;
        $this->view->name = $name;
        // trigger event
        Events_Service_EventManager::
        	getEventManager()->trigger(
        		Events_Service_EventManager::EVENTS_EVENT_DATE,
        		$this,
        		array('method' => __METHOD__));
    }

    public function testAction()
    {
    	$this->view->test .= '<br >' . __METHOD__;
    	return $this->_redirect('/');
    }

    public function forwardAction()
    {
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout(TRUE);
        echo '<br />BEFORE FORWARD';
        $this->_forward('forwardnow');
        echo '<br />AFTER FORWARD';        
    }

    public function forwardnowAction()
    {
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout(TRUE);
        echo '<br />FORWARD NOW';
    }

    public function dateAction()
    {
        Events_Service_EventManager::
        	getEventManager()->trigger(
        		Events_Service_EventManager::EVENTS_EVENT_DATE,
        		$this,
        		array('method' => __METHOD__));
    }


}
