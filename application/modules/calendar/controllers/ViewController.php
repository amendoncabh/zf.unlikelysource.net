<?php

class Calendar_ViewController extends Zend_Controller_Action
{

	protected $_session;
	protected $_nextYear;
	protected $_nextMonth;
	protected $_locale;
	protected $_form;
			
    public function init()
    {
    	$this->_session = new Zend_Session_Namespace('calendar');
    	if (!isset($this->_session->monthFormat)) {
    		$this->_session->monthFormat = Zend_Date::MONTH_NAME_SHORT;
    	}
    	if (!isset($this->_session->weekdayFormat)) {
    		$this->_session->weekdayFormat = Zend_Date::WEEKDAY_SHORT;
    	}
    	if (!isset($this->_session->locale)) {
    		$this->_locale = new Zend_Locale('auto');
    		$this->_session->locale = $this->_locale->__toString();
    	} else {
    		$this->_locale = new Zend_Locale($this->_session->locale);
    	}
    	$this->_nextYear  	= (int) $this->_getParam('y');
    	$this->_nextMonth 	= (int) $this->_getParam('m');
    	Zend_Registry::set('Zend_Locale', $this->_locale);
		// right column ads
		$this->view->position_6   = Application_Model_RightColAds::getAds();
    }

    public function indexAction()
    {
    	$form = new Calendar_Form_YearSettings();
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		if ($form->isValid($request->getPost())) {
    			$this->_session->weekdayFormat 	= $form->getValue('weekdayFormat');
    			$this->_session->monthFormat 	= $form->getValue('monthFormat');
    			$this->_session->locale			= $form->getValue('locale');
    			$this->_session->year			= $form->getValue('year');
    			$this->_locale->setLocale($this->_session->locale);
    			Zend_Registry::set('Zend_Locale', $this->_locale);
    			$form = new Calendar_Form_YearSettings();
    		}
    	} else {
    		$this->_setYear();
    	}
    	$langCode = $this->_locale->getLanguage();
    	array_push($this->view->position_7, $this->_locale->getTranslation($langCode, 'language', $langCode));
    	array_push($this->view->position_7, $form);
    }

    public function yearAction()
    {
    	$this->_form = new Calendar_Form_YearSettings();
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		if ($this->_form->isValid($request->getPost())) {
    			$this->_session->weekdayFormat 	= $this->_form->getValue('weekdayFormat');
    			$this->_session->monthFormat 	= $this->_form->getValue('monthFormat');
    			$this->_session->locale			= $this->_form->getValue('locale');
    			$this->_session->year			= $this->_form->getValue('year');
    			$this->_locale->setLocale($this->_session->locale);
    			Zend_Registry::set('Zend_Locale', $this->_locale);
    			$this->_form = new Calendar_Form_YearSettings();
    		}
    	} else {
    		$this->_setYear();
    	}
    }

    public function monthAction()
    {
    	$this->_form = new Calendar_Form_MonthSettings();
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		if ($this->_form->isValid($request->getPost())) {
    			$this->_session->weekdayFormat 	= $this->_form->getValue('weekdayFormat');
    			$this->_session->monthFormat 	= $this->_form->getValue('monthFormat');
    			$this->_session->locale			= $this->_form->getValue('locale');
    			$this->_session->year			= $this->_form->getValue('year');
    			$this->_session->month			= $this->_form->getValue('month');
    			$this->_locale->setLocale($this->_session->locale);
    			Zend_Registry::set('Zend_Locale', $this->_locale);
    			$this->_form = new Calendar_Form_MonthSettings();
    		}
    	} else {
    		$this->_setMonth();
    		$this->_setYear();
    	}
	}

	public function postDispatch()
	{
    	$langCode = $this->_locale->getLanguage();
    	array_push($this->view->position_7, $this->_locale->getTranslation($langCode, 'language', $langCode));
    	array_push($this->view->position_7, $this->_form);
	}
	
    protected function _setYear()
    {
    	if ($this->_nextYear) {
    		$this->_session->year = $this->_nextYear;
    	}
    }

    protected function _setMonth()
    {
    	if ($this->_nextMonth) {
    		$this->_session->month = $this->_nextMonth;
    	}
    }
    
}
