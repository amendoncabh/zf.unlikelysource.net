<?php
class Chat_Form_Messages extends Zend_Form
{
	public function init()
	{
		$this->setMethod('POST');
		$this->setAction('/chat/room/delete');
		$messages = new Zend_Form_Element_MultiCheckbox('messages');
		$delete = new Zend_Form_Element_Submit('delete');
		$delete->setLabel('Delete')
			   ->setAttrib('title', 'Click to delete selected messages')
			   ->setAttrib('class', 'button-title');
		$clear = new Zend_Form_Element_Submit('clear');
		$clear ->setLabel('Clear')
			   ->setAttrib('title', 'Click to clear all messages')
			   ->setAttrib('class', 'button-title');
		$this->addElements(array($messages, $delete, $clear));
	}
}