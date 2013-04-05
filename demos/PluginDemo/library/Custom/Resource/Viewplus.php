<?php
class Custom_Resource_Viewplus extends Zend_Application_Resource_ResourceAbstract
{
	public function init()
	{
		$bootstrap = $this->getBootstrap();
        $bootstrap->bootstrap('View');
        $view = $bootstrap->getResource('View');
        $options = $this->getOptions();
        // add a view variable "viewplus"
        $value = sprintf('<%s>%s</%s>', $options['tag'], $options['text'], $options['tag']);
        $view->viewplus = $value;
        return $value;
	}
}