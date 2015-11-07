<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_column_price_pujas extends CI_Migration {

	public function up() {
		
		$field = array(			

			'price' => array(
				'type' => 'int',
			),
		);

		$this->dbforge->add_column('pujas', $field);

	}

	public function down() {		
		$this->dbforge->drop_column('pujas','price');
	}
}