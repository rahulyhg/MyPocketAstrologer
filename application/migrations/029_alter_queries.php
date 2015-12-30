<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_queries extends CI_Migration {

	public function up() {

		$fields = array(
                        'query' => array(
                                         'name' => 'query',
                                         'type' => 'varchar',
                                         'constraint' => '2000',
                                ),

                        'answer' => array(
                                         'name' => 'answer',
                                         'type' => 'varchar',
                                         'constraint' => '3000',
                                         'null' => true
                                ),
					);

		$this->dbforge->modify_column('queries', $fields);
	}

	public function down() {
		
		$fields = array(
                        'query' => array(
                                         'name' => 'query',
                                         'type' => 'varchar',
                                         'constraint' => '500',
                                ),

                        'answer' => array(
                                         'name' => 'answer',
                                         'type' => 'varchar',
                                         'constraint' => '500',
                                         'null' => true
                                ),
					);

		$this->dbforge->modify_column('queries', $fields);
	}

}