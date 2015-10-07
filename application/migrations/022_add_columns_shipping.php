<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_columns_shipping extends CI_Migration {

	public function up() {
		
		$field = array(

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
		
		$this->dbforge->drop_column('shipping','gemstone_id');
		$this->dbforge->drop_column('shipping','completed');
	}
}