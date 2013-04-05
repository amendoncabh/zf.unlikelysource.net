<?php
/**
 *
 * @author zed
 * @version 
 */
//require_once 'Zend/View/Interface.php';
/**
 * LeftMenu helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class QAndA_View_Helper_LeftMenu
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */
    public function leftMenu ($menu)
    {
        $output = '<ul';
        $output .= ($menu['class0']) ? ' class="' . $menu['class0'] . '"' : '';
        $output .= '>' . PHP_EOL;
        foreach ($menu['elements'] as $element) {
        	$output .= '<li';
        	$output .= (isset($element['class1'])) ? ' class="' . $element['class1'] . '"' : '';
        	$output .= '>';
        	$output .= '<a href="' . $element['uri'] . '"';
        	$output .= (isset($element['class2'])) ? ' class="' . $element['class2'] . '"' : '';
        	$output .= '>';
        	$output .= $element['label'];
        	$output .= '</a></li>' . PHP_EOL;
        }
        $output .= '</ul>' . PHP_EOL;
        return $output;
    }
    /**
     * Sets the view field 
     * @param $view Zend_View_Interface
     */
    public function setView (Zend_View_Interface $view)
    {
        $this->view = $view;
    }
}
