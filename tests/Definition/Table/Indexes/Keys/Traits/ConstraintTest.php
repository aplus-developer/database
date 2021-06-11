<?php namespace Tests\Database\Definition\Table\Indexes\Keys\Traits;

use Tests\Database\TestCase;

final class ConstraintTest extends TestCase
{
	public function testConstraint() : void
	{
		$index = new ConstraintMock(static::$database, null, 'id');
		$this->assertSame(
			' constraint_mock (`id`)',
			$index->sql()
		);
		$index->constraint('foo');
		$this->assertSame(
			' CONSTRAINT `foo` constraint_mock (`id`)',
			$index->sql()
		);
	}
}
