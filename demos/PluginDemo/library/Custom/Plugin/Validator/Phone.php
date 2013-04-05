<?php
/**
 * Validates phone numbers
 */
class Custom_Plugin_Validator_Phone implements Zend_Validate_Interface
{
	protected $_messageTemplates = array(
			'value' => 'Phone number %value% does not match [+nnnn] nnn-nnn-nnnn format'
	);
	
	public function isValid($value) 
	{
		$valid = FALSE;
		// check to see if any value
		if (isset($value) && is_string($value) && strlen($value) > 0) {
			if (preg_match('/^[+]?(\d{1,4}\s)?\d{3}-\d{3}-\d{4}$/', $value)) {
				$valid = TRUE;
			} else {
				$this->_messageTemplates['value'] = str_replace('%value%', 
																htmlspecialchars($value), 
																$this->_messageTemplates['value']);
			}
		} else {
			$this->_messageTemplates['value'] = 'Empty string';
		}
		return $valid;
	}
	
	public function getMessages()
	{
		return $this->_messageTemplates;
	} 

}
