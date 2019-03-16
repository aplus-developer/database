<?php namespace Tests\Database\Definition\Indexes\Keys\Traits;

use Tests\Database\TestCase;

class ConstraintTest extends TestCase
{
	public function testConstraint()
	{
		$index = new ConstraintMock(static::$database, 'id');
		$this->assertEquals(
			' constraint_mock (`id`)',
			$index->sql()
		);
		$index->constraint('foo');
		$this->assertEquals(
			' CONSTRAINT `foo` constraint_mock (`id`)',
			$index->sql()
		);
	}
}
