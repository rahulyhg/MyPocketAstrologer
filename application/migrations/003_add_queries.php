<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_queries extends CI_Migration {

	public function up() {

		$fields = array(
		
			'id' => array(
				'type' => 'int',
				'auto_increment' => true,
			),

			'user_id' => array(
				'type' => 'int',
			),

			'device_id' => array(
				'type' => 'varchar',
				'constraint' => '256',
			),

			'query' => array(
				'type' => 'varchar',				
				'constraint'=>'500'
			),

			'answer' => array(
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
			
			'created_at' => array(
				'type' => 'timestamp',
			),
			
			'modified_at' => array(
				'type' => 'timestamp',
			),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('queries');

	}

	public function down() {
		$this->dbforge->drop_table('queries');
	}
}