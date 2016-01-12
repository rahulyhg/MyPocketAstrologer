<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_gemstones_data extends CI_Migration {

	public function up() {

		$data =  array(

					'id'=> 8,
					'name' => 'Yellow Sapphire',
					'details'=> '',
				);

		$this->db->insert('gemstones', $data);
	}

	public function down() {

	}
}