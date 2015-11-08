<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_column_user_gemstones extends CI_Migration {

	public function up() {
		
		$field = array(			

			'from_zodiac' => array(
				'type' => 'boolean',
				'default' => 0,
			),
		);

		$this->dbforge->add_column('user_gemstones', $field);

	}

	public function down() {		
		$this->dbforge->drop_column('user_gemstones','from_zodiac');
	}
}