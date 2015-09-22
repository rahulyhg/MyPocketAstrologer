<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_receipts extends CI_Migration {

	public function up() {

		$fields = array(
		
			'id' => array(
				'type' => 'int',
				'auto_increment' => true,
			),

			'user_id' => array(
				'type' => 'int',
			),

			'type' => array(
				'type' => 'int',
				'default' => 0,
			),

			'amount' => array(
				'type' => 'int',
				'default' => 0,
			),

			'receipt_number' => array(
				'type' => 'varchar',
				'constraint' => "250"
			),

			'device_id' => array(
				'type' => 'varchar',
				'constraint' => "250"
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
				'type' => "timestamp"
				),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('receipts');

	}

	public function down() {
		$this->dbforge->drop_table('receipts');
	}
}