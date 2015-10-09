<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_column_quotations extends CI_Migration {

	public function up() {
		
		$field = array(			

			'gemstone_id' => array(
				'type' => 'int',
			),
		);

		$this->dbforge->add_column('quotations', $field);
	}

	public function down() {
		
		$this->dbforge->drop_column('quotations','gemstone_id');
	}
}