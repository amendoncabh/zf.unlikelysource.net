<?php
/**
 *
 * @author fred
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * HeadTitle helper
 *
 * @uses viewHelper Foo_View_Helper
 */
class Foo_View_Helper_HeadTitle {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function headTitle($title) {
		// TODO Auto-generated Foo_View_Helper_HeadTitle::headTitle() helper 
		return "<title>FOO $title</title>";
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
