<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_login_devices extends CI_Migration {

	public function up() {

		$fields = array(
		
			'id' => array(
				'type' => 'int',
				'auto_increment' => true,
			),

			'user_id' => array(
				'type' => 'int',
			),

			'device_id' => array(
				'type' => 'varchar',
				'constraint' => '500',
			),

			'last_login_date' => array(
				'type' => 'datetime',
				'null' => false,
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
		$this->dbforge->create_table('login_devices');

	}

	public function down() {
		$this->dbforge->drop_table('login_devices');
	}
}