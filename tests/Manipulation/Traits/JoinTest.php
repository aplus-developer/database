<?php namespace Tests\Database\Manipulation\Traits;

use Tests\Database\TestCase;

final class JoinTest extends TestCase
{
	protected JoinMock $statement;

	public function setup() : void
	{
		$this->statement = new JoinMock(static::$database);
	}

	public function testFrom() : void
	{
		$this->assertNull($this->statement->renderFrom());
		$this->statement->from('t1', 't2');
		$this->assertSame(
			' FROM `t1`, `t2`',
			$this->statement->renderFrom()
		);
		$this->statement->from(['aliasname' => 't3']);
		$this->assertSame(
			' FROM `t3` AS `aliasname`',
			$this->statement->renderFrom()
		);
		$this->statement->from(static function () {
			return 'NOW()';
		});
		$this->assertSame(
			' FROM (NOW())',
			$this->statement->renderFrom()
		);
		$this->statement->from([
			'time' => static function () {
				return 'SELECT NOW()';
			},
		], ['noindex']);
		$this->assertSame(
			' FROM (SELECT NOW()) AS `time`, `noindex` AS `0`',
			$this->statement->renderFrom()
		);
		$this->statement->from(
			't1',
			't2',
			['aliasname' => 't3'],
			static function () {
				return 'NOW()';
			},
			[
				'time' => static function () {
					return 'SELECT NOW()';
				},
			],
			[
				'noindex',
			]
		);
		$this->assertSame(
			' FROM `t1`, `t2`, `t3` AS `aliasname`, (NOW()), (SELECT NOW()) AS `time`, `noindex` AS `0`',
			$this->statement->renderFrom()
		);
	}

	public function testHasFrom() : void
	{
		$this->assertFalse($this->statement->hasFrom());
		$this->statement->from('t1');
		$this->assertTrue($this->statement->hasFrom());
	}

	public function testHasFromException() : void
	{
		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('Clause WHERe only works with FROM');
		$this->statement->hasFrom('WHERe');
	}

	public function testJoin() : void
	{
		$this->assertNull($this->statement->renderJoin());
		$this->statement->join('users');
		$this->assertSame(' JOIN `users`', $this->statement->renderJoin());
		$this->statement->join('users', 'natural');
		$this->assertSame(' NATURAL JOIN `users`', $this->statement->renderJoin());
		$this->statement->join('users', 'cross', 'using', ['user_id']);
		$this->assertSame(
			' CROSS JOIN `users` USING (`user_id`)',
			$this->statement->renderJoin()
		);
		$this->statement->join('users', 'left', 'on', static function () {
			return 'profiles.user_id = users.id';
		});
		$this->assertSame(
			' LEFT JOIN `users` ON (profiles.user_id = users.id)',
			$this->statement->renderJoin()
		);
	}

	public function testInvalidJoinType() : void
	{
		$this->statement->join('t1', 'innes');
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('Invalid JOIN type: innes');
		$this->statement->renderJoin();
	}

	public function testInvalidJoinConditionClause() : void
	{
		$this->statement->join('t1', 'inner', 'oi');
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('Invalid JOIN condition clause: oi');
		$this->statement->renderJoin();
	}

	public function testNaturalJoinWithCondition() : void
	{
		$this->statement->join('t1', 'natural left', 'on');
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('NATURAL LEFT JOIN has not condition');
		$this->statement->renderJoin();
	}

	public function testJoinOn() : void
	{
		$this->statement->joinOn('t1', static function () {
			return 't1.id = t2.id';
		});
		$this->assertSame(' JOIN `t1` ON (t1.id = t2.id)', $this->statement->renderJoin());
	}

	public function testJoinUsing() : void
	{
		$this->statement->joinUsing('t1', 'user_id');
		$this->assertSame(' JOIN `t1` USING (`user_id`)', $this->statement->renderJoin());
	}

	public function testInnerJoinOn() : void
	{
		$this->statement->innerJoinOn('t1', static function () {
			return 't1.id = t2.id';
		});
		$this->assertSame(' INNER JOIN `t1` ON (t1.id = t2.id)', $this->statement->renderJoin());
	}

