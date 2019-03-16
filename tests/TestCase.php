<?php namespace Tests\Database;

use Framework\Database\Database;

class TestCase extends \PHPUnit\Framework\TestCase
{
	/**
	 * @var Database
	 */
	protected static $database;

	public function __construct(...$params)
	{
		$this->setDatabase();
		parent::__construct(...$params);
	}

	protected function setDatabase() : Database
	{
		if (static::$database === null) {
			static::$database = new Database([
				'username' => \getenv('DB_USERNAME'),
				'password' => \getenv('DB_PASSWORD'),
				'schema' => \getenv('DB_SCHEMA'),
				'host' => \getenv('GITLAB_CI') ? 'mariadb' : \getenv('DB_HOST'),
				'port' => \getenv('DB_PORT'),
			]);
		}
		return static::$database;
	}

	protected function resetDatabase()
	{
		static::$database = null;
		$this->setDatabase();
	}

	protected function dropDummyData()
	{
		static::$database->exec('DROP TABLE IF EXISTS `t1`');
	}

	protected function createDummyData()
	{
		$this->dropDummyData();
		static::$database->exec(
			<<<SQL
			CREATE TABLE `t1` (
			  `c1` INT(11) AUTO_INCREMENT PRIMARY KEY,
			  `c2` VARCHAR(255)
			)
		SQL
		);
		static::$database->exec(
			"INSERT INTO `t1` (`c2`) VALUES ('a'), ('b'), ('c'), ('d'), ('e')"
		);
	}
}
