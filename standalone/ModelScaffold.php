<?php
class Eai_Tool_ModelScaffold
    extends Zend_Tool_Framework_Provider_Abstract
    implements Zend_Tool_Framework_Provider_Pretendable
{
    protected $_client = null;
    protected $_request = null;
    protected $_response = null;

    protected function _getClient()
    {
        if (!$this->_client) {
            $this->_client = $this->_registry->getClient();
        }
        return $this->_client;
    }

    protected function _getRequest()
    {
        if (!$this->_request) {
            $this->_request = $this->_registry->getRequest();
        }
        return $this->_request;

    }

    protected function _getResponse()
    {
        if (!$this->_response) {
            $this->_response = $this->_registry->getResponse();
        }
        return $this->_response;
    }

    protected function _handleDebug($method)
    {
        if ($this->_getRequest()->isDebug()) {
            syslog(LOG_DEBUG, $method . " invoked\n");
        }
    }
    
    protected function _handleVerbose($method)
    {
        if ($this->_getRequest()->isVerbose()) {
            $this->_getResponse()->appendContent($method . " invoked\n");
        }
    }
    
    public function version()
    {
        $this->_handleDebug(__METHOD__);
        $this->_handleVerbose(__METHOD__);
        $this->_getResponse()->appendContent('ModelScaffold Version 0.0.0');
    }

    public function say($name = 'Ralph')
    {
        $this->_handleDebug(__METHOD__);
        $this->_handleVerbose(__METHOD__);
        $this->_getResponse()->appendContent('Accepting a parameter: ' . $name);
    }

    public function promptForInput()
    {
        $this->_handleDebug(__METHOD__);
        $this->_handleVerbose(__METHOD__);
        if ($this->_getRequest()->isPretend()) {
            $content = "Would prompt to enter filename.\n"
                     . 'Would output "Input was: {filename}"';
            $this->_getResponse()->appendContent($content);
        } else {
            $input = $this->_getClient()->promptInteractiveInput('Enter filename');
            $filename = $input->getContent();
            $this->_getResponse()->appendContent('Input was: ' . $filename);
        }
    }

}

