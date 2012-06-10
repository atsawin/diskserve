<?php
App::uses('AlternativesController', 'Controller');

/**
 * TestAlternativesController *
 */
class TestAlternativesController extends AlternativesController {
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
 * AlternativesController Test Case
 *
 */
class AlternativesControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.alternative', 'app.cluster', 'app.computer', 'app.setting');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Alternatives = new TestAlternativesController();
		$this->Alternatives->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Alternatives);

		parent::tearDown();
	}

}
