<?php
/**
 *
 * @author ed
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * FruitColorForm helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_FruitColorForm {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 * @param $list = array of [fruit][x] => color
	 * 
	 */
	public function fruitColorForm($list) {
		$x = 1;
		$return = '<form method="post">';
		$return .= '<table><form method="post">';
		foreach ($list['item'] as $item) {
			$color = isset($list['color'][$x]) ? $list['color'][$x] : 'black';
			$return .= '<tr>';
			$return .= '<th bgcolor="' . $color . '"><span style="color:white;">' . $item . '</span></th>';
			$return .= '<td><input type="radio" name="color" value="' . $color . '" /></td>';
			$return .= '</tr>' . "\n";
			$x++;
		}
		$return .= '<tr>';
		$return .= '<td><input type="submit" name="submit" value="Switch" /></td>';
		$return .= '<td>&nbsp;</td>';
		$return .= '</tr>' . "\n";
		$return .= '</table></form>' . "\n";
		return $return;
			}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}

