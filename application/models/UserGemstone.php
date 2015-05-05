<?php

class UserGemstome extends BaseModel {

	/* Table Name */

	static $table_name = 'user_gemstones';

	static $belongs_to = array(
		
		array(
            'user',
            'class_name' => 'User',
            'foreign_key' => 'user_id'
        ),

        array(
            'gemstone',
            'class_name' => 'Gemstone',
            'foreign_key' => 'gemstone_id'
        ),
	);

	/* Public functions - Setters */

	public function set_user(User $user) {

		$user->check_is_valid();
		$this->assign_attribute('user_id', $user->id);
	}

	public function set_gemstone(Gemstone $gemstone) {
		$this->assign_attribute('gemstone_id', $gemstone->id);	
	}

	public function set_details($details) {
		$this->assign_attribute('details', $details);	
	}

	/* Public functions - Getters */

	public function get_user() {
		return $this->read_attribute('user_id');
	}

	public function get_gemstone() {
		return $this->read_attribute('gemstone_id');
	}

	public function get_details() {
		return $this->read_attribute('details');
	}

	/* Public static functions */

	public static function create($params) {

		$user_gemstone = new UserGemstome;

		$user_gemstone->user = array_key_exists('user', $params) ? $params['user'] : null;
		$user_gemstone->gemstone = array_key_exists('gemstone', $params) ? $params['gemstone'] : null;
		$user_gemstone->details = array_key_exists('details', $params) ? $params['details'] : null;

		$user_gemstone->save();

		return $user_gemstone;
	}
}