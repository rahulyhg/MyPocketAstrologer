<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_colors_data extends CI_Migration {

	public function up() {

		$data =  array(

					'id'=> 10,
					'color' => 'Purple',
					'details'=> '',
				);

		$this->db->insert('colors', $data);

		$data =  array(

					'id'=> 11,
					'color' => 'Black',
					'details'=> '',
				);

		$this->db->insert('colors', $data);
	}

	public function down() {

	}
}