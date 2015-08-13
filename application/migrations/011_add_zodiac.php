<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_zodiac extends CI_Migration {

	public function up() {

		$fields = array(
		
			'id' => array(
				'type' => 'int',
				'auto_increment' => true,
			),

			'zodiac' => array(
				'type' => 'varchar',				
				'constraint'=>'250'
			),

			'color' => array(
				'type' => 'varchar',				
				'constraint'=>'250'
			),

			'gemstone' => array(
				'type' => 'varchar',
				'constraint'=>'250',
			),
			
			'carat' => array(
				'type' => 'varchar',
				'constraint'=>'250',
			),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('zodiac');

		//$this->db->query('ALTER TABLE zodiac MODIFY modified_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');

		$data =  array(

					'id'=>1,
					'zodiac' => 'Mesh',
					'color' => 'Red',
					'gemstone' => 'Red Coral',
					'carat'=> '4 or 6',
				);

		$this->db->insert('zodiac', $data);

		$data =  array(

					'id'=>2,
					'zodiac' => 'Brish',
					'color' => 'White',
					'gemstone' => 'Diamond',
					'carat'=> '2 or 7',
				);

		$this->db->insert('zodiac', $data);

		$data =  array(

					'id'=>3,
					'zodiac' => 'Mithun',
					'color' => 'Green',
					'gemstone' => 'Emerald',
					'carat'=> '3 or 6',
				);

		$this->db->insert('zodiac', $data);

		$data =  array(

					'id'=> 4,
					'zodiac' => 'Karkat',
					'color' => 'White',
					'gemstone' => 'Pearl',
					'carat'=> '4',
				);

		$this->db->insert('zodiac', $data);

		$data =  array(

					'id'=> 5,
					'zodiac' => 'Simha',
					'color' => 'Grey',
					'gemstone' => 'Ruby',
					'carat'=> '5',
				);

		$this->db->insert('zodiac', $data);

		$data =  array(

					'id'=> 6,
					'zodiac' => 'Kanya',
					'color' => 'Green',
					'gemstone' => 'Emerald',
					'carat'=> '4 or 6',
				);

		$this->db->insert('zodiac', $data);

		$data =  array(

					'id'=> 7,
					'zodiac' => 'Tula',
					'color' => 'Cream',
					'gemstone' => 'Diamond',
					'carat'=> '2 or 7',
				);

		$this->db->insert('zodiac', $data);

		$data =  array(

					'id'=> 8,
					'zodiac' => 'Brischik',
					'color' => 'Pink',
					'gemstone' => 'Red Coral',
					'carat'=> '4 or 6',
				);

		$this->db->insert('zodiac', $data);

		$data =  array(

					'id'=> 9,
					'zodiac' => 'Dhanu',
					'color' => 'Yellow',
					'gemstone' => 'Topaz',
					'carat'=> '9',
				);

		$this->db->insert('zodiac', $data);

		$data =  array(

					'id'=> 10,
					'zodiac' => 'Makar',
					'color' => 'Blue',
					'gemstone' => 'Blue Sapphire',
					'carat'=> '1 or 8',
				);

		$this->db->insert('zodiac', $data);

		$data =  array(

					'id'=> 11,
					'zodiac' => 'Kumbha',
					'color' => 'Sky Blue',
					'gemstone' => 'Blue Sapphire',
					'carat'=> '1 or 8',
				);

		$this->db->insert('zodiac', $data);

		$data =  array(

					'id'=> 12,
					'zodiac' => 'Min',
					'color' => 'Yellow',
					'gemstone' => 'Topaz',
					'carat'=> '9',
				);

		$this->db->insert('zodiac', $data);
	}

	public function down() {
		$this->dbforge->drop_table('zodiac');
	}
}