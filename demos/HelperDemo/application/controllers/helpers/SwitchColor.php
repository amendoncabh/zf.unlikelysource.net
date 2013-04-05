<?php
/**
 *
 * @author ed
 * @version 
 */
//require_once 'Zend/Loader/PluginLoader.php';
//require_once 'Zend/Controller/Action/Helper/Abstract.php';

/**
 * FruitColorList Action Helper 
 * 
 * @uses actionHelper Zend_Controller_Action_Helper
 */
class Zend_Controller_Action_Helper_SwitchColor extends Zend_Controller_Action_Helper_Abstract {
	/**
	 * @var Zend_Loader_PluginLoader
	 */
	public $pluginLoader;
	
	/**
	 * Constructor: initialize plugin loader
	 * 
	 * @return void
	 */
	public function __construct() {
		// TODO Auto-generated Constructor
		$this->pluginLoader = new Zend_Loader_PluginLoader ();
	}
	
	/**
	 * Strategy pattern: call helper as broker method
	 * @param $color = selected color
	 * @param $obj->list = array of [fruit][x] => color
	 * @return $obj->list array of [fruit][x] => color where selected color is changed to black
	 * @return = TRUE if match for $color was found
	 */
	public function direct($color,$obj) {
		$match = FALSE;
		$x = 1;
		foreach ($obj->list['color'] as $item) {
			if ($item == $color) {
				$obj->list['color'][$x] = 'black';
				$match = TRUE;
				break;
			}
			$x++;
		}
		return $match;
	}
}

