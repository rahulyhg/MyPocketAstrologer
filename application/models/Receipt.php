<?php

class Receipt extends BaseModel {

	/* Table Name */

	static $table_name = 'receipts';

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

	public function set_type($type) {

		if(!$type) {
			throw new Exception('Please enter the Type.');
        }

		$this->assign_attribute('type', $type);	
	}

	public function set_amount($amount) {

		if($amount == '') {
			throw new Exception('Please enter the Amount paid.');
        }

		$this->assign_attribute('amount', $amount);	
	}

	public function set_receipt_number($receipt_number) {

		if($receipt_number == '') {
			throw new Exception('Please enter the Receipt Number.');
        }

		$this->assign_attribute('receipt_number', $receipt_number);	
	}

	public function set_device_id($device_id) {

		if($device_id == '')
			throw new Exception("Device ID is required");
			
		$this->assign_attribute('device_id', $device_id);	
	}

	public function set_gemstone_id($gemstone_id) {
		$this->assign_attribute('gemstone_id', $gemstone_id);	
	}

	/* Public functions - Getters */

	public function get_type() {
		return $this->read_attribute('type');
	}

	public function get_amount() {
		return $this->read_attribute('amount');
	}

	public function get_receipt_number() {
		return $this->read_attribute('receipt_number');
	}

	public function get_device_id() {
		return $this->read_attribute('device_id');
	}

	public function get_gemstone_id() {
		return $this->read_attribute('gemstone_id');
	}


	/* Public static functions */

	public static function create($params) {

		$receipt = new Receipt;

		$receipt->user = array_key_exists('user', $params) ? $params['user'] : null;
		$receipt->type = array_key_exists('type', $params) ? $params['type'] : 0;
		$receipt->amount = array_key_exists('paid_value', $params) ? $params['paid_value'] : null;
		$receipt->receipt_number = array_key_exists('receipt_number', $params) ? $params['receipt_number'] : null;
		$receipt->device_id = array_key_exists('device_id', $params) ? $params['device_id'] : null;
		$shipping->gemstone_id = array_key_exists('object_id', $params) ? $params['object_id'] : 0;

		$receipt->save();

		return $receipt;
	}
}