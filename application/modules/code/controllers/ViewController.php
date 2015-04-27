<?php

class Code_ViewController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $options = Zend_Registry::get('options');
        $fileDir = $options['code']['dir'] . '/';
        $list = glob($fileDir . '*.php');
        $filename = strip_tags($this->_getParam('fn'));
        $filename = ($filename) ?  . $fileDir . $filename . '';
        if ($filename && file_exists($filename) && in_array($filename, $list)) {
            $this->view->showFile = TRUE;
        } else {
            $this->view->showFile = FALSE;
        }
        $this->view->filename = $filename;
        $this->view->list = $list;
    }


}

