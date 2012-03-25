<?php
App::uses('Computer', 'Model');

/**
 * Computer Test Case
 *
 */
class ComputerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.computer', 'app.cluster');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Computer = ClassRegistry::init('Computer');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Computer);

		parent::tearDown();
	}

}
