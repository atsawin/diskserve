<?php
App::uses('Cluster', 'Model');

/**
 * Cluster Test Case
 *
 */
class ClusterTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.cluster', 'app.computer');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Cluster = ClassRegistry::init('Cluster');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Cluster);

		parent::tearDown();
	}

}
