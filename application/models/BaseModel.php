<?php

class BaseModel extends ActiveRecord_Base {

	public function __construct ($attributes=array(), $guard_attributes=TRUE, $instantiating_via_find=FALSE, $new_record=TRUE) {
		parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);

		$class = get_class($this);
		$this->_exceptions = isset($class::$exceptions) ? $class::$exceptions : array();
	}

	/* Exceptions */

	// This attribute is used for overriding base exceptions.
	private $_exceptions = array();

	private static $_base_exceptions = array(
		'not-exists' => array(
			'class_name' => 'ModelNotExistsException',
			'message' => 'This model does not exist.',
		),
		'not-deleted' => array(
			'class_name' => 'ModelNotDeletedException',
			'message' => 'This model is not deleted.',
		),
		'deleted' => array(
			'class_name' => 'ModelDeletedException',
			'message' => 'This model is deleted.',
		),
		'inactive' => array(
			'class_name' => 'ModelInactiveException',
			'message' => 'This model is inactive.',
		),
		'active' => array(
			'class_name' => 'ModelActiveException',
			'message' => 'This model is active.',
		),
	);

	/* Public Functions */

	public function is_active() {
		return ($this->active) ? true : false;
	}

	public function is_deleted() {
		return ($this->deleted) ? true : false;
	}

	public function is_valid() {
		return (!$this->is_deleted() && $this->is_active()) ? true : false;
	}

	public function check_is_undeleted() {

		if($this->is_deleted()) {
			$this->throw_base_exception('deleted');
		}
	}

	public function check_is_valid() {

		if($this->is_deleted()) {
			$this->throw_base_exception('deleted');
		}

		if(!$this->is_active()) {
			$this->throw_base_exception('inactive');
		}
	}
	
	public function activate() {

		if($this->is_deleted()) {
			$this->throw_base_exception('deleted');
		}

		if($this->is_active()) {
			$this->throw_base_exception('active');
		}

		$this->active = 1;
		$this->save();
	}

	public function deactivate() {

		if($this->is_deleted()) {
			$this->throw_base_exception('deleted');
		}

		if(!$this->is_active()) {
			$this->throw_base_exception('inactive');
		}

		$this->active = 0;
		$this->save();
	}

	public function delete() {

		if($this->is_deleted()) {
			$this->throw_base_exception('deleted');
		}

		$this->deleted = 1;
		$this->save();
	}

	public function undelete() {

		if(!$this->is_deleted()) {
			$this->throw_base_exception('not-deleted');
		}

		$this->deleted = 0;
		$this->save();
	}

	public function destroy() {
		parent::delete();
	}

	/* Public Static Functions */

	protected static function check_model_exists($model) {

		if(!$model) {
			$class = get_called_class();
			$model = new $class;
			$model->throw_base_exception('not-exists');
		}

	}

	public static function __callStatic($method, $args) {

		$create = false;

		if (substr($method,0,13) === 'find_model_by') {
			$attributes = substr($method,14);
			$options['conditions'] = ActiveRecord\SQLBuilder::create_conditions_from_underscored_string(static::connection(),$attributes,$args,static::$alias_attribute);

			if (!($model = static::find('first',$options)) && $create)
				return static::create(ActiveRecord\SQLBuilder::create_hash_from_underscored_string($attributes,$args,static::$alias_attribute));

			self::check_model_exists($model);
			return $model;
		}

		if (substr($method,0,17) === 'find_undeleted_by') {
			$attributes = substr($method,18);
			$options['conditions'] = ActiveRecord\SQLBuilder::create_conditions_from_underscored_string(static::connection(),$attributes,$args,static::$alias_attribute);

			if (!($model = static::find('first',$options)) && $create)
				return static::create(ActiveRecord\SQLBuilder::create_hash_from_underscored_string($attributes,$args,static::$alias_attribute));

			self::check_model_exists($model);
			$model->check_is_undeleted();
			return $model;
		}

		if (substr($method,0,13) === 'find_valid_by') {
			$attributes = substr($method,14);
			$options['conditions'] = ActiveRecord\SQLBuilder::create_conditions_from_underscored_string(static::connection(),$attributes,$args,static::$alias_attribute);

			if (!($model = static::find('first',$options)) && $create)
				return static::create(ActiveRecord\SQLBuilder::create_hash_from_underscored_string($attributes,$args,static::$alias_attribute));

			self::check_model_exists($model);
			$model->check_is_valid();
			return $model;
		}

		if (substr($method,0,17) === 'find_all_valid_by') {
			
			$attributes = substr($method,18);

			$options['conditions'] = ActiveRecord\SQLBuilder::create_conditions_from_underscored_string(static::connection(),$attributes,$args,static::$alias_attribute);
			$options['conditions'][0] .= ' and active = 1 and deleted = 0';

			$model = static::find('all',$options);

			return $model;
		}

		if (substr($method,0,21) === 'find_all_undeleted_by') {
			
			$attributes = substr($method,22);

			$options['conditions'] = ActiveRecord\SQLBuilder::create_conditions_from_underscored_string(static::connection(),$attributes,$args,static::$alias_attribute);
			$options['conditions'][0] .= ' and deleted = 0';

			$model = static::find('all',$options);

			return $model;
		}

		if (substr($method,0,14) === 'count_valid_by') {

			$attributes = substr($method,15);

			$options['conditions'] = ActiveRecord\SQLBuilder::create_conditions_from_underscored_string(static::connection(),$attributes,$args,static::$alias_attribute);
			$options['conditions'][0] .= ' and active = 1 and deleted = 0';

			return static::count($options);
		}

		if (substr($method,0,18) === 'count_undeleted_by') {

			$attributes = substr($method,19);

			$options['conditions'] = ActiveRecord\SQLBuilder::create_conditions_from_underscored_string(static::connection(),$attributes,$args,static::$alias_attribute);
			$options['conditions'][0] .= ' and deleted = 0';

			return static::count($options);
		}

		$ret = parent::__callStatic($method, $args);
		return $ret;
	}

	/* Private Static Functions */

	private function attempt_find_in_exceptions($method) {

		if(!array_key_exists($method, $this->_exceptions)) {
			throw new ModelExceptionNotExistsException("The method '$method' does not exist.");
		}

		if(!array_key_exists('class_name', $this->_exceptions[$method])) {
			throw new ModelExceptionNotExistsException("The method '$method' does not have a class_name.");
		}

		if(!class_exists($this->_exceptions[$method]['class_name'])) {
			throw new ModelExceptionNotExistsException("The class for exception '$class_name' does not exist.");
		}

		if(!array_key_exists('message', $this->_exceptions[$method])) {
			throw new ModelExceptionNotExistsException("The exception '$class_name' does not have a message.");
		}

		throw new $this->_exceptions[$method]['class_name']($this->_exceptions[$method]['message']);
	}

	private function attempt_find_in_base_exceptions($method) {

		if(!array_key_exists($method, self::$_base_exceptions)) {
			throw new ModelExceptionNotExistsException("The method '$method' does not exist in base_exceptions.");
		}

		if(!array_key_exists('class_name', self::$_base_exceptions[$method])) {
			throw new ModelExceptionNotExistsException("The method '$method' does not have a class_name.");
		}

		if(!class_exists(self::$_base_exceptions[$method]['class_name'])) {
			throw new ModelExceptionNotExistsException("The class for exception '$class_name' does not exist.");
		}

		if(!array_key_exists('message', self::$_base_exceptions[$method])) {
			throw new ModelExceptionNotExistsException("The exception '$class_name' does not have a message.");
		}

		throw new self::$_base_exceptions[$method]['class_name'](self::$_base_exceptions[$method]['message']);
	}

	private function throw_base_exception($method) {
		try {
			$this->attempt_find_in_exceptions($method);
		} catch(ModelExceptionNotExistsException $e) {
			$this->attempt_find_in_base_exceptions($method);
		}
	}

}