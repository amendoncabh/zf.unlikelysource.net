<?php
/**
 * Products -- see application/configs/products.sql
 * 
 * @author ted
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';
class Application_Model_Products extends Zend_Db_Table_Abstract
{
    /**
     * The default table name 
     */
    protected $_name = 'products';
    protected $_primary = 'sku';
    
}
