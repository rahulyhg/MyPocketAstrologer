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

	public function set_street($street) {

		if($street == '') {
			throw new Exception('Street is required.');
        }

		$this->assign_attribute('street', $street);	
	}

	public function set_house($house) {
		$this->assign_attribute('house', $house);	
	}

	public function set_zip_code($zip_code) {

		if($zip_code == '') {
			throw new Exception('Zip Code is required.');
        }

		$this->assign_attribute('zip_code', $zip_code);	
	}

	public function set_phone_number($phone_number) {

		if($phone_number == '') {
			throw new Exception('Phone Number is required.');
        }

		$this->assign_attribute('phone_number', $phone_number);	
	}

	public function set_date($date) {

		if($date == '') {
			throw new Exception('Shipping Date is required.');
        }

		$this->assign_attribute('date', $date);	
	}

	public function set_is_delivered($is_delivered) {
		$this->assign_attribute('is_delivered', $is_delivered);	
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

	public function get_city() {
		return $this->read_attribute('city');
	}

	public function get_street() {
		return $this->read_attribute('street');
	}

	public function get_house() {
		return $this->read_attribute('house');
	}

	public function get_zip_code() {
		return $this->read_attribute('zip_code');
	}

	public function get_phone_number() {
		return $this->read_attribute('phone_number');
	}

	public function get_is_delivered() {
		return $this->read_attribute('is_delivered');
	}

	public function get_date() {
		return $this->read_attribute('date');
	}

	/* Public static functions */

	public static function create($params) {

		$shipping = new Shipping;

		$shipping->user = array_key_exists('user', $params) ? $params['user'] : null;
		$shipping->details = array_key_exists('details', $params) ? $params['details'] : null;
		$shipping->country = array_key_exists('country', $params) ? $params['country'] : null;
		$shipping->city = array_key_exists('city', $params) ? $params['city'] : null;
		$shipping->street = array_key_exists('street', $params) ? $params['street'] : null;
		$shipping->house = array_key_exists('house', $params) ? $params['house'] : null;
		$shipping->zip_code = array_key_exists('zip_code', $params) ? $params['zip_code'] : null;
		$shipping->is_delivered = array_key_exists('is_delivered', $params) ? $params['is_delivered'] : null;
		$shipping->phone_number = array_key_exists('phone_number', $params) ? $params['phone_number'] : null;
		$shipping->date = array_key_exists('date', $params) ? $params['date'] : null;

		$shipping->save();

		return $puja;
	}
}