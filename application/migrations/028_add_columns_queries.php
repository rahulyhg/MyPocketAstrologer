<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_columns_queries extends CI_Migration {

	public function up() {

		$fields = array(
		
				'asked_on' => array(
					'type' => 'datetime',
	                'null' => false
				),

				'answered_on' => array(
					'type' => 'datetime',
	                'null' => true
				),
			);

		$this->dbforge->add_column('queries', $fields);
	}

	public function down() {
		
		$this->dbforge->drop_column('queries','asked_on');
		$this->dbforge->drop_column('queries','answered_on');
	}

}