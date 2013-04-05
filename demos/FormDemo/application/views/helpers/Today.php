<?php
/**
 *
 * @author zend
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * Today helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_Today {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function today() {
		// TODO Auto-generated Zend_View_Helper_Today::today() helper 
		return date("d M Y H:i:s",time());
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
