<?php
class Form_DecoratorTest extends Zend_Form
{
    public function __construct()
    {
        parent::__construct();
		$this->setAction('/form/decorator-test')
        	 ->setMethod('post');
		$comments1 = new Zend_Form_Element_Textarea('comments1');
        $comments1->setLabel('Prepend')
        		  ->addDecorator('Label', array('tag' => 'div', 'class' => 'prepend'))
        		  ->setDescription('This is an example of the description decorator with PREPEND placement')
        		  ->addDecorator('Description', 
        		 				  array('placement' => 'prepend', 
         							    'separator' => '<br /><hr />', 
         							    'tag' 		=> 'div',
        		 				  		'class'		=> 'description'))    		
         		  ->setAttribs(array('title' => 'Enter Comments',
        						   	 'rows'  => '4',
        						   	 'cols'  => '40'))
	              ->setRequired(true)
	              ->addFilter('StripTags')
	              ->addFilter('StringTrim')
	              ->addValidator('StringLength',array(1, 255));
		$comments2 = new Zend_Form_Element_Textarea('comments2');
        $comments2->setLabel('Append')
        		  ->addDecorator('Label', array('tag' => 'div', 'class' => 'append'))
        		  ->setDescription('This is an example of the description decorator with APPEND placement') 
        		  ->addDecorator('Description', 
        		 				  array('placement' => 'append', 
         							    'separator' => '<br /><hr />', 
         							    'tag'		=> 'div',
        		 				  		'class'		=> 'description'))    		
         		 ->setAttribs(array('title' => 'Enter Comments',
        						   	'rows' 	=> '4',
        						   	'cols' 	=> '40'))
	             ->setRequired(true)
	             ->addFilter('StripTags')
	             ->addFilter('StringTrim')
	             ->addValidator('StringLength',array(1, 255));
		$submit = new Zend_Form_Element_Submit('submit');           
        $submit->setLabel('Submit')
        		->setIgnore(TRUE)
        		->setRequired(FALSE)
	        	->setAttribs(array(
	        		'class' => 'form-button',
	        		'title' => 'Click here to submit form info',
	        		'id' 	=> 'submit'));
	    $this->addElements(array($comments1, $comments2, $submit));
		$this->addElement('hash', 'no_csrf_foo', array('salt' => 'FormDemo'));
    }
}
