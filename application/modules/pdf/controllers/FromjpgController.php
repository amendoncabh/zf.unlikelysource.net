<?php
// TO DO: figure out why this is needed!
//require_once dirname(__FILE__) . '/../forms/Uploadjpg.php';

class Pdf_FromjpgController extends Zend_Controller_Action
{

    protected $_options = null;
	protected $_session = null;
	
    public function init()
    {
    	// bootstrap options
    	$this->_options = Zend_Registry::get('options');
    	// session
    	$this->_session = new Zend_Session_Namespace('pdf');
    }

    public function indexAction()
    {
    	// form processing
        $form = new Pdf_Form_Uploadjpg();
        $request = $this->getRequest();
        if ($request->isPost()) {
        	if ($form->isValid($request->getPost())) {
        		$userFileName = $form->upload_file->getFilename();
        		$newFileName  = $this->_options['pdf']['dir'] . DIRECTORY_SEPARATOR . basename($userFileName);
        		$form->upload_file->addFilter('Rename', $newFileName);
        		$form->upload_file->receive();
        	}
        }
        $this->view->form = $form;
    }

    protected function _moveFile($fn)
    {
    	// erase files older than 10 minutes
    	// pull php sessid
    	// move files into $options['php']['dir']
    	// prefix filenames with php sessid
    }

    public function generateAction()
    {
        // create pdf object
    	// pull php sessid
    	// append files from $options['php']['dir']
    	// pass pdf to view 
    	// pass response object to view
    }

}



