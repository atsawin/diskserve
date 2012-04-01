<?php
App::uses('Alternative', 'Model');

/**
 * Alternative Test Case
 *
 */
class AlternativeTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.alternative', 'app.cluster', 'app.computer');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Alternative = ClassRegistry::init('Alternative');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Alternative);

		parent::tearDown();
	}

}
