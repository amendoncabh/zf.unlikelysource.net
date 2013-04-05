<?php
/**
 *
 * @author ed
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * Users helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_Users {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * 
	 */
	public function users($list) {
		$output = "<tr><th class='ht'>Name</th><th class='ht'>Role</th></tr>\n";
		$class = "";
   		foreach($list as $name => $role) {
 			$class = ($name == "guest") ? "at" : substr($role,0,1) . "t";
   			$output .= "<tr><th class='" . $class . "'>" . $name . "</th><td>" . $role . "</td></tr>\n";
   		}
		return $output;
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

