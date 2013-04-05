<?php
/**
 * 
 * Demonstrates a custom filter
 * NOTE: you could do the same thing with a PregReplace filter
 *       Look at the UserInfo form for usage
 * @author db
 *
 */
class Custom_Filter_Ssn implements Zend_Filter_Interface
{
	public function filter($value)
	{
		$result = FALSE;
		if ($value) {
			$matches = array();
			$pattern = '/^\d\d\d-\d\d\d-\d\d\d\d$/';
			preg_match($pattern, $value, $matches);
			if (isset($matches)) {
				$result = $matches[0];
			}
		}
		return $result;
	}
}