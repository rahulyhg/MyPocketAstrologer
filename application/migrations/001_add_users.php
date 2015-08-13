<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_users extends CI_Migration {

	public function up() {

		$fields = array(
		
			'id' => array(
				'type' => 'int',
				'auto_increment' => true,
			),

			'first_name' => array(
				'type' => 'varchar',				
				'constraint'=>'250'
			),

			'last_name' => array(
				'type' => 'varchar',				
				'constraint'=>'250'
			),

			'profile_pic' => array(
				'type' => 'varchar',
				'constraint'=>'250',
				'null' => true,
			),
			
			'email' => array(
				'type' => 'varchar',
				'constraint'=>'250',
				'null' => False,
			),

			'password' => array(
				'type' => 'varchar',
				'constraint' => '250',
				'null' => False,
			),

			'gender' => array(
				'type' => 'boolean',
				'default' => 0,
			),

			'date_of_birth' => array(
				'type' => 'datetime',
				'null' => False,
			),

			'is_accurate' => array(
				'type' => 'boolean',
				'default' => 0,
			),

			'place_of_birth' => array(
				'type' => 'varchar',
				'constraint' => '250',
				'null' => False,
			),

			'user_type' => array(
				'type' => 'int',
			),

			'left_palm' => array(
				'type' => 'varchar',
				'constraint' => '250',
				'null' => true,
			),

			'right_palm' => array(
				'type' => 'varchar',
				'constraint' => '250',
				'null' =>true,
			),

			'queries_count' => array(
				'type' => 'int',
			),

			'ring_size' => array(
				'type' => 'int',
				'default' => 0,
			),

			'zodiac_id' => array(
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
			
			'created_at' => array(
				'type' => 'timestamp',
			),
			
			'modified_at' => array(
				'type' => 'timestamp',
			),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('users');

		//$this->db->query('ALTER TABLE users MODIFY modified_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');

		$data =  array(

					'id'=>1,
					'first_name' => 'admin',
					'last_name' => 'admin',
					'email' => 'admin@astroveda.com',
					'password'=> sha1('pocketastro'),
					'date_of_birth' => '1990-01-10',
					'place_of_birth' => 'Nepal',
					'user_type' => '1',
				);

		$this->db->insert('users', $data);

	}

	public function down() {
		$this->dbforge->drop_table('users');
	}
}