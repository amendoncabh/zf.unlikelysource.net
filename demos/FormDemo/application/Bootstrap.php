<?php 
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => dirname(__FILE__),
        ));
        return $autoloader;
    }

    /**
     * @abstract Sets up view params + Dojo
     */
    protected function _initViews()
    {
	     $this->bootstrap('layout');
	     $layout = $this->getResource('layout');
	     $view = $layout->getView();	    
	     $view->doctype('XHTML1_STRICT');
	     $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
	     $view->headTitle()->setSeparator(' - ');
	     $view->headTitle('Form Demo');      
	     $view->placeholder('date')->set(date("d M Y H:i:s",time()));
         Zend_Dojo::enableView($view);
	     $view->addHelperPath('Zend/Dojo/View/Helper/', 'Zend_Dojo_View_Helper');
	     $view->addHelperPath(APPLICATION_PATH . '/views/helpers/', 'Zend_View_Helper');
    }
    
  protected function _initMenus()
  {
      // create cache object
      $cacheOptions = $this->getOption('cache');
	  $frontendOptions = array('lifetime' => 7200, 'automatic_serialization' => true);
	  $backendOptions = array('cache_dir' => $cacheOptions['dir']);
	  $cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);

	  if (!$menu = $cache->load('menu')) {
	  	  $menu = Model_Menu::getMenu();
          $cache->save($menu, 'menu');
	  }
      Zend_Registry::set('menu', $menu);
  }
	
}
