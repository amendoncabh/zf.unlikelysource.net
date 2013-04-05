<?php
/**
 *
 * @author ed
 * @version 
 */
//require_once 'Zend/View/Interface.php';

/**
 * Footer helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Custom_View_Helper_Url {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * 
	 */
	public function url($path) {
		// TODO Auto-generated Zend_View_Helper_Footer::footer() helper
		$output = "http://www.unlikelysource.com/$path"; 
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

