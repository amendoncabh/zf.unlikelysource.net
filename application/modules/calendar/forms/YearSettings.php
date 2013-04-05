<?php
class Calendar_Form_YearSettings extends Zend_Form
{
	public function init()
	{
		// initial form elements
		$this->setMethod('POST');
		// get locale info for months, yes/no, and locales
		// get locale info for months, yes/no, and locales
		$locale = Zend_Registry::get('Zend_Locale');
		$yesNo = $locale->getQuestion();
		$langList = $locale->getTranslationList('language');
		$countryList = $locale->getTranslationList('territory', NULL, 2);
		$localeList = Zend_Locale::getLocaleList();
		foreach ($localeList as $key => $value) {
			list($langCode, $language, $countryCode, $country) = $this->_explode('_', $key, $langList, $countryList);
			if ($langCode) {
				$localeChoices[$key] = $key . ':' . $language . ':' . substr($country, 0, 12);
			}
		}
		// form elements
		$changeLocale = new Zend_Form_Element_Select('locale');
		$changeLocale->setLabel('Language')
		             ->setMultiOptions($localeChoices)
		             ->setAttrib('style', 'font-size: 10px')
		             ->addFilter('PregReplace', array('match' => '/[^a-z_]/i', 'replace' => ''));
		$weekdayFormat = new Zend_Form_Element_Select('weekdayFormat');
		$weekdayFormat->setLabel('Weekday Format')
		               ->setAttrib('style', 'font-size: 10px')
					   ->addFilter('Alnum')
				  	  ->setMultiOptions(array(Zend_Date::WEEKDAY_DIGIT 	=> 'Digit (0 = Sun etc)',
				  	  						  Zend_Date::WEEKDAY_NAME	=> 'Name (i.e. Sunday)',
				  	  						  Zend_Date::WEEKDAY_NARROW	=> 'Narrow (S M T etc)',
				  	  						  Zend_Date::WEEKDAY_SHORT	=> 'Short (Sun Mon etc)')
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
	  	$year = new Zend_Form_Element_Text('year');
	  	$year->setLabel('Year')
		     ->setAttrib('style', 'font-size: 10px')
	  		 ->setAttrib('size', 4)
	  	     ->addFilter('Int');
	    $submit = new Zend_Form_Element_Submit('Save');
	  	$submit->setLabel('Save')
	  		   ->setIgnore(TRUE);
	  	$this->addElements(array($changeLocale, $weekdayFormat, $monthFormat, $year, $submit));
	}
	
	protected function _explode($delim, $key, $langList, $countryList)
	{
		preg_match('/^(\w+)_(\w+)$/', $key, $matches);
		$result 		= array();
		$langCode 		= (isset($matches[1])) ? $matches[1] : '';
		$countryCode 	= (isset($matches[2])) ? $matches[2] : '';
		$result[] 		= $langCode;
		$result[] 		= (isset($langList[$langCode])) ? $langList[$langCode] : '';
		$result[] 		= ($countryCode) ? $countryCode : '';
		$result[] 		= ($countryCode && isset($countryList[$countryCode])) ? $countryList[$countryCode] : '';
		return $result;
	}
}