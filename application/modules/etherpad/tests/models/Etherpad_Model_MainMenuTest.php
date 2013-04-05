<?php
require_once 'application/modules/etherpad/models/MainMenu.php';
require_once 'PHPUnit/Framework/TestCase.php';
if (!defined('APPLICATION_PATH')) {
    require_once '../bootstrap.php';
}
/**
 * Etherpad_Model_MainMenu test case.
 */
class Etherpad_Model_MainMenuTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Etherpad_Model_MainMenu
     */
    private $Etherpad_Model_MainMenu;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        $this->bootstrap = new Zend_Application(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );
		$this->bootstrap->bootstrap();
    	// TODO Auto-generated Etherpad_Model_MainMenuTest::setUp()
        $this->Etherpad_Model_MainMenu = new Etherpad_Model_MainMenu(/* parameters */);
    }
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown ()
    {
        // TODO Auto-generated Etherpad_Model_MainMenuTest::tearDown()
        $this->Etherpad_Model_MainMenu = null;
        parent::tearDown();
    }
    /**
     * Constructs the test case.
     */
    public function __construct ()
    {
        // TODO Auto-generated constructor
    }
    /**
     * Tests Etherpad_Model_MainMenu::getMenu()
     */
    public function testGetMenu ()
    {
        // TODO Auto-generated Etherpad_Model_MainMenuTest::testGetMenu()
        $this->markTestIncomplete("getMenu test not implemented");
        Etherpad_Model_MainMenu::getMenu(/* parameters */);
    }
}

