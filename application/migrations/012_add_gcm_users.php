<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_gcm_users extends CI_Migration {

	public function up() {

		$fields = array(
		
			'id' => array(
				'type' => 'int',
				'auto_increment' => true,
			),

			'gcm_regd_id' => array(
				'type' => 'varchar',				
				'constraint'=>'250',
			),

			'device_id' => array(
				'type' => 'varchar',				
				'constraint'=>'250',
			),

			'user_id' => array(
				'type' => 'int',
			),

			'created_at' => array(
				'type' => 'timestamp',
			),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('gcm_users');

		//$this->db->query('ALTER TABLE gcm_users MODIFY modified_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
	}

	public function down() {
		$this->dbforge->drop_table('gcm_users');
	}
}