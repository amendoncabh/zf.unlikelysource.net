<?php
/**
 *
 * @author ed
 * @version 
 */
require_once 'Zend/Loader/PluginLoader.php';
require_once 'Zend/Controller/Action/Helper/Abstract.php';

/**
 * FruitColorList Action Helper 
 * 
 * @uses actionHelper Zend_Controller_Action_Helper
 */
class Zend_Controller_Action_Helper_FruitColorList extends Zend_Controller_Action_Helper_Abstract {
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
	 * @return array of [fruit][x] => color
	 */
	public function direct() {
		$options = Zend_Registry::get('options');
		$config = $options['fruit'];
		$list = $config->toArray();
		return $list;
	}
}

