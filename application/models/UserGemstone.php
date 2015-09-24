<?php

class UserGemstone extends BaseModel {

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

        array(
            'color',
            'class_name' => 'Color',
            'foreign_key' => 'color_id'
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

	public function set_color(Color $color) {
		$this->assign_attribute('color_id', $color->id);	
	}

	public function set_details($details) {
		$this->assign_attribute('details', $details);	
	}

	public function set_status($status) {
		$this->assign_attribute('status', $status);	
	}

	/* Public functions - Getters */

	public function get_details() {
		return $this->read_attribute('details');
	}

	public function get_status() {
		return $this->read_attribute('status');
	}

	/*
		---NOTE---
		status 1: suggested
		status 2: ordered for shipping
		status 3: processed for shipping
	*/

	/* Public static functions */

	public static function create($params) {

		$user_gemstone = new UserGemstone;

		$user_gemstone->user = array_key_exists('user', $params) ? $params['user'] : null;
		$user_gemstone->gemstone = array_key_exists('gemstone', $params) ? $params['gemstone'] : null;
		$user_gemstone->color = array_key_exists('color', $params) ? $params['color'] : null;
		$user_gemstone->details = array_key_exists('details', $params) ? $params['details'] : null;
		$user_gemstone->status = 1;

		$user_gemstone->save();

		return $user_gemstone;
	}
}