<?php
/**
 * 
 * JQuery Demo
 * NOTE: assumes you have a MySQL database set up
 * SEE: application/configs/application.ini and products.sql
 * @author doug@unlikelysource.com
 *
 */
class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        // jquery enable the view
		ZendX_JQuery::enableView($this->view);
        // alternately, you could do the following:
        // $this->view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
        
		// this is needed in order to use the JQuery autocomplete helper
		Zend_Controller_Action_HelperBroker::addHelper(
          new ZendX_JQuery_Controller_Action_Helper_AutoComplete());
    }

    public function indexAction()
    {
        // NOTE: if the form doesn't extend ZendX_JQuery_Form
        //       you would need to execute ZendX_JQuery::enableForm($form)
        $form = new Application_Form_Sample();
        $this->view->form = $form;
    }

    public function test1Action()
    {
        // action body
    }

    public function allProductsAction()
    {
  		$products = $this->_getAllProducts();
        $output = '<table>';
		foreach ($products as $row) {
        	$output .= '<tr>';
            foreach ($row as $item) {
            	$output .= "<td>$item</td>";
            }
            $output .= '</tr>' . PHP_EOL;
        }
        $output .= '</table>';
        $this->view->products = $output;
    }

    public function randomAction()
    {
    	$list = $this->_getAllProducts();
  		$max = count($list);
  		$pick = rand(0, $max);
  		$row = $list[$pick];
  		if ($row) {
	        $output = '<table>';
			$output .= '<tr>';
	        foreach ($row as $item) {
	          	$output .= "<td>$item</td>";
	        }
	        $output .= '</tr></table>' . PHP_EOL;
  		} else {
	  		$output = 'Not Found';
  		}
  		$this->_helper->layout()->disableLayout();
        $this->view->output = $output;
    }

    // does not use AJAX -- uses a local array()
	public function actestNoAjaxAction()
    {
    	// Add Autocomplete Element
		$actest = new ZendX_JQuery_Form_Element_AutoComplete("actest", array('label' => 'Autocomplete:'));
		$actest->setJQueryParam('data', $this->_getAllSku());   
		$this->view->actest = $actest;  	
    }

    // uses AJAX
    public function actestAction()
    {
    	// Add Autocomplete Element
		$actest = new ZendX_JQuery_Form_Element_AutoComplete("actest", array('label' => 'Autocomplete:'));
		$actest->setJQueryParam('source', '/index/autocomplete');   
		$this->view->actest = $actest; 
		 	
    }
    
	public function autocompleteAction()
    {
    	$sku = (int) $this->_getParam('term');
    	$data = $this->_getLikeSku($sku);
        $this->_helper->json(array_values($data));
    }

    protected function _getLikeSku($sku)
    {
        $table = new Application_Model_Products();
        $select = $table->select()->from('products')->where('sku LIKE ?', '%' . $sku . '%');
  		$rowSet = $table->fetchAll($select);
		$data = array();
		if ($rowSet) {
		    foreach ($rowSet as $item) {
		      	$data[] = $item->sku;
		    }
		}
		return $data;
    }
    
    protected function _getAllSku() {
		$rowSet = $this->_getAllProducts();
		$data = array();
		if ($rowSet) {
		    foreach ($rowSet as $item) {
		      	$data[] = $item->sku;
		    }
		}
		return $data;
	}

    protected function _getAllProducts()
    {
        $table = new Application_Model_Products();
        $select = $table->select()->from('products');
  		return $table->fetchAll();
    }
}

