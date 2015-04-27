<?php

class Chat_RoomController extends Zend_Controller_Action
{

    protected $_config 		 = null;
    protected $_options 	 = null;
    protected $_postForm 	 = null;
    protected $_messagesForm = null;
	protected $_queue 		 = null;
	protected $_notify 		 = '';

    public function init()
    {
    	$this->_postForm 	 = new Chat_Form_Post();
    	$this->_messagesForm = new Chat_Form_Messages();
    	$this->_config = $this->getFrontController()->getParam('bootstrap')->getOptions();
		$this->_options = array (
			'driverOptions' => array(
					'host'		=> $this->_config['resources']['db']['params']['host'],
					'username'	=> $this->_config['resources']['db']['params']['username'],
					'password'	=> $this->_config['resources']['db']['params']['password'],
					'dbname'	=> $this->_config['resources']['db']['params']['dbname'],
					'type'      => $this->_config['resources']['db']['adapter']),
			'name'	=> 'chat'
		);
		try {
			// set up database handle + queue
			$this->_queue = new Zend_Queue('Db', $this->_options);
			$this->_queue->createQueue('chat', 300);	// params = name, timeout
		} catch (Zend_Queue_Exception $e) {
			$this->_notify .= '<pre>';
		    $this->_notify .= "ERROR: " . $e->getMessage();
			$this->_notify .= $e->getTraceAsString();
			$this->_notify .= '</pre>';
		} catch (Zend_Exception $e) {
			$this->_notify .= '<pre>';
			$this->_notify .= "ERROR: " . $e->getMessage();
			$this->_notify .= $e->getTraceAsString();
			$this->_notify .= '</pre>';
		}
		// right column ads
		$this->view->position_6   = Application_Model_RightColAds::getAds();
    }

    public function indexAction()
    {
        $this->_forward('visit');
    }

    public function visitAction()
    {
    	$request = $this->getRequest();
		$count = $this->_queue->count();
    	if ($request->isPost() && $this->_messagesForm->isValid($request->getPost())) {
    		if ($this->_messagesForm->getValue('clear')) {
    			$this->_queue->deleteQueue();
				$this->_notify = 'Message queue successfully cleared!';
    		}
    	}
		$count = $this->_queue->count();
    	if ($count) {
			$output = array();
			$list = $this->_queue->receive($count);
			foreach ($list as $i => $item) {
				$message = explode('|', $item->body);
				$output[$i] = sprintf("%04d : %s [from: %s] : %s\n", $i, $message[0], $message[1], $message[2]);
			}
			$this->_messagesForm->getElement('messages')->setMultiOptions($output);
		} else {
			$this->_notify .= '<p>No messages in the queue</p>';
		}
    	$this->view->notify 		= $this->_notify;
		$this->view->messagesForm	= $this->_messagesForm;
    }

    public function postAction()
    {
    	$request = $this->getRequest();
    	// receive filtered input
		if ($request->isPost() && $this->_postForm->isValid($request->getPost())) {
			if ($this->_postForm->getValue('post')) {
				$message = array(date('H:i:s_d-m-Y'), 
								 $this->_postForm->getValue('username'), 
								 $this->_postForm->getValue('message'));
				$this->_queue->send(implode('|', $message));
				$this->_redirect('/chat/room/visit');
			}
		}
    	$this->view->notify   = $this->_notify;
		$this->view->postForm = $this->_postForm;
    }

    public function deleteAction()
    {
		$this->_redirect('/chat/room/visit');
    }

}
