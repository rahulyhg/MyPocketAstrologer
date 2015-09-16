<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_puja_images extends CI_Migration {

	public function up() {

		$fields = array(
		
			'id' => array(
				'type' => 'int',
				'auto_increment' => true,
			),

			'puja_id' => array(
				'type' => 'int',
			),

			'image' => array(
				'type' => 'varchar',
				'constraint' => '250',
			),

			'details' => array(
				'type' => 'varchar',
				'constraint' => '500',
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
		$this->dbforge->create_table('puja_images');

	}

	public function down() {
		$this->dbforge->drop_table('puja_images');
	}
}