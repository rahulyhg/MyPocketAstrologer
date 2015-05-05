<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_user_gemstones extends CI_Migration {

	public function up() {

		$fields = array(
		
			'id' => array(
				'type' => 'int',
				'auto_increment' => true,
			),

			'user_id' => array(
				'type' => 'int',
			),

			'gemstone_id' => array(
				'type' => 'int',
				),

			'details' => array(
				'type' => 'varchar',
				'constraint' => '250',
			),
			
			'active' => array(
				'type' => 'boolean',
				'default' => 1,
			),

			'deleted' => array(
				'type'=>'boolean',
				'default'=> 0,
			),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('user_gemstones');

	}

	public function down() {
		$this->dbforge->drop_table('user_gemstones');
	}
}