<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_natal_charts extends CI_Migration {

	public function up() {

		$fields = array(
		
			'id' => array(
				'type' => 'int',
				'auto_increment' => true,
			),

			'user_id' => array(
				'type' => 'int',
				'default' => 0,
			),

			'natal_chart' => array(
				'type' => 'varchar',
				'constraint' => '250',
				'null' => true,
			),

			'status' => array(
				'type' => 'int',
				'default' => 0,
			),
			
			'active' => array(
				'type' => 'boolean',
				'default' => 1,
			),

			'deleted' => array(
				'type'=>'boolean',
				'default'=> 0,
			),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('natal_charts');

	}

	public function down() {
		$this->dbforge->drop_table('natal_charts');
	}
}