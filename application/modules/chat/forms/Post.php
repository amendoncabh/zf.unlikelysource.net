<?php
class Chat_Form_Post extends Zend_Form
{
	public function init()
	{
		$this->setMethod('POST');
		$username = new Zend_Form_Element_Text('username');
		$username->setLabel('Username')
				 ->setRequired(TRUE)
				 ->setAttribs(array('size' => 40, 'maxlength' => 64, 'title' => 'Username can be 0-9 and/or a-z'))
				 ->addValidator('Alnum')
				 ->addValidator('StringLength', NULL, array(1,64));
		$message = new Zend_Form_Element_Textarea('message');
		$message->setLabel('Message')
				->setAttribs(array('rows' => 8, 'cols' => 60, 'title' => 'Enter a message up to 4K in size.  No HTML ... sorry!'))
				->addValidator('StringLength', NULL, array(0, 4096))
				->addFilter('StripTags');
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
		$post = new Zend_Form_Element_Submit('post');
		$post->setLabel('Post')
			 ->setAttrib('title', 'Click to post a message')
			 ->setAttrib('class', 'button-title');
		$this->addElements(array($username, $message, $captchaElement, $post));
	}	
}