<?php

class GcmUser extends BaseModel {

	/* Table Name */

	static $table_name = 'gcm_users';

	/* Associations */

	static $belongs_to = array(
		
		array(
            'user',
            'class_name' => 'User',
            'foreign_key' => 'user_id'
        ),
	);

	/* Public functions - Setters */

	public function set_user(User $user) {

		$user->check_is_valid();
		$this->assign_attribute('user_id', $user->id);
	}

	public function set_device_id($device_id) {

		if($device_id == '') {
			throw new Exception('Device ID is required.');
        }

		$this->assign_attribute('device_id', $device_id);	
	}

	public function set_gcm_regd_id($gcm_regd_id) {

		if($gcm_regd_id == '') {
			throw new Exception('No GCM Registration ID found');
        }

		$this->assign_attribute('gcm_regd_id', $gcm_regd_id);	
	}

	/* Public functions - Getters */

	public function get_device_id() {
		return $this->read_attribute('device_id');
	}

	public function get_gcm_regd_id() {
		return $this->read_attribute('gcm_regd_id');
	}

	/* Public static functions */

	public static function create($params) {

		$gcm_user = new GcmUser;

		$gcm_user->user = array_key_exists('user', $params) ? $params['user'] : null;
		$gcm_user->device_id = array_key_exists('device_id', $params) ? $params['device_id'] : null;
		$gcm_user->gcm_regd_id = array_key_exists('gcm_regd_id', $params) ? $params['gcm_regd_id'] : null;

		$gcm_user->save();

		return $gcm_user;
	}
}