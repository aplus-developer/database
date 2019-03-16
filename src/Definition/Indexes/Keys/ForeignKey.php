<?php namespace Framework\Database\Definition\Indexes\Keys;

use Framework\Database\Definition\Indexes\Index;

/**
 * Class ForeignKey.
 *
 * @see https://mariadb.com/kb/en/library/foreign-keys/
 */
class ForeignKey extends Index
{
	use Traits\Constraint;
	protected $type = 'FOREIGN KEY';
	/**
	 * @var string
	 */
	protected $referenceTable;
	/**
	 * @var array
	 */
	protected $referenceColumns;
	/**
	 * @var string|null
	 */
	protected $onDelete;
	/**
	 * @var string|null
	 */
	protected $onUpdate;

	public function references(string $table, string $column, string ...$columns)
	{
		$this->referenceTable = $table;
		$this->referenceColumns = $columns ? \array_merge([$column], $columns) : [$column];
		return $this;
	}

	protected function renderReferences() : string
	{
		if ($this->referenceTable === null) {
			throw new \LogicException('REFERENCES clause was not set');
		}
		$table = $this->database->protectIdentifier($this->referenceTable);
		$columns = [];
		foreach ($this->referenceColumns as $column) {
			$columns[] = $this->database->protectIdentifier($column);
		}
		$columns = \implode(', ', $columns);
		return " REFERENCES {$table} ({$columns})";
	}

	public function onDelete(string $option)
	{
		$this->onDelete = $option;
		return $this;
	}

	protected function renderOnDelete() : ?string
	{
		if ($this->onDelete === null) {
			return null;
		}
		$reference = $this->makeReferenceOption($this->onDelete);
		return " ON DELETE {$reference}";
	}

	public function onUpdate(string $option)
	{
		$this->onUpdate = $option;
		return $this;
	}

	protected function renderOnUpdate() : ?string
	{
		if ($this->onUpdate === null) {
			return null;
		}
		$reference = $this->makeReferenceOption($this->onUpdate);
		return " ON UPDATE {$reference}";
	}

	private function makeReferenceOption(string $option) : string
	{
		$result = \strtoupper($option);
		if (\in_array($result, ['RESTRICT', 'CASCADE', 'SET NULL', 'NO ACTION'], true)) {
			return $result;
		}
		throw new \InvalidArgumentException("Invalid reference option: {$option}");
	}

	protected function renderTypeAttributes() : ?string
	{
		return $this->renderReferences() . $this->renderOnDelete() . $this->renderOnUpdate();
	}
}