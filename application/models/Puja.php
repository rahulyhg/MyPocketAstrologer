<?php

class Puja extends BaseModel {

	/* Table Name */

	static $table_name = 'pujas';

	/* Associations */

	static $belongs_to = array(
		
		array(
            'user',
            'class_name' => 'User',
            'foreign_key' => 'user_id'
        ),
	);

	static $has_many = array(

		array(
            'images',
            'class_name' => 'PujaImage',
            'foreign_key' => 'puja_id',
        ),
    );

    /*

		----NOTE----
		status 1: suggested
		status 2: ordered/requested/paid
		status 3: ongoing
		status 4: completed

    */

	/* Public functions - Setters */

	public function set_user(User $user) {

		$user->check_is_valid();
		if(!$user->id)
			throw new Exception("Error Processing Request");
			
		$this->assign_attribute('user_id', $user->id);
	}

	public function set_name($name) {

		if($name == '') {
			throw new Exception('Name of Puja is required.');
        }

		$this->assign_attribute('name', $name);	
	}

	public function set_details($details) {
		$this->assign_attribute('details', $details);	
	}

	public function set_status($status) {
		$this->assign_attribute('status', $status);	
	}

	public function set_date($date) {

		if($date == '') {
			throw new Exception('Date of puja is required.');
        }

		$this->assign_attribute('date', $date);	
	}

	/* Public functions - Getters */

	public function get_name() {
		return $this->read_attribute('name');
	}

	public function get_details() {
		return $this->read_attribute('details');
	}

	public function get_status() {
		return $this->read_attribute('status');
	}

	public function get_date() {
		return $this->read_attribute('date');
	}

	/* Public static functions */

	public static function create($params) {

		$puja = new Puja;

		$puja->user = array_key_exists('user', $params) ? $params['user'] : null;
		$puja->name = array_key_exists('name', $params) ? $params['name'] : null;
		$puja->details = array_key_exists('details', $params) ? $params['details'] : null;
		$puja->status = array_key_exists('status', $params) ? $params['status'] : 0;
		$puja->date = array_key_exists('date', $params) ? $params['date'] : null;

		$puja->save();

		return $puja;
	}
}