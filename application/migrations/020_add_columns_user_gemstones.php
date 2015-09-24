<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_columns_user_gemstones extends CI_Migration {

	public function up() {
		
		$field = array(			

			'color_id' => array(
				'type' => 'int',
			),

			'status' => array(
				'type' => 'int',
			),
		);

		$this->dbforge->add_column('user_gemstones', $field);
	}

	public function down() {
		
		$this->dbforge->drop_column('user_gemstones','color_id');
		$this->dbforge->drop_column('user_gemstones','status');
	}

}