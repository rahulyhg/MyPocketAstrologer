<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_user_gemstones extends CI_Migration {

	public function up() {

		$fields = array(
                        'color_id' => array(
                                         'name' => 'color',
                                         'type' => 'varchar',
                                         'constraint' => '256',
                                ),
					);

		$this->dbforge->modify_column('user_gemstones', $fields);
	}

	public function down() {
		
		$fields = array(
                        'color' => array(
                                         'name' => 'color_id',
                                         'type' => 'int',
                                ),
					);

		$this->dbforge->modify_column('user_gemstones', $fields);
	}
}