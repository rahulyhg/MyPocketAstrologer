<?php

class Gemstone extends BaseModel {

	/* Table Name */

	static $table_name = 'gemstones';

	/* Public functions - Setters */

	public function set_name($name) {

		if($name == '') {
			throw new Exception('Name is required.');
        }

		$this->assign_attribute('name', $name);	
	}

	public function set_color($color) {

		if($color == '') {
			throw new Exception('Color is required.');
        }

		$this->assign_attribute('color', $color);	
	}

	public function set_details($details) {
		$this->assign_attribute('details', $details);	
	}

	/* Public functions - Getters */

	public function get_name() {
		return $this->read_attribute('name');
	}

	public function get_color() {
		return $this->read_attribute('color');
	}

	public function get_details() {
		return $this->read_attribute('details');
	}

	/* Public static functions */

	public static function create($params) {

		$gemstone = new Gemstone;

		$gemstone->name = array_key_exists('name', $params) ? $params['name'] : null;
		$gemstone->color = array_key_exists('color', $params) ? $params['color'] : null;
		$gemstone->details = array_key_exists('details', $params) ? $params['details'] : null;

		$gemstone->save();

		return $gemstone;
	}
}