<?php
include 'Zend/View.php';
$view = new Zend_View();
$view->a = 'Larry';
$view->b = 'Curly';
$view->c = 'Moe';
$values = array('d' => 'Larry',
				'e' => 'Curly',
				'f' => 'Moe');
$view->assign($values);
$obj = new stdClass();
$obj->g = 'Larry';
$obj->h = 'Curly';
$obj->i = 'Moe';
$view->obj = $obj;
$view->setScriptPath('.');
$view->bg = '#DDEEFF';
echo $view->render('zend_view_render.phtml');
?>
