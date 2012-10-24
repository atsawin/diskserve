<?php
App::uses('SettingsController', 'Controller');

/**
 * TestSettingsController *
 */
class TestSettingsController extends SettingsController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * SettingsController Test Case
 *
 */
class SettingsControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.setting');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Settings = new TestSettingsController();
		$this->Settings->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Settings);

		parent::tearDown();
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {

	}
/**
 * testView method
 *
 * @return void
 */
	public function testView() {

	}
/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {

	}
/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {

	}
/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {

	}
}
