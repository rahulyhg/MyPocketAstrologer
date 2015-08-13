<?php

class Shipping extends BaseModel {

	/* Table Name */

	static $table_name = 'shipping';


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

	public function set_details($details) {
		$this->assign_attribute('details', $details);	
	}

	public function set_country($country) {

		if($country == '') {
			throw new Exception('Country is required.');
        }

		$this->assign_attribute('country', $country);	
	}

	public function set_city($city) {

		if($city == '') {
			throw new Exception('City is required.');
        }

		$this->assign_attribute('city', $city);	
	}

	public function set_state($state) {
		$this->assign_attribute('state', $state);	
	}

	public function set_street($street) {

		if($street == '') {
			throw new Exception('Street is required.');
        }

		$this->assign_attribute('street', $street);	
	}

	public function set_apt_no($apt_no) {
		$this->assign_attribute('apt_no', $apt_no);	
	}

	public function set_postal_code($postal_code) {

		if($postal_code == '') {
			throw new Exception('Postal Code is required.');
        }

		$this->assign_attribute('postal_code', $postal_code);	
	}

	public function set_phone_number($phone_number) {

		if($phone_number == '') {
			throw new Exception('Phone Number is required.');
        }

		$this->assign_attribute('phone_number', $phone_number);	
	}

	public function set_device_id($device_id) {

		if($device_id == '') {
			throw new Exception('Device ID is required.');
        }

		$this->assign_attribute('device_id', $device_id);	
	}

	public function set_type($type) {
		$this->assign_attribute('type', $type);	
	}

	/* Public functions - Getters */

	public function get_user() {
		return $this->read_attribute('user_id');
	}

	public function get_details() {
		return $this->read_attribute('details');
	}

	public function get_country() {
		return $this->read_attribute('country');
	}

	public function get_state() {
		return $this->read_attribute('state');
	}

	public function get_city() {
		return $this->read_attribute('city');
	}

	public function get_street() {
		return $this->read_attribute('street');
	}

	public function get_apt_no() {
		return $this->read_attribute('apt_no');
	}

	public function get_postal_code() {
		return $this->read_attribute('postal_code');
	}

	public function get_phone_number() {
		return $this->read_attribute('phone_number');
	}

	public function get_type() {
		return $this->read_attribute('type');
	}

	public function get_device_id() {
		return $this->read_attribute('device_id');
	}

	/* Public static functions */

	public static function create($params) {

		$shipping = new Shipping;

		$shipping->user = array_key_exists('user', $params) ? $params['user'] : null;
		$shipping->details = array_key_exists('details', $params) ? $params['details'] : null;
		$shipping->country = isset($params['address']['country']) ? $params['address']['country'] : null;
		$shipping->state = isset($params['address']['state']) ? $params['address']['state'] : null;
		$shipping->city = isset($params['address']['city']) ? $params['address']['city'] : null;
		$shipping->street = isset($params['address']['street_address']) ? $params['address']['street_address'] : null;
		$shipping->apt_no = isset($params['address']['apt_no']) ? $params['address']['apt_no'] : null;
		$shipping->postal_code = isset($params['address']['postal_code']) ? $params['address']['postal_code'] : null;
		$shipping->phone_number = isset($params['address']['phone_number']) ? $params['address']['phone_number'] : null;
		$shipping->device_id = array_key_exists('device_id', $params) ? $params['device_id'] : null;
		$shipping->type = array_key_exists('type', $params) ? $params['type'] : 0;

		$shipping->save();

		return $shipping;
	}
}