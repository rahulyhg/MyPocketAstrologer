<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_shipping extends CI_Migration {

	public function up() {

		$fields = array(
		
				'ordered_date' => array(
					'type' => 'datetime',
	                'null' => false
				),

				'processed_date' => array(
					'type' => 'datetime',
	                'null' => true
				),
			);

		$this->dbforge->add_column('shipping', $fields);
	}

	public function down() {
		
		$this->dbforge->drop_column('shipping','ordered_date');
		$this->dbforge->drop_column('shipping','processed_date');
	}
}