<?php
class Calendar_Form_Settings extends Zend_Form
{
	public function init()
	{
		// get locale info for months, yes/no, and locales
		$locale = Zend_Registry::get('Zend_Locale');
		$months = array();
		for ($x = 1; $x <= 12; $x++) {
			$months[$x] = $locale->getTranslation($x, 'month');
		}
		$yesNo = $locale->getQuestion();
		$lang = $locale->getLanguage();
		$languageChoices = array();
		$languageChoices[$locale->__toString()] = $locale->getTranslation($lang, 'language', $lang); 
		$languageList = $locale->getTranslationList('language');
		// form elements
		$this->setMethod('POST');
		$this->setAction('/calendar/view/index');
		$changeLanguage = new Zend_Form_Element_Select('language');
		$changeLanguage->setLabel('Language')
		               ->setMultiOptions($languageList)
		               ->setAttrib('style', 'font-size: 10px')
		               ->addFilter('Alpha');
		$weekdayFormat = new Zend_Form_Element_Select('weekdayFormat');
		$weekdayFormat->setLabel('Weekday Format')
		               ->setAttrib('style', 'font-size: 10px')
					   ->addFilter('Alnum')
				  	   ->setMultiOptions(array(Zend_Date::WEEKDAY_DIGIT 	=> 'Digit (0 = Sun etc)',
				  	  						   Zend_Date::WEEKDAY_NAME		=> 'Name (i.e. Sunday)',
				  	  						   Zend_Date::WEEKDAY_NARROW	=> 'Narrow (S M T etc)',
				  	  						   Zend_Date::WEEKDAY_SHORT		=> 'Short (Sun Mon etc)')
	  	);
	  	$monthFormat = new Zend_Form_Element_Select('monthFormat');
	  	$monthFormat->setLabel('Month Format')
		            ->setAttrib('style', 'font-size: 10px')
	  				->addFilter('Alnum')
	  				->setMultiOptions(array(Zend_Date::MONTH_NAME			=> 'Name (January etc)',
	  										Zend_Date::MONTH_NAME_NARROW	=> 'Narrow (???)',
	  										Zend_Date::MONTH_NAME_SHORT		=> 'Short (Jan Feb etc)',
	  										Zend_Date::MONTH_SHORT			=> 'Single Letter (J F etc)')
	  	);
	  	$month = new Zend_Form_Element_Select('month');
	  	$month->setLabel('Month')
		      ->setAttrib('style', 'font-size: 10px')
	  		  ->setMultiOptions($months)
	  	      ->addFilter('Int');
	  	$year = new Zend_Form_Element_Text('year');
	  	$year->setLabel('Year')
		     ->setAttrib('style', 'font-size: 10px')
	  		 ->setAttrib('size', 4)
	  	     ->addFilter('Int');
	    $submit = new Zend_Form_Element_Submit('Save');
	  	$submit->setLabel('Save')
	  		   ->setIgnore(TRUE);
	  	$this->addElements(array($changeLanguage, $weekdayFormat, $monthFormat, $month, $year, $submit));
	}
}