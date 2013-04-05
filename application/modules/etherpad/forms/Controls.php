<?php
class Etherpad_Form_Controls extends Zend_Form
{
	public function init()
	{
		$this->setMethod('POST');
		$this->setAttrib('id', 'contact-form');
		$this->setAction('/etherpad/pad/lock');
		// pad controls:
		$lock 	= new Zend_Form_Element_Submit('lock');
		$lock 	->setLabel('Lock')
				->addDecorator('HtmlTag', array('tag' => 'td'))
				->setDescription('Lock pad . Enter text . Submit')
				->addDecorator('Description', array('placement' => 'PREPEND'))
				->setAttrib('title', 'Lock pad before making changes by clicking here')
				->setAttrib('class', 'button-title');
		$clear  = new Zend_Form_Element_Submit('clear');
		$clear 	->setLabel('Clear')
				->addDecorator('HtmlTag', array('tag' => 'td'))
				->setAttrib('title', 'Click to clear lock on this pad')
			   	->setAttrib('class', 'button-title');
		$padId 	= new Zend_Form_Element_Text('padId');
		$padId	->setLabel('Pad Name')
				->setAttrib('size', 8)
				->setAttrib('title', 'Pad name must be 4 to 8 characters, alpha numeric')
				->addValidator('Alnum')
				->addValidator('StringLength', FALSE, array(4,8))
				->addFilter('StringTrim')
				->addFilter('StripTags')
				->setRequired(TRUE);
		$username = new Zend_Form_Element_Text('username');
		$username->addFilter('StripTags')
				 ->setLabel('User Name')
				 ->setAttrib('size', 16)
				 ->setAttrib('title', 'Username must be 4 to 16 characters, alpha numeric')
				 ->addFilter('StringTrim')
				 ->addFilter('PregReplace', array('pattern' => '/[^\w]/', 'match' => '_'))
				 ->addValidator('StringLength', NULL, array(1, 16))
				 ->setRequired(TRUE);
		$this->addElements(array($padId, $username));
		$this->addDisplayGroup(array($lock, $clear), 'buttons', array('disableLoadDefaultDecorators' => true));
		$displayGroup = $this->getDisplayGroup('buttons');
		$displayGroup->addDecorator('FormElements')
					 ->addDecorator(array('row' => 'HtmlTag'), array('tag' => 'tr'))
					 ->addDecorator(array('tbl' => 'HtmlTag'), array('tag' => 'table'));
	}
}