<?php
// NOTE: if all you want to do is validate email
// use Zend_Validate_Email!
require "Zend/Filter/Interface.php";
require "Zend/Validate/EmailAddress.php";
class EmailFilter implements Zend_Filter_Interface
{
	public function filter ($input)
	{
		$pattern = "/[\w\.-_]+@[\w\.-_]+[\w\.-_]+/";
		if (preg_match($pattern,$input,$matches)) {
			$output = $matches[0];
			$validator = new Zend_Validate_EmailAddress();
			if (!$validator->isValid($output)) {
				$output = "";
			}			
		} else {
			$output = "";
		}
		return $output;
	}	
}
require "Zend/Filter.php";

$fc = new Zend_Filter();
$fc->addFilter(new EmailFilter());
$email = array(	'doug@unlikelysource.com <script>nasty.code</script>',
				'john.smith@company.co.uk',
				'this is not @valid.DEFINITELYNOT!');
foreach($email as $item) {
	var_dump($fc->filter($item));
}
?>
