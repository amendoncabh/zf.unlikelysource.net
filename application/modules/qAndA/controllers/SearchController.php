<?php

class QAndA_SearchController extends Zend_Controller_Action
{

    public $alpha  = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function buildAction()
    {
        $oldKey = '';
        $answer = '';
        $searchKey = 0;
        $options = Zend_Registry::get('options');
        $index = Zend_Search_Lucene::create($options['search']['dir']);
        if (file_exists($this->_config['q_and_a']['file'])) {
        	$rawArray = file($this->_config['q_and_a']['file']);
        	$this->_qAndA = array();
        	foreach ($rawArray as $item) {
        		if (stripos($item, 'Q:') === 0) {
        			$question = trim(str_replace(array("\n",'Q:'), '', $item));
        			if ($question != $oldQues) {
        			    if ($answer) {
        			        $document = new Zend_Search_Lucene_Document();
        			        // unique key
        			        $document->addField(new Zend_Search_Lucene_Field('key', 
						        			        						 $this->buildSearchKey($searchKey++), 
						        			        						 'utf-8', 
						        			        						 TRUE, 
						        			        						 FALSE, 
						        			        						 FALSE,
        			        												 FALSE));
        			        // question
        			        $document->addField(new Zend_Search_Lucene_Field('question', 
						        			        						 $oldQues, 
						        			        						 'utf-8', 
						        			        						 TRUE, 
						        			        						 TRUE, 
						        			        						 TRUE,
        			        												 FALSE));
        			        // answer
        			        $document->addField(new Zend_Search_Lucene_Field('answer', 
						        			        						 $answer, 
						        			        						 'utf-8', 
						        			        						 TRUE, 
						        			        						 TRUE, 
						        			        						 TRUE,
        			        												 FALSE));
        			       	$index->addDocument($document);
        			        $oldQues = $question;
        			    	$answer = '';
        			    }
        			}
        		} else {
        			$answer .= $item;
        		}
        	}
        	$this->_cache->save('qAndA');
        	unset($rawArray);
        }        
    }

	protected function buildSearchKey($searchKey)
	{
	    $returnKey = '';
	    $stringKey = sprintf('%012d', $searchKey);
	    $stringLen = strlen($stringKey);
	    for ($i = 0; $i < $stringLen; $i++) {
	    	$returnKey .= $this->alpha[(int) substr($stringKey, $i, 1)];    
	    }
	    return $returnKey;
	}
    
}
