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
class Zend_View_Helper_Footer {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * 
	 */
	public function footer() {
		// TODO Auto-generated Zend_View_Helper_Footer::footer() helper
		$output = "<br /><hr /><span style='font-size: 10pt;'>&copy; 2010 unlikelysource.com (GPL) &nbsp; &nbsp;<a href='/'>BACK</a></span>\n"; 
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

