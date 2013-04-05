<?php

class LocaleController extends Zend_Controller_Action
{

	public $defaultLang = 'en_US';
	
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		$message = '';
    	$sess = new Zend_Session_Namespace('demo');
    	if (!isset($sess->language)) {
	        $locale = new Zend_Locale($this->defaultLang);
			$sess->language = $locale->getLanguage();
    	}
        $request = $this->getRequest();
	    $yesNo = $request->getParam('yesNo'); 
        $form = $this->_buildForm($sess, $yesNo, $message);
        if ($request->isPost()) {
        	if ($form->isValid($request->getPost())) {
        		$newLang = $form->getValue('language');
        		if ($newLang != $sess->language && $newLang) {
        			$sess->language = $newLang;
        			$form = $this->_buildForm($sess, $yesNo, $message);
        		}
        	}
        }
    	$message .= (isset($sess->message)) ? $sess->message : '';
    	$sess->message = '';
        $this->view->message = $message;
        $this->view->form = $form;
        $this->view->language = $sess->language;
    }

	protected function _buildForm($sess, $yesNo = 'no', &$message)
	{
		$message = '';
		$language = (isset($sess->language)) ? $sess->language : $this->defaultLang;
		try {
	        $locale = new Zend_Locale($language);
	        $languages = $locale->getTranslationList('language',$language);
	        $languages = array_merge(array('0' => '--Choose--'), $languages);
	        $form = new Form_Locale($languages, $locale->getQuestion($locale->getLanguage()));
	        if (isset($yesNo) && $yesNo == 'yes') {
	        	$form->addElement($form->date);
	        }
	        $form->addElement($form->submit);
		} catch (Zend_Exception $e) {
			$sess->language = $this->defaultLang;
			$sess->message = 'Sorry!  Not Supported.';
			$this->_redirect('/locale');
		}
        return $form;
	}
}

