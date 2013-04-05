<?php
class Form_NotEmpty extends Zend_Form
{
    public function init()
    {
        $style = 'font: bold 12pt helvetica, sans;';
		$this->setAction('/form/not-empty')
        	 ->setMethod('post');
		$notEmpty = new Zend_Form_Element_Text('not_empty');
        $notEmpty->setLabel('Not Empty')    		
	            ->addValidator('NotEmpty');
		$required = new Zend_Form_Element_Text('required');
        $required->setLabel('Required')    		
	            ->setRequired(TRUE);
        $submit = new Zend_Form_Element_Submit('submit');           
        $submit->setLabel('Submit')
        		->setIgnore(TRUE)
        		->setRequired(FALSE)
	        	->setAttribs(array(
	        		'class' => 'form-button',
	        		'title' => 'Click here to submit form info',
	        		'id' => 'submit'));
		$submit->setDecorators(array(
				'ViewHelper',
				'Errors',
				array(array('data' => 'HtmlTag'), array('tag' => 'td')),
			    array('Label', array('tag' => 'td', 'style' => $style)),
			    array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
				));
	    $this->addElements(	array($notEmpty, $required, $submit));
		$this->addElement('hash', 'no_csrf_foo', array('salt' => 'FormDemo'));
    }
}
