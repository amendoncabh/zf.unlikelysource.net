<?php
/**
 * Validates phone numbers
 */
class Custom_Plugin_Validator_Ip implements Zend_Validate_Interface
{
	protected $_messageTemplates = array();
	protected $_generic	= 'IP address %value% does not match nnn.nnn.nnn.nnn format';
	protected $_count	= 'IP address must contain 4 nodes';
	protected $_private = 'IP address cannot be private (10.x.x.x, 172.16.x.x or 192.168.x.x)';
	protected $_x255 	= '255 reserved for broadcast';
	protected $_x2high 	= 'Element exceeds 254';
	protected $_x2low	= 'Element must be at least 0';
	protected $_local	= 'Warning: this IP address is reserved for loopback';
	protected $_empty 	= 'Empty string';
		
	public function isValid($value) 
	{
		$valid = TRUE;
		$message = '';
		// check to see if any value
		if (isset($value) && is_string($value) && strlen($value) > 0) {
			$elements = explode('.', $value);
			if (count($elements) != 4) {
				$this->_messageTemplates[] = $this->_count;
				$valid = FALSE;
			} else {
				if (($elements[0] == 10)
					|| ($elements[0] == 172 &&  $elements[1] == 16)
					|| ($elements[0] == 192 &&  $elements[1] == 168)) 
				{
					$this->_messageTemplates[] = $this->_private;
					$valid = FALSE;
				}
				if ($elements[0] == 127) {
					$this->_messageTemplates[] = $this->_local;
					$valid = FALSE;
				}
				for ($i = 0; $i < 4; $i++) {
					$address = $elements[$i];
					switch (true) {
						case $address < 0 :
							$this->_messageTemplates[] = $this->_x2low;
							$valid = FALSE;
							break;
						case $address == 255:
							$this->_messageTemplates[] = $this->_x255;
							$valid = FALSE;
							break;
						case $address > 255:
							$this->_messageTemplates[] = $this->_x2high;
							$valid = FALSE;
							break;
					} 
				}
			}
			if (!$valid) {
				$this->_messageTemplates[] = str_replace('%value%', 
														 htmlspecialchars($value), 
														 $this->_generic);
			}
		} else {
			$this->_messageTemplates[] = $this->_empty;
		}
		return $valid;
	}
	
	public function getMessages()
	{
		return $this->_messageTemplates;
	} 

}
