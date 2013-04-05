<?php
class Code_ViewController extends Zend_Controller_Action
{

	protected $_session;
	protected $_dir;
	protected $_php;
	
	public function init()
    {
    	$filter = new Zend_Filter_PregReplace(array('match' => '/[^a-z_]/i', 'replace' => ''));
    	$this->_session = new Zend_Session_Namespace('calendar');
    	$this->_dir		= $filter->filter($this->_getParam('d'));
    	$this->_php		= $filter->filter($this->_getParam('p'));
    	$this->_dir		= ($this->_dir) ? str_replace('_', DIRECTORY_SEPARATOR, $this->_dir) : '';
		// right column ads
		$this->view->position_6   = Application_Model_RightColAds::getAds();
    }

    public function indexAction()
    {
       
    }

    public function calendarAction()
    {
    	
        $fn = $this->_makeFilename('calendar');
        $this->view->output = $this->_wrapFile($fn);
        array_push($this->view->position_7, Code_Model_CalendarMenu::getMenu());
    }

    public function etherpadAction()
    {
        $fn = $this->_makeFilename('etherpad');
        $this->view->output = $this->_wrapFile($fn);
        array_push($this->view->position_7, Code_Model_EtherpadMenu::getMenu());
    }

    public function chatAction()
    {
        $fn = $this->_makeFilename('chat');
        $this->view->output = $this->_wrapFile($fn);
        array_push($this->view->position_7, Code_Model_ChatMenu::getMenu());
    }

    public function codeAction()
    {
    
    }

    protected function _wrapFile($fn)
    {
        if (file_exists($fn)) {
   			return	  '<br />/*																			    					'
					. '<br /> *      Copyright 2012 unlikelysource.com <info@unlikelysource.com> (License: see below)			'
					. '<br /> *      																							'
					. '<p>'
					. highlight_file($fn, TRUE)
					. '</p>'
					. '<br /> *      																							'
					. '<br /> *      This program is free software; you can redistribute it and/or modify it under the 			'
					. '<br /> *      terms of the GNU General Public License as published by the Free Software Foundation; 		'
					. '<br /> *      either version 2 of the License, or (at your option) any later version.					'
					. '<br /> *      																							'
					. '<br /> *      This program is distributed in the hope that it will be useful, but WITHOUT ANY 			'
					. '<br /> *      WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A   			'
					. '<br /> *      PARTICULAR PURPOSE.  See the GNU General Public License for more details.					'
					. '<br /> *      																							'
					. '<br /> *      For a copy of the GNU General Public License write to the 									'
					. '<br /> *      Free SoftwareFoundation, Inc., 															'
					. '<br /> *		 51 Franklin Street, Fifth Floor, Boston,													'
					. '<br /> *      MA 02110-1301, USA.																		'
					. '<br /> */																			'
					. PHP_EOL;
        } else {
        	return 'File Not Found: ' . $this->_php;
        }
    }
    
    protected function _makeFilename($module)
    {
    	
    	return	   APPLICATION_PATH 
    			   . DIRECTORY_SEPARATOR 
    			   . 'modules/' 
    			   . $module 
    			   . DIRECTORY_SEPARATOR  
    			   . $this->_dir 
    			   . DIRECTORY_SEPARATOR 
    			   . $this->_php . '.php';
    }

}
