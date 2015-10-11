<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_columns_shipping extends CI_Migration {

	public function up() {
		
		$field = array(

			'full_name' => array(
				'type' => 'varchar',
				'constraint' => '256',
			),

			'gemstone_id' => array(
				'type' => 'int',
			),

			'completed' => array(
				'type' => 'boolean',
				'default' => 0,
			),
		);

		$this->dbforge->add_column('shipping', $field);
	}

	public function down() {
		
		$this->dbforge->drop_column('shipping','full_name');
		$this->dbforge->drop_column('shipping','gemstone_id');
		$this->dbforge->drop_column('shipping','completed');
	}
}