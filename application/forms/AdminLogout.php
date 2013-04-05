<?php
class Application_Form_AdminLogout extends Zend_Form
{
    public function init()
    {
		$this->setAction('/login/logout')
        	->setMethod('post');
        $submit = new Zend_Form_Element_Submit('logout');
        $submit->setLabel('Logout')
        		->setAttrib('id', 'logoutbutton');
        $this->addElement($submit);
    }
}
