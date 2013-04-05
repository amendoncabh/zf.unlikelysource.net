<?php
class Application_Plugin_Aclplugin extends Zend_Controller_Plugin_Abstract
{
	public function routeShutdown(Zend_Controller_Request_Abstract $request)
	{
		if ($request->getControllerName() == 'aclplugin') {
			$sess = new Zend_Session_Namespace("AuthDemo");	
			$acl = Zend_Registry::get('acl');
			$action = $request->getActionName();
			$role = (isset($sess->role)) ? $sess->role : 'guest';
			if (!$acl->isAllowed($sess->role, $action)) {
				// reset to '/'
				$request->setActionName('index');
				$request->setControllerName('index');
			}
		}
	}
}