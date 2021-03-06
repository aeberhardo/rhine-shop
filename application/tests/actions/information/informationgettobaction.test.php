<?php

use Rhine\Actions\Information\InformationGetToBAction;

/**
 * @group unit
 */
class InformationGetToBActionTest extends Tests\UnitTestCase
{

	private $action;

	protected function setUpInternal()
	{
		$this->action = new InformationGetToBAction();
	}

	/**
	 * Tests the action for the happy case.
	 *
	 * @return void
	 */
	public function testOk()
	{
		$response = $this->action->execute();

		$this->assertResponseViewNameIs('information.tob', $response);
	}

}