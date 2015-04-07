<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_payments extends CI_Migration {

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

			'date' => array(
				'type' => 'datetime',
				'null' => false,
			),

			'amount' => array(
				'type' => 'varchar',
				'constraint' => '250',
			),

			'is_complete' => array(
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
		$this->dbforge->create_table('payments');

	}

	public function down() {
		$this->dbforge->drop_table('payments');
	}
}