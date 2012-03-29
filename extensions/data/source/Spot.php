<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright	  Copyright 2012, Mariano Iglesias (http://marianoiglesias.com.ar)
 * @license		  http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_spot\extensions\data\source;

use lithium\core\Environment;
/**
 * This datasource provides integration of Doctrine2 models
 */
class Spot extends \lithium\core\Object {
	/**
	 * Connection string for Spot
	 *
	 * @var string
	 */
	protected $connectionString;
	
	/**
	 * Connection name for internal
	 *
	 * @var string
	 */
	protected $connectionName;
	
	/**
	 * Configuration object for Spot
	 *
	 * @var \Spot\Config
	 */
	protected $configuration;
	
	/**
	 * Build data source
	 *
	 * @param array $config Configuration
	 */
	public function __construct(array $config = array()) {
		$defaults = array(
			'driver' => 'mysql',
			'host' => 'localhost',
			'login' => 'root',
			'password' => '',
			'database' => 'new-simplex',
			'port' => null
		);
		
		$config = array_intersect_key($defaults, array_merge($defaults, $config));
		extract($config);
		
		$this->connectionString = 
			"{$driver}://{$login}" . 
				($password ? ":{$password}" : '') .
				"@{$host}" .
				($port ? ":{$port}" : '') .
				"/{$database}";
		parent::__construct($config);
	}

	/**
	 * Initialize datasource
	 */
	protected function _init() {
		$this->configuration = new \Spot\Config();
		$this->configuration->addConnection('default', $this->connectionString);
		$this->mapper = new \Spot\Mapper($this->configuration);
	}
	
	public function getMapper() {
		return $this->mapper;
	}
	
	public function configureClass($class) {
		return array('meta' => array(
			'key' => 'id',
			'locked' => true
		));
	}
}
?>
