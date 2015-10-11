<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_column_receipts extends CI_Migration {

	public function up() {
		
		$field = array(			

			'object_id' => array(
				'type' => 'int',
			),
		);

		$this->dbforge->add_column('receipts', $field);
	}

	public function down() {
		
		$this->dbforge->drop_column('receipts','object_id');
	}
}