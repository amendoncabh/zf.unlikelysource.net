<?php
/**
 * Form controller renders different types of forms
 * 
 * @author ted
 * 
 */
class FormController extends Zend_Controller_Action
{

	public $countries;
	public $config;
			
    public function init()
    {
		// Get config object
		$this->config = $this->getFrontController()->getParam('bootstrap')->getOptions();
		// Get list from [countries] section of application.ini
		$this->countries = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'countries');
		// Layout variable
		$this->view->assign('layoutVar', "This is set in the FORM controller");
    }

    public function indexAction()
    {
        // action body
    }

    /**
     * Renders an address form
     * @param string $fake nothing at all
     * @return bool $whatever 
     */
    public function addressAction()
    {
    	// Locate the form file in /application/forms/Address.php
    	// Uses decorators to reproduce an HTML table
        $form = new Form_Address();
        $form->addDecorator('HtmlTag',array('tag' => 'table', 'cell-padding' => '10px', 'cell-spacing' => '10px'));
        $this->view->form = $form;
        $this->view->msg = "<h1>Demonstrates How to Use Decorators to Implement an HTML Table</h1>";
    }

    /**
     * User Login
     * @param int $xyz
     */
    public function loginAction()
    {
        // NOTE: form is 100% implement in this controller action
		$msg = "";
		$username = new Zend_Form_Element_Text('username');
		$username->addFilters(array('StringTrim','StringToLower'))
				->addValidators(array('Alnum',array('StringLength',FALSE,array(2,20))))
				->setAttribs(array('size' => 60, 'maxlength' => 128, 'title' => 'Enter Username'))
				->setRequired(TRUE)
				->setLabel('Username');
		$password = new Zend_Form_Element_Password('password');
		$password->addFilter('StringTrim')
				->addValidator('StringLength',FALSE,array(6))
				->setRequired(TRUE)
				->setLabel('Password');
		$login = new Zend_Form_Element_Submit('login');
		$login->setRequired(FALSE)
				->setIgnore(TRUE)
				->setLabel('Login!');
		// In a controller action:
		$form = new Zend_Form();
		$form->addElements(array($username,$password,$login));
		$form->setMethod('post');
		$request = $this->getRequest(); 
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				// success
			}
		}
		$this->view->form = $form;
		$this->view->msg = $msg;
    }

	public function userinfoAction() {
		// NOTE: Form is split up into display groups
		$form = new Form_Userinfo($this->config['captcha'],$this->countries->toArray());
		$attribs = $form->getAttribs();
		$header = "";
		foreach($attribs as $key => $value) {
			$header .= $key . "='" . $value . "' ";
		}
		$this->view->header = "<form $header>";
		$this->view->name = $form->getDisplayGroup('Name');
		$this->view->address = $form->getDisplayGroup('Address');
		$this->view->remainder = $form->getDisplayGroup('Remainder');
		$this->view->end = "</form>";
	}
	
	public function processAction() {
		$msg = "";
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($this->form->isValid($request->getPost())) {
				$msg = "<br />SUCCESSFUL LOGIN\n";
			} else {
				$msg = "<br />TRY LATER\n";
				$this->view->info = $this->form;
				return;
			}
		} else {
			$this->_forward("index","index");
		}
		$this->view->info .= $msg . "<p>" . var_export($this->getRequest(),TRUE) . "</p>\n";
	}

	public function userwithhelpersAction() {
		// Everything done by helpers
		$this->view->options = $this->countries->toArray();
	}
	
	public function notfoundAction() {
		$this->view->output = "<b>HTML</b><a href='/index'>BACK</a><br />©2010 unlikelysource.com<br />The price is £400.82";
	}
	
	public function bookAction() {
		$data = array(
			array(
				'author' => 'Hernando de Soto',
				'title' => 'The Mystery of Capitalism'
			),
			array(
				'author' => 'Henry Hazlitt',
				'title' => 'Economics in One Lesson'
			),
			array(
				'author' => 'Milton Friedman',
				'title' => 'Free to Choose'
			)
		);
		$view = new Zend_View();
		$view->books = $data;
		$view->setScriptPath(APPLICATION_PATH . "/views/scripts/form");
		echo $view->render('booklist.phtml');
	}

    public function filtertestAction()
    {
        // NOTE: demonstrates use of multi-word filter
        $msg = '';
		$className = new Zend_Form_Element_Text('className');
		// NOTE: filter is "Zend_Filter_Word_SeparatorToSeparator
		$className->addFilter('Word_SeparatorToSeparator', array('_', '/'))
				  ->setLabel('Enter a Class Name')
				  ->setAttrib('size', 60)
				  ->setDescription('Example: Zend_Feed_Pubsubhubbub_Model_ModelAbstract');
		$button = new Zend_Form_Element_Submit('button');
		$button->setRequired(FALSE)
				->setIgnore(TRUE)
				->setLabel('Filter');
		$form = new Zend_Form();
		$form->addElements(array($className, $button));
		$request = $this->getRequest(); 
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				$msg = "<br />RESULTING CLASS FILENAME EXPECTED:\n";
				$msg .= $form->getValue('className') . '.php';
				$form->reset();
			}
		}
		$this->view->form = $form;
		$this->view->msg = $msg;
    }

    public function escapeTestAction()
    {
        // NOTE: demonstrates turning off auto-escape
        $msg = '';
		$someText1 = new Zend_Form_Element_Text('someText1');
		$someText1->setLabel('1: Filtered Element')
				  ->setAttrib('size', 60);
		$someText2 = new Zend_Form_Element_Text('someText2');
		$someText2->setLabel('2: Unfiltered Element')
				  ->setAttrib('escape', FALSE)
				  ->setAttrib('size', 60);
		$someText3 = new Zend_Form_Element_Text('someText3');
		$someText3->setLabel('3: HtmlEntities Filtered Element')
				  ->addFilter('HtmlEntities')
				  ->setAttrib('size', 60);
		$viewFilt = new Zend_Form_Element_Radio('viewFilt');
		$viewFilt->setMultiOptions(array(0 => 'No', 1 => 'Yes'))
				 ->setValue(0)
		     	 ->setLabel('Filter the View?');
		$button = new Zend_Form_Element_Submit('button');
		$button->setRequired(FALSE)
				->setIgnore(TRUE)
				->setLabel('Test');
		$form1 = new Zend_Form();
		$form1->addElements(array($someText1, $someText2, $someText3, $viewFilt, $button));
		$request = $this->getRequest(); 
		if ($request->isPost()) {
			$form1->isValid($request->getPost());
			$yes = $form1->getValue('viewFilt');
			if (isset($yes) && $yes) {
				$this->view->setEscape('doNothing');
			}
			$msg = "<br />DO VIEW SOURCE TO SEE RESULTS:\n";
			$msg .= "<br />1: Value: " . $form1->getValue('someText1') . "\n";
			$msg .= "<br />2: Value: " . $form1->getValue('someText2') . "\n";
			$msg .= "<br />3: Value: " . $form1->getValue('someText3') . "\n";
			$msg .= "<br />3: Raw Value: " . $form1->getUnfilteredValue('someText3') . "\n";
		}
		$this->view->form1 = $form1;
		$this->view->msg = $msg;
    }

    public function subformsAction()
    {
    	$this->view->form = new Form_UserinfoWithSubforms('FormWithSubforms', 
    													  $this->config['captcha'],
    													  $this->countries->toArray());
    }
}
