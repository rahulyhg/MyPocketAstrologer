<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_push_notification_log extends CI_Migration {

	public function up() {

		$fields = array(
		
			'id' => array(
				'type' => 'int',
				'auto_increment' => true,
			),

			'user_id' => array(
				'type' => 'int',
			),

			'object_type' => array(
				'type' => 'int',
				'default' => 0,
			),

			'notification_type' => array(
				'type' => 'int',
				'default' => 0,
			),

			'information_type' => array(
				'type' => 'int',
				'default' => 0,
			),

			'object_id' => array(
				'type' => 'int',
				'default' => 0,
			),

			'details' => array(
				'type' => 'varchar',
				'constraint' => '250',
				'null' => true,
			),

			'created_at' => array(
				'type' => 'timestamp',
			),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('push_notification_log');

	}

	public function down() {
		$this->dbforge->drop_table('push_notification_log');
	}
}