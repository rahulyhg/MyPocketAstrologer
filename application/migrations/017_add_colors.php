<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_colors extends CI_Migration {

	public function up() {

		$fields = array(
		
			'id' => array(
				'type' => 'int',
				'auto_increment' => true,
			),

			'color' => array(
				'type' => 'varchar',				
				'constraint'=>'250'
			),

			'details' => array(
				'type' => 'varchar',				
				'constraint'=>'250',
				'null' => true
			),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('colors');

		$data =  array(

					'id'=> 1,
					'color' => 'Red',
					'details'=> '',
				);

		$this->db->insert('colors', $data);

		$data =  array(

					'id'=> 2,
					'color' => 'White',
					'details'=> '',
				);

		$this->db->insert('colors', $data);

		$data =  array(

					'id'=> 3,
					'color' => 'Green',
					'details'=> '',
				);

		$this->db->insert('colors', $data);

		$data =  array(

					'id'=> 4,
					'color' => 'Grey',
					'details'=> '',
				);

		$this->db->insert('colors', $data);

		$data =  array(

					'id'=> 5,
					'color' => 'Cream',
					'details'=> '',
				);

		$this->db->insert('colors', $data);

		$data =  array(

					'id'=> 6,
					'color' => 'Pink',
					'details'=> '',
				);

		$this->db->insert('colors', $data);

		$data =  array(

					'id'=> 7,
					'color' => 'Yellow',
					'details'=> '',
				);

		$this->db->insert('colors', $data);

		$data =  array(

					'id'=> 8,
					'color' => 'Blue',
					'details'=> '',
				);

		$this->db->insert('colors', $data);

		$data =  array(

					'id'=> 9,
					'color' => 'Sky Blue',
					'details'=> '',
				);

		$this->db->insert('colors', $data);
	}

	public function down() {
		$this->dbforge->drop_table('colors');
	}
}