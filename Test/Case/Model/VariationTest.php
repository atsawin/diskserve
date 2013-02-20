<?php
App::uses('Variation', 'Model');

/**
 * Variation Test Case
 *
 */
class VariationTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.variation', 'app.cluster', 'app.alternative', 'app.computer');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Variation = ClassRegistry::init('Variation');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Variation);

		parent::tearDown();
	}

}
