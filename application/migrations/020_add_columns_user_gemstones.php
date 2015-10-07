<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_columns_user_gemstones extends CI_Migration {

	public function up() {
		
		$field = array(			

			'color_id' => array(
				'type' => 'int',
			),

			'status' => array(
				'type' => 'int',
			),

			'ship_ordered' => array(
				'type' => 'boolean',
				'default' => 0,
			),
		);

		$this->dbforge->add_column('user_gemstones', $field);

		$fields = array(
                        'details' => array(
                                         'name' => 'details',
                                         'type' => 'varchar',
                                         'constraint' => '256',
                                         'null' => true,
                                ),
					);

		$this->dbforge->modify_column('user_gemstones', $fields);
	}

	public function down() {
		
		$this->dbforge->drop_column('user_gemstones','color_id');
		$this->dbforge->drop_column('user_gemstones','status');
		$this->dbforge->drop_column('user_gemstones','ship_ordered');

		$fields = array(
                        'details' => array(
                                         'name' => 'details',
                                         'type' => 'varchar',
                                         'constraint' => '256',
                                ),
					);

		$this->dbforge->modify_column('user_gemstones', $fields);
	}

}