<?php
class Etherpad_Form_Pad extends Zend_Dojo_Form
{
	public function init()
	{
    	$session = new Zend_Session_Namespace('etherpad');
    	$padId	 = (isset($session->padId)) ? $session->padId : '';
    	$action  = '/etherpad/pad/index';
    	$action  .= ($padId) ? '/pad/' . $padId : '';
		$this->setMethod('POST');
		$this->setAction($action);
		// Dojo rich text box:
		$text = new Zend_Dojo_Form_Element_Editor(	'editor', 'content', array(
													'editActionInterval' => 2,
													'focusOnLoad'        => true,
													'height'             => '250px',
													'inheritWidth'       => true,
													'styleSheets'        => array('/js/dojo/dijits/themes/tundra/Editor.css')
		));
		/*
		$text = new Zend_Form_Element_Textarea('content');
		*/
		$text->addValidator('StringLength', FALSE, array(0, 128000));
		// pad controls:
		$captcha = new Zend_Captcha_Image('captchaImage');
        $captcha->setFont(APPLICATION_PATH . '/fonts/Verdana_Bold.ttf')
                ->setWordlen(4)
                ->setDotNoiseLevel(60)
                ->setLineNoiseLevel(3)
                ->setHeight(60)
                ->setExpiration(300)
                ->setWidth(200)
                ->setImgDir(APPLICATION_PATH . '/../public/captcha')
                ->setImgUrl('/captcha')
                ->setFontSize(24)
                ->setTimeout(300);
        $captchaElement = new Zend_Form_Element_Captcha('captcha', array('captcha' => $captcha));
        $captchaElement->setLabel('Please enter the 4 letters displayed below:')
        			   ->setAttrib('class', 'captcha_class')
        			   ->setRequired(true);
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Submit')
			   ->setAttrib('title', 'Lock pad, enter text, and then click this button')
			   ->setAttrib('class', 'button-title');
		$this->addElements(array($text, $captchaElement, $submit));
	}
}
