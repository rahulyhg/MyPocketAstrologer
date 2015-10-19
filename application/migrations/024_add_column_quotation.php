<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_column_quotation extends CI_Migration {

	public function up() {
		
		$field = array(

			'approved' => array(
				'type' => 'boolean',
				'default' => 1,
			),
		);

		$this->dbforge->add_column('quotations', $field);
	}

	public function down() {
		$this->dbforge->drop_column('quotations','approved');
	}
}