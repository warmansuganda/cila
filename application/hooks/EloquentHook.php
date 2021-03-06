<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class EloquentHook {

	/**
	 * Holds the instance
	 * @var object
	 */
	protected $instance;

	/**
	 * Gets CI instance
	 */
	private function setInstance() {
		$this->instance =& get_instance();
	}

	/**
	 * Loads database
	 */
	private function loadDatabase() {
		$this->instance->load->database(); 
	}

	/**
	 * Returns the instance of the db
	 * @return object
	 */
	private function getDB() {
		return $this->instance->db;
	}

	private function getDriver($dbdriver = '')
	{
		if ($dbdriver == 'mysqli') {
			return 'mysql';
		}
		return $dbdriver;
	}

	public function bootEloquent() {

		$this->setInstance();

		$this->loadDatabase();

		$config = $this->getDB();

		$capsule = new Capsule;

		$capsule->addConnection([
			'driver'    => $this->getDriver($config->dbdriver),
		    'host'      => $config->hostname,
		    'database'  => $config->database,
		    'username'  => $config->username,
		   	'password'  => $config->password,
		   	'charset'   => $config->char_set,
		   	'collation' => $config->dbcollat,
		   	'prefix'    => $config->dbprefix,
		]);

		$capsule->setEventDispatcher(new Dispatcher(new Container));

		$capsule->setAsGlobal();
		$capsule->bootEloquent();
	}

}
