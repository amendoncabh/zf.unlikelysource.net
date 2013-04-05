<?php
//require_once 'application/modules/etherpad/controllers/PadController.php';
require_once 'PHPUnit/Framework/TestCase.php';
if (!defined('APPLICATION_PATH')) {
    require_once __DIR__ . '/../bootstrap.php';
}
/**
 * Etherpad_PadController test case.
 */
class Etherpad_PadControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        $this->bootstrap = new Zend_Application(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );
		//$this->bootstrap->bootstrap();
    	parent::setUp();
    }
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown ()
    {
        // TODO Auto-generated Etherpad_PadControllerTest::tearDown()
        parent::tearDown();
    }
    /**
     * Constructs the test case.
     */
    public function __construct ()
    {
        // TODO Auto-generated constructor
    }
    
    public function testIndex()
    {
    	$this->dispatch('/etherpad/pad');
//    	$this->assertModule('etherpad');
    	$this->assertController('pad');
//    	$this->assertAction('index');
    }
    /**
     * Tests Etherpad_PadController->indexAction()
     */
    public function testLockPostNoValuesShowsInvalidValues()
    {
    	$this->getRequest()->setMethod('POST')
    	              	   ->setPost(array());
   	    $this->dispatch('/etherpad/pad/lock');
//        $this->assertXpath('/html/body/div/div[3]/div/div/form/dl/dd/ul');
        $this->assertXpath('/html/body/div/div/div/div/div/form');
    }
}

