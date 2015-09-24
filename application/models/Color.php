<?php

class Color extends BaseModel {

	/* Table Name */

	static $table_name = 'colors';

	/* Associations */

	/* Public functions - Setters */

	public function set_color($color) {

		if($color == '') {
			throw new Exception('Color name is required.');
        }

		$this->assign_attribute('color', $color);
	}

	public function set_details($details) {
		$this->assign_attribute('details', $details);	
	}

	/* Public functions - Getters */

	public function get_color() {
		return $this->read_attribute('color');
	}

	public function get_details() {
		return $this->read_attribute('details');
	}

	/* Public static functions */

	public static function create($params) {

		$color = new Color;

		$color->color = array_key_exists('color', $params) ? $params['color'] : null;
		$color->details = array_key_exists('details', $params) ? $params['details'] : null;
		
		$color->save();

		return $color;
	}
}