<?php
class Etherpad_PadController extends Zend_Controller_Action
{

    protected $_padForm = null;
    protected $_controlsForm = null;
    protected $_status = null;
    protected $_session = null;
    protected $_padId = null;
    protected $_cache = null;
    protected $_config = null;

    public function init()
    {
    	$this->_config			= Zend_Registry::get('options');
    	$this->_session			= new Zend_Session_Namespace('etherpad');
        $this->_padForm 		= new Etherpad_Form_Pad();
        $this->_controlsForm 	= new Etherpad_Form_Controls();
        $this->view->modCalled 	= 'etherpad';
    	$filter 			    = new Zend_Filter_Alnum();
    	// make sure you've got a pad ID; priority: params, session then default
    	if ($this->_getParam('pad')) {
    		$this->_padId = $filter->filter($this->_getParam('pad'));
    	} else {
    		if (isset($this->_session->padId)) {
    			$this->_padId = $this->_session->padId;
    		} else {
    			$this->_padId = date('His') . sprintf('%02d', rand(0, 99));
    		}
    	}
    	$this->_session->padId = $this->_padId;
    	$this->_controlsForm->getElement('padId')->setValue($this->_padId);
    	if ($this->_session->username) {
    		$this->_controlsForm->getElement('username')->setValue($this->_session->username);
    	}
    	// set up the view
        Zend_Dojo::enableView($this->view);
        $this->view->session = $this->_session;
    	// set up cache
		$this->_cache = Application_Model_Cache::getCache();
		// check for pad cache
		if ($this->_padId) {
			$padCache = $this->_cache->load($this->_padId);
			if ($padCache) {
				$padCache = stripslashes($padCache);
				$this->_padForm->getElement('editor')->setValue($padCache);
			}
		}		
    }

    public function indexAction()
    {
    	$messages = (isset($this->_session->messages)) ? $this->_session->messages : '';
    	$this->_session->messages = '';
   		// lock file
   		$lockFile = $this->_config['cache']['lock'] . DIRECTORY_SEPARATOR . $this->_padId . '.lock';
    	if ($this->getRequest()->isPost()) {
    		// which form?
    		if ($this->getRequest()->getPost('submit')) {
//				phpinfo(INFO_VARIABLES);
//				exit;
    			if ($this->_padForm->isValid($this->getRequest()->getPost())) {
		    		// refresh lock file name
		    		$lockFile = $this->_config['cache']['lock'] . DIRECTORY_SEPARATOR . $this->_padId . '.lock';
    				// check to see if lock exists && is our username
					if (file_exists($lockFile)) {
						$lockUser = file_get_contents($lockFile);
						if ($this->_session->username == $lockUser) {
							// update cache + get rid of lock file
		    				$this->_cache->save($this->_padForm->getValue('editor'), $this->_padId);
		    				$this->_session->messages = 'Etherpad Updated Successfully';
		    				unlink($lockFile);
		    				$this->_redirect('/etherpad/pad/index/pad/' . $this->_padId);
						} else {
							$messages .= 'Cannot Save Changes!'
									  . '<br />Etherpad Locked By: '. $lockUser;
						}
					} else {
						$messages .= 'Need to Lock File Before'
								  . '<br />Submitting Changes' 
								  . '<br />NOTE: '
								  . '<br />Any changes just made' 
								  . '<br />will be lost! Be sure'
								  . '<br />to back them up!';
					}
    			} else {
					$messages .= 'Invalid Values -- Check Messages';
    			}
    		}
    	}
    	if ($messages) {
    		$messages = '<span class="etherpad_message">' . $messages . '</span>';
        	array_push($this->view->position_7, $messages);
    	}
        // left menu
        array_push($this->view->position_7, $this->_controlsForm);
        // contents
    	$this->view->form  = $this->_padForm;
    	// pad ID
        $this->view->padId = $this->_padId;
    }

    public function lockAction()
    {
    	$messages = (isset($this->_session->messages)) ? $this->_session->messages : '';
    	$this->_session->messages = '';
   		// lock file
   		$lockFile = $this->_config['cache']['lock'] . DIRECTORY_SEPARATOR . $this->_padId . '.lock';
    	if ($this->getRequest()->isPost()) {
    		// which form?
    		if ($this->getRequest()->getPost('lock')) {
    			if ($this->_controlsForm->isValid($this->getRequest()->getPost())) {
    				// get new Pad ID
    				$this->_padId 			= $this->_controlsForm->getValue('padId');
    				$this->_session->padId 	= $this->_padId;
    				// check for username param
	    			$username = $this->_controlsForm->getValue('username');
	    			$this->_session->username = $username;
					// test to see if unlock file for this pad exists
					if (file_exists($lockFile)) {
						$lockUser = file_get_contents($lockFile);
						$messages = 'Etherpad Already Locked By: '. $lockUser;
					} else {
						file_put_contents($lockFile, $username);
    					$this->_session->messages .= 'Etherpad Successfully Locked';
						$this->_redirect('/etherpad/pad/index/pad/' . $this->_padId);
					}
    			} else {
					$messages .= 'Invalid Values -- Check Messages';
    			}
    		} elseif ($this->getRequest()->getPost('clear')) {
    			if ($this->_controlsForm->isValid($this->getRequest()->getPost())) {
					if (file_exists($lockFile)) {
		    			$messages .= 'Lock on this Etherpad Successfully Cleared';
		    			unlink($lockFile);
					}
    			}
    		}
    	}
    	if ($messages) {
    		$messages = '<span class="etherpad_message">' . $messages . '</span>';
        	array_push($this->view->position_7, $messages);
    	}
        // left menu
        array_push($this->view->position_7, $this->_controlsForm);
        // contents
    	$this->view->form  = $this->_padForm;
    	// pad ID
        $this->view->padId = $this->_padId;
    }


}


