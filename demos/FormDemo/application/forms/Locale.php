<?php

/**
 * This form demonstrates using public variables, methods, and drop down lists  
 *
 * @uses       Zend_Form
 * @subpackage Form
 */
class Form_Locale extends Zend_Form
{

	public $date;
	public $language;
	public $yesNo;
	public $submit;
	public $dateSubForm;
	
	/**
	 * 
	 * @param array $languages
	 * @param string $label
	 */
    public function __construct($languages, $yesNoList)
    {
    	parent::__construct();
		// This sets the "action" attribute on the <form> tag
		$this->setAction('/locale/index');
		
    	// Set the method for the display form to POST
        $this->setMethod('post');

		// language list
		$this->language = new Zend_Form_Element_Select('language');
		$this->language->setLabel('Language')
					   ->addDecorator('Description', '')
					   ->setMultiOptions($languages)
					   ->addFilter('Alpha');

		$yesNoOption = array('yes' => $yesNoList['yes'], 'no' => $yesNoList['no']);
		$this->yesNo = new Zend_Form_Element_Radio('yesNo');
		$this->yesNo->setLabel(ucfirst($yesNoList['yes']) . ' | ' . ucfirst($yesNoList['no']))
					->setMultiOptions($yesNoOption)
					->addFilter('Alpha');
				
		$this->date = new Zend_Form_Element_Text('date');
		$this->date->setLabel('Date');
		
        // Add the submit button
        $this->submit = new Zend_Form_Element_Submit('submit');
        $this->submit->setLabel('Switch');
        
        $this->addElements(array($this->language, $this->yesNo));
    }
    
    /**
     * 
     * @param int $m = month
     * @return Zend_Form_Subform $dateSubForm
     */
    public function unfoldDate($m = 0)
    {
    	if (!$m) {
    		$m = date('m');
    	}
    }
}
