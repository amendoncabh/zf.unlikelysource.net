<?php

class QAndA_IndexController extends Zend_Controller_Action
{

    protected $_config = null;
	protected $_cache = null;
	protected $_qAndA = array();
	
    public function init()
    {
    	$this->_config = Zend_Registry::get('options');
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
        	array_push($this->view->position_7, 
        			   QAndA_Model_MainMenu::getAdminMenu(), 
        			   new Application_Form_AdminLogout());
        }       
       	// set up cache
		$this->_cache = Application_Model_Cache::getCache();
		// check for q-and-a array
		$this->_qAndA = $this->_cache->load('qAndA');
		if (count($this->_qAndA) > 0) {
		    if (file_exists($this->_config['q_and_a']['file'])) {
		        $rawArray = file($this->_config['q_and_a']['file']);
		        $this->_qAndA = array();
		        foreach ($rawArray as $item) {
		            if (stripos($item, 'Q:') === 0) {
		                $key = trim(str_replace(array("\n",'Q:'), '', $item));
		            } else {
		                $this->_qAndA[$key][] = $item;
		            }
		        }
		        $this->_cache->save('qAndA');
		        unset($rawArray);
		    }
		}
    }

    public function indexAction()
    {
		$page = $this->_getParam('page');
		$page = (isset($page)) ? (int) $page : 1;
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array(array_keys($this->_qAndA)));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(20);
		Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('_pagination.phtml');
        $this->view->paginator = $paginator;
        $this->view->qAndA = $this->_qAndA;
    }

    public function answerAction()
    {
        $this->view->qAndA = $this->_qAndA;
        $question = urldecode($this->_getParam('ques'));
        if (isset($question) && $question) {
            $this->view->ques = $question;
        } else {
            $this->view->ques = FALSE;
        }
    }
    
    public function searchAction()
    {
        $form = new QAndA_Form_Search();
        $request = $this->getRequest();
        if ($request->isPost()) {
        	if ($form->isValid()) {
        		
        	}
        }
        $this->view->form = $form;
    }

    public function buildAction()
    {
        // backup any existing index
        // create new one
    }

    /**
     * 
     * Adds item to search index database
     */
    public function addAction()
    {
    	$form = new QAndA_Form_Add();
        $request = $this->getRequest();
        if ($request->isPost()) {
        	if ($form->isValid()) {
        		$index = Zend_Search_Lucene::open($this->_config['search']['dir']);
        		$document = new Zend_Search_Lucene_Document();
        		$document->addField(Zend_Search_Lucene_Field::text('title', $form->getValue('title')));
        		$document->addField(Zend_Search_Lucene_Field::text('text', $form->getValue('text')));
        		$index->addDocument($document);
        	}
        }
        $this->view->form = $form;
    }

}
