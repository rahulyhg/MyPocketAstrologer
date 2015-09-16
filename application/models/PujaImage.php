<?php

class PujaImage extends BaseModel {

	/* Table Name */

	static $table_name = 'puja_images';

	/* Associations */

	static $belongs_to = array(
		
		array(
            'puja',
            'class_name' => 'Puja',
            'foreign_key' => 'puja_id'
        ),
	);

	/* Public functions - Setters */

	public function set_puja(Puja $puja) {

		$puja->check_is_valid();
		$this->assign_attribute('puja_id', $puja->id);
	}

	public function set_image($image) {

		if($image == '') {
			throw new Exception('Image is required.');
        }

		$this->assign_attribute('image', $image);	
	}

	public function set_details($details) {
		$this->assign_attribute('details', $details);	
	}

	/* Public functions - Getters */

	public function get_image() {
		return $this->read_attribute('image');
	}

	public function get_details() {
		return $this->read_attribute('details');
	}

	/* Public static functions */

	public static function create($params) {

		$puja_image = new PujaImage;

		$puja_image->puja = array_key_exists('puja', $params) ? $params['puja'] : null;
		$puja_image->image = array_key_exists('image', $params) ? $params['image'] : null;
		$puja_image->details = array_key_exists('details', $params) ? $params['details'] : null;
		
		$puja_image->save();

		return $puja_image;
	}
}