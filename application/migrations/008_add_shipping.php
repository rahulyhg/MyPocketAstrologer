<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_shipping extends CI_Migration {

	public function up() {

		$fields = array(
		
			'id' => array(
				'type' => 'int',
				'auto_increment' => true,
			),

			'user_id' => array(
				'type' => 'int',
			),

			'details' => array(
				'type' => 'varchar',
				'constraint' => '500',
				'null' => true,
			),

			'country' => array(
				'type' => 'varchar',
				'constraint' => '250',
			),

			'state' => array(
				'type' => 'varchar',
				'constraint' => '250',
				'null' => true,
			),

			'city' => array(
				'type' => 'varchar',
				'constraint' => '250',
			),

			'street' => array(
				'type' => 'varchar',
				'constraint' => '250',
			),

			'apt_no' => array(
				'type' => 'varchar',
				'constraint' => '250',
				'null' => true,
			),

			'postal_code' => array(
				'type' => 'varchar',
				'constraint' => '250',
			),

			'phone_number' => array(
				'type' => 'varchar',
				'constraint' => '250',
			),

			'device_id' => array(
				'type' => 'varchar',
				'constraint' => '250',
			),

			'type' => array(
				'type' => 'int',
			),
			
			'active' => array(
				'type' => 'boolean',
				'default' => 1,
			),

			'deleted' => array(
				'type'=>'boolean',
				'default'=> 0,
			),

			'created_at' => array(
				'type' => 'timestamp',
			),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('shipping');

	}

	public function down() {
		$this->dbforge->drop_table('shipping');
	}
}