	public function testInnerJoinUsing() : void
	{
		$this->statement->innerJoinUsing('t1', 'user_id');
		$this->assertSame(' INNER JOIN `t1` USING (`user_id`)', $this->statement->renderJoin());
	}

	public function testCrossJoinOn() : void
	{
		$this->statement->crossJoinOn('t1', static function () {
			return 't1.id = t2.id';
		});
		$this->assertSame(' CROSS JOIN `t1` ON (t1.id = t2.id)', $this->statement->renderJoin());
	}

	public function testCrossJoinUsing() : void
	{
		$this->statement->crossJoinUsing('t1', 'user_id');
		$this->assertSame(' CROSS JOIN `t1` USING (`user_id`)', $this->statement->renderJoin());
	}

	public function testLeftJoinOn() : void
	{
		$this->statement->leftJoinOn('t1', static function () {
			return 't1.id = t2.id';
		});
		$this->assertSame(' LEFT JOIN `t1` ON (t1.id = t2.id)', $this->statement->renderJoin());
	}

	public function testLeftJoinUsing() : void
	{
		$this->statement->leftJoinUsing('t1', 'user_id');
		$this->assertSame(' LEFT JOIN `t1` USING (`user_id`)', $this->statement->renderJoin());
	}

	public function testLeftOuterJoinOn() : void
	{
		$this->statement->leftOuterJoinOn('t1', static function () {
			return 't1.id = t2.id';
		});
		$this->assertSame(
			' LEFT OUTER JOIN `t1` ON (t1.id = t2.id)',
			$this->statement->renderJoin()
		);
	}

	public function testLeftOuterJoinUsing() : void
	{
		$this->statement->leftOuterJoinUsing('t1', 'user_id');
		$this->assertSame(
			' LEFT OUTER JOIN `t1` USING (`user_id`)',
			$this->statement->renderJoin()
		);
	}

	public function testRightJoinOn() : void
	{
		$this->statement->rightJoinOn('t1', static function () {
			return 't1.id = t2.id';
		});
		$this->assertSame(' RIGHT JOIN `t1` ON (t1.id = t2.id)', $this->statement->renderJoin());
	}

	public function testRightJoinUsing() : void
	{
		$this->statement->rightJoinUsing('t1', 'user_id');
		$this->assertSame(' RIGHT JOIN `t1` USING (`user_id`)', $this->statement->renderJoin());
	}

	public function testRightOuterJoinOn() : void
	{
		$this->statement->rightOuterJoinOn('t1', static function () {
			return 't1.id = t2.id';
		});
		$this->assertSame(
			' RIGHT OUTER JOIN `t1` ON (t1.id = t2.id)',
			$this->statement->renderJoin()
		);
	}

	public function testRightOuterJoinUsing() : void
	{
		$this->statement->rightOuterJoinUsing('t1', 'user_id');
		$this->assertSame(
			' RIGHT OUTER JOIN `t1` USING (`user_id`)',
			$this->statement->renderJoin()
		);
	}

	public function testNaturalJoin() : void
	{
		$this->statement->naturalJoin('t1');
		$this->assertSame(' NATURAL JOIN `t1`', $this->statement->renderJoin());
	}

	public function testNaturalLeftJoin() : void
	{
		$this->statement->naturalLeftJoin('t1');
		$this->assertSame(' NATURAL LEFT JOIN `t1`', $this->statement->renderJoin());
	}

	public function testNaturalLeftOuterJoin() : void
	{
		$this->statement->naturalLeftOuterJoin('t1');
		$this->assertSame(' NATURAL LEFT OUTER JOIN `t1`', $this->statement->renderJoin());
	}

	public function testNaturalRightJoin() : void
	{
		$this->statement->naturalRightJoin('t1');
		$this->assertSame(' NATURAL RIGHT JOIN `t1`', $this->statement->renderJoin());
	}

	public function testNaturalRightOuterJoin() : void
	{
		$this->statement->naturalRightOuterJoin('t1');
		$this->assertSame(' NATURAL RIGHT OUTER JOIN `t1`', $this->statement->renderJoin());
	}
}
