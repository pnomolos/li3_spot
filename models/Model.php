<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright	  Copyright 2012, Phil Schalm (http://github.com/pnomolos)
 * @license		  http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_spot\models;

use lithium\util\Inflector;

/**
 * This class can be used as the base class of your doctrine models, to allow
 * for lithium validation to work on doctrine models.
 */
abstract class Model extends \Spot\Entity {
	/**
	 * Criteria for data validation.
	 *
	 * Example usage:
	 * {{{
	 * public $validates = array(
	 *	   'title' => 'please enter a title',
	 *	   'email' => array(
	 *		   array('notEmpty', 'message' => 'Email is empty.'),
	 *		   array('email', 'message' => 'Email is not valid.'),
	 *	   )
	 * );
	 * }}}
	 *
	 * @var array
	 */
	protected $validates = array();
	
	protected static $_datasource = null;
	/**
	 * Class dependencies.
	 *
	 * @var array
	 */
	protected static $_classes = array(
		'connections' => 'lithium\data\Connections',
		'validator'   => 'lithium\util\Validator'
	);

	/**
	 * Connection name used for persisting / loading this record
	 *
	 * @var string
	 */
	protected static $connectionName = 'default';

	/**
	 * Get the mapper linked to the connection defined in the property
	 * `$connectionName`
	 *
	 * @see IModel::getMapper()
	 * @return \Spot\Mapper entity manager
	 */
	public static function getMapper() {
		static $mapper;
		if (!isset($mapper)) {
			$connections = static::$_classes['connections'];
			$mapper = $connections::get(static::$connectionName)->getMapper();
		}
		return $mapper;
	}
	public static function mapper() {
		return self::getMapper();
	}
	
	public function data($data = null, $modified = true) {
		if (is_object($data) || is_array($data) || !$data || null === $data) {
			return parent::data($data, $modified);
		} else {
			return $this->$data;
		}
	}
	
	/**
	 * Perform validation
	 *
	 * @see IModel::validates()
	 * @param array $options Options
	 * @return boolean Success
	 */
	public function validates(array $options = array()) {
		$defaults = array(
			'rules' => $this->validates,
			'events' => $this->exists() ? 'update' : 'create',
			'model' => get_called_class()
		);
		$options += $defaults;
		$validator = static::$_classes['validator'];

		$rules = $options['rules'];
		unset($options['rules']);

		if (!empty($rules) && $this->_errors = $validator::check($this->data(), $rules, $options)) {
			return false;
		}
		return true;
	}
	
	public function __call($key, $args = null) {
		if ($this->$key) {
			return $this->$key;
		} 
	}
	
	public static function first($options) {
		return static::mapper()->first(get_called_class(), (isset($options['conditions']) ? $options['conditions'] : array()));
	}
// 
//    *
// 	 * Allows several properties to be assigned at once, i.e.:
// 	 * {{{
// 	 * $record->set(array('title' => 'Lorem Ipsum', 'value' => 42));
// 	 * }}}
// 	 *
// 	 * @see IModel::validates()
// 	 * @param array $data An associative array of fields and values to assign to this instance.
// 	 * @param array $whitelist Fields to allow setting
// 	 * @param bool $useWhitelist Set to false to ignore whitelist
// 	 * @throws Exception
// 	 */
// 	public function set(array $data, array $whitelist = array(), $useWhitelist = true) {
// 		if (empty($data)) {
// 			return;
// 		} elseif ($useWhitelist && empty($whitelist)) {
// 			throw new \Exception('Must set whitelist of fields');
// 		}
// 
// 		if ($useWhitelist) {
// 			$data = array_intersect_key($data, array_flip($whitelist));
// 		}
// 		
// 		$this->data($data);
// 	}
// 
// 	/**
// 	 * Access the data fields of the record. Can also access a $named field.
// 	 * Only returns data for fields that have a getter method defined.
// 	 *
// 	 * @see IModel::validates()
// 	 * @param string $name Optionally included field name.
// 	 * @param bool $allProperties If true, get also properties without getter methods
// 	 * @return mixed Entire data array if $name is empty, otherwise the value from the named field.
// 	 */
// /*	public function data($name = null) {
// 		$data = $this->data();
// 		if (isset($name)) {
// 			return array_key_exists($name, $data) ? $data[$name] : null;
// 		}
// 		return $data;
// 	}
}
?>
