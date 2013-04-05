<?php
// Note: if extending Zend_Form, you will need to Jquery-enable the form
class Application_Form_Sample extends ZendX_JQuery_Form
{
	public function init()
	{
		parent::init();
		$this->setAction('/index/index');
		
		// Add Element Date Picker
		$elem1 = new ZendX_JQuery_Form_Element_DatePicker("datePicker1", array("label" => "Date Picker:"));
		$elem1->setJQueryParam('dateFormat', 'dd.mm.yy');
		$this->addElement($elem1);
	}
}