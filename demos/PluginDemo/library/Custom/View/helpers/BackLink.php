<?php
/**
 *
 * @author ted
 * @version 
 */
//require_once 'Zend/View/Interface.php';

/**
 * BackLink helper
 *
 * @uses viewHelper Custom_View_Helper
 */
class Custom_View_Helper_BackLink {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * 
	 */
	public function backLink() {
		// TODO Auto-generated Custom_View_Helper_BackLink::backLink() helper 
		return '<a href="/"><< BACK</a>';
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

