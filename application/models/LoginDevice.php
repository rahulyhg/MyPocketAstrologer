<?php

class LoginDevice extends BaseModel {

	/* Table Name */

	static $table_name = 'login_devices';

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

	public function set_last_login_date($last_login_date) {

		if($last_login_date == '') {
			throw new Exception('Login Date is required.');
        }

		$this->assign_attribute('last_login_date', $last_login_date);	
	}

	/* Public functions - Getters */

	public function get_user() {
		return $this->read_attribute('user_id');
	}

	public function get_last_login_date() {
		return $this->read_attribute('last_login_date');
	}

	public function get_device_id() {
		return $this->read_attribute('device_id');
	}

	/* Public static functions */

	public static function create($params) {

		$login_device = new LoginDevice;

		$login_device->user = array_key_exists('user', $params) ? $params['user'] : null;
		$login_device->device_id = array_key_exists('device_id', $params) ? $params['device_id'] : null;
		date_default_timezone_set("Asia/Kathmandu");
		$login_device->last_login_date = date('Y-m-d H:i:s');

		$login_device->save();

		return $login_device;
	}
}