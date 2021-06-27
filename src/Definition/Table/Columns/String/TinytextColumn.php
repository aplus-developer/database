<?php
/*
 * This file is part of The Framework Database Library.
 *
 * (c) Natan Felles <natanfelles@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Framework\Database\Definition\Table\Columns\String;

/**
 * Class TinytextColumn.
 *
 * @see https://mariadb.com/kb/en/library/tinytext/
 */
final class TinytextColumn extends StringDataType
{
	protected string $type = 'tinytext';
}
