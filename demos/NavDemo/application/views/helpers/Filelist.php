<?php
/**
 *
 * @author ted
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * Filelist helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_Filelist {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * Returns a <ul><li> list of files for this file color set
	 * @param string $title
	 * @param Array $fileSet = array('color' => array(list of files))
	 * @return string HTML
	 */
	public function filelist($title, $fileSet) {
		$output = '';
		$output .= "<h1>" . $title . "</h1>\n";
		foreach($fileSet as $color => $list) {
			$output .= "<p>\n"; 
			$output .= "<h3 style='background-color:" . $color . ";color:white;'>File Set</h3>\n";
			$output .= "<ul>\n";
			foreach($list as $file) {
				if ($file == 'index.html') {
					$output .= "<li><a href='/file/access/color/" . $color . "'>" . $file . "</a></li>\n";
				} else {
					$output .= "<li>" . $file . "</li>\n";
				} 
			}
			$output .= "</ul>\n";
			$output .= "<p>\n"; 
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

