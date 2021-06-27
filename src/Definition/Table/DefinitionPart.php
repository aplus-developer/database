<?php
/*
 * This file is part of The Framework Database Library.
 *
 * (c) Natan Felles <natanfelles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Framework\Database\Definition\Table;

use BadMethodCallException;

abstract class DefinitionPart
{
	/**
	 * @param string $method
	 * @param array<int,mixed> $arguments
	 *
	 * @return mixed
	 */
	public function __call(string $method, array $arguments) : mixed
	{
		if ($method === 'sql') {
			return $this->sql(...$arguments);
		}
		throw new BadMethodCallException("Method not found or not allowed: {$method}");
	}

	abstract protected function sql() : string;
}
