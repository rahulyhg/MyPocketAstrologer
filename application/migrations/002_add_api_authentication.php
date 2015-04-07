<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_api_authentication extends CI_Migration {

	public function up() {

		$fields = array(
		
			'id' => array(
				'type' => 'int',
				'auto_increment' => true,
			),

			'user' => array(
				'type' => 'varchar',				
				'constraint'=>'250'
			),

			'authentication_key' => array(
				'type' => 'varchar',				
				'constraint'=>'250'
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
		$this->dbforge->create_table('api_authentication');

		$data =  array(

					'id'=>1,
					'user' => 'author',
					'authentication_key' => '1234567890987654321',
				);

		$this->db->insert('api_authentication', $data);

	}

	public function down() {

		$this->dbforge->drop_table('api_authentication');

	}
}