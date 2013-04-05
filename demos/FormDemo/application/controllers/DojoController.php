<?php

class DojoController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {
		$msg = "";
		$form = new Zend_Form();
		$date = new Zend_Dojo_Form_Element_DateTextBox('date');
		$date->setLabel('Date')
		     ->setAttrib('dojoType','dijit.form.DateTextBox')
		     ->setDatePattern('yyyy-MM-dd')
		     ->addFilter('StringTrim')
		     ->addFilter('StripTags');
		$text = new Zend_Dojo_Form_Element_Editor('editor', 'content', array(
//														'plugins'            => array('undo', '|', 'bold', 'italic'),
														'editActionInterval' => 2,
														'focusOnLoad'        => true,
														'height'             => '250px',
														'inheritWidth'       => true,
														'styleSheets'        => array('/js/custom/editor.css')
		));
		$text->setLabel('Rich Text Editor')
			 ->addFilter('HtmlEntities');
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setRequired(FALSE)
			   ->setIgnore(TRUE)
			   ->setLabel('Submit');
		$form->addElements(array($date,$text,$submit));
		$request = $this->getRequest(); 
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				$msg = "<br />SUCCESSFUL SUBMIT\n";
			} else {
				$form->populate($request->getParams());
				$msg = "<br />TRY LATER\n";
			}
		}
		// NOTE: view is Dojo enabled in Bootstrap.php
		$this->view->form = $form;
		$this->view->msg = $msg;
    }


}

