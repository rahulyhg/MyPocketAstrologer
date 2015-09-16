<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_column_status_pujas extends CI_Migration {

	public function up() {
		
		$field = array(			

			'status' => array(
				'type' => 'int',
			),
		);

		$this->dbforge->add_column('pujas', $field);
		$this->dbforge->drop_column('pujas', 'is_complete');

	}

	public function down() {
		
		$this->dbforge->drop_column('pujas','status');

		$field = array(			

			'is_complete' => array(
				'type' => 'boolean',
				'default' => 0,
			),
		);

		$this->dbforge->add_column('pujas',$field);
	}

}