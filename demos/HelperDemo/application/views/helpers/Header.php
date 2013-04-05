<?php
/**
 *
 * @author ed
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * Header helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_Header {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * 
	 */
	public function header() {
		$output = "<br /><span style='font-size: 16pt; font-weight: bold;'>Action and View Helper Demo</span><hr />\n"; 
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

