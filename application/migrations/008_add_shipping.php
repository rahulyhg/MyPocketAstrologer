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
			),

			'country' => array(
				'type' => 'varchar',
				'constraint' => '250',
			),

			'city' => array(
				'type' => 'varchar',
				'constraint' => '250',
			),

			'street' => array(
				'type' => 'varchar',
				'constraint' => '250',
			),

			'house' => array(
				'type' => 'varchar',
				'constraint' => '250',
			),

			'zip_code' => array(
				'type' => 'varchar',
				'constraint' => '250',
			),

			'phone_number' => array(
				'type' => 'varchar',
				'constraint' => '250',
			),

			'date' => array(
				'type' => 'datetime',
				'null' => 'true',
			),

			'is_delivered' => array(
				'type' => 'boolean',
				'default' => 0,
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
		$this->dbforge->create_table('shipping');

	}

	public function down() {
		$this->dbforge->drop_table('shipping');
	}
}