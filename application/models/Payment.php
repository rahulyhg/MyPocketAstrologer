<?php

class Payment extends BaseModel {

	/* Table Name */

	static $table_name = 'payments';

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

	public function set_date($date) {

		if($date == '') {
			throw new Exception('Date of puja is required.');
        }

		$this->assign_attribute('date', $date);	
	}

	public function set_amount($amount) {

		if($amount == '') {
			throw new Exception('Pyment amount is required.');
        }

		$this->assign_attribute('amount', $amount);	
	}

	public function set_is_complete($is_complete) {
		$this->assign_attribute('is_complete', $is_complete);	
	}

	/* Public functions - Getters */

	public function get_user() {
		return $this->read_attribute('user_id');
	}

	public function get_details() {
		return $this->read_attribute('details');
	}

	public function get_date() {
		return $this->read_attribute('date');
	}

	public function get_amount() {
		return $this->read_attribute('amount');
	}

	public function get_is_complete() {
		return $this->read_attribute('is_complete');
	}	

	/* Public static functions */

	public static function create($params) {

		$payment = new Payment;

		$payment->user = array_key_exists('user', $params) ? $params['user'] : null;
		$payment->details = array_key_exists('details', $params) ? $params['details'] : null;
		$payment->date = array_key_exists('date', $params) ? $params['date'] : null;
		$payment->amount = array_key_exists('amount', $params) ? $params['amount'] : null;
		$payment->is_complete = array_key_exists('is_complete', $params) ? $params['is_complete'] : null;

		$payment->save();

		return $payment;
	}
}