<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_columns_natal_charts extends CI_Migration {

	public function up() {
		
		$field = array(			

			'view_ordered' => array(
				'type' => 'boolean',
				'default' => 0,
			),

			'ship_ordered' => array(
				'type' => 'boolean',
				'default' => 0,
			),
		);

		$this->dbforge->add_column('natal_charts', $field);
	}

	public function down() {
		
		$this->dbforge->drop_column('natal_charts','view_ordered');
		$this->dbforge->drop_column('natal_charts','ship_ordered');
	}
}