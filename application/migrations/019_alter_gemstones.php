<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_gemstones extends CI_Migration {

	public function up() {

		$fields = array(
                        'details' => array(
                                         'name' => 'details',
                                         'type' => 'varchar',
                                         'constraint' => '256',
                                         'null' => true,
                                ),
					);

		$this->dbforge->modify_column('gemstones', $fields);
		$this->dbforge->drop_column('gemstones', 'color');

		$data =  array(
					'id'=> 1,
					'name' => 'Red Coral',
					'details'=> '',
				);

		$this->db->insert('gemstones', $data);

		$data =  array(
					'id'=> 2,
					'name' => 'Diamond',
					'details'=> '',
				);

		$this->db->insert('gemstones', $data);

		$data =  array(
					'id'=> 3,
					'name' => 'Emerald',
					'details'=> '',
				);

		$this->db->insert('gemstones', $data);

		$data =  array(
					'id'=> 4,
					'name' => 'Pearl',
					'details'=> '',
				);

		$this->db->insert('gemstones', $data);

		$data =  array(
					'id'=> 5,
					'name' => 'Ruby',
					'details'=> '',
				);

		$this->db->insert('gemstones', $data);

		$data =  array(
					'id'=> 6,
					'name' => 'Topaz',
					'details'=> '',
				);

		$this->db->insert('gemstones', $data);

		$data =  array(
					'id'=> 7,
					'name' => 'Blue Sapphire',
					'details'=> '',
				);

		$this->db->insert('gemstones', $data);
	}

	public function down() {
		
		$fields = array(
                        'details' => array(
                                         'name' => 'details',
                                         'type' => 'varchar',
                                         'constraint' => '256',
                                ),
					);

		$this->dbforge->modify_column('gemstones', $fields);

		$field = array(			

			'color' => array(
				'type' => 'varchar',				
				'constraint'=>'250'
			),
		);

		$this->dbforge->add_column('gemstones',$field);
	}

}