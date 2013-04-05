<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initRoutes()
	{
		$front = Zend_Controller_Front::getInstance();
		$router = $front->getRouter();
		// add
		$routeAdd = new Zend_Controller_Router_Route(
			'add/:op1/:op2',
			array(
				'module'	 => 'ops',
				'controller' => 'calc',
				'action'     => 'add'
			)
		);
		$router->addRoute('add', $routeAdd);
		// sub
		$routeSub = new Zend_Controller_Router_Route(
			'sub/:op1/:op2',
			array(
				'module'	 => 'ops',
				'controller' => 'calc',
				'action'     => 'sub'
			)
		);
		$router->addRoute('sub', $routeSub);
		// mul
		$routeMul = new Zend_Controller_Router_Route(
				'mul/:op1/:op2',
				array(
						'module'	 => 'ops',
						'controller' => 'calc',
						'action'     => 'mul'
				)
		);
		$router->addRoute('mul', $routeMul);		
		// div
		$routeDiv = new Zend_Controller_Router_Route(
			'div/:op1/:op2',
			array(
				'module'	 => 'ops',
				'controller' => 'calc',
				'action'     => 'div'
			)
		);
		$router->addRoute('div', $routeDiv);
	}
   	
}
