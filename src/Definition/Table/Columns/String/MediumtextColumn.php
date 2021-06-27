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
 * Class MediumtextColumn.
 *
 * @see https://mariadb.com/kb/en/library/mediumtext/
 */
final class MediumtextColumn extends StringDataType
{
	protected string $type = 'mediumtext';
}
