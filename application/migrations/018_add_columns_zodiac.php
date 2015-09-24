<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_columns_zodiac extends CI_Migration {

	public function up() {
		
		$field = array(

			'details' => array(
				'type' => 'varchar',				
				'constraint'=>'250'
			),		

			'color_id' => array(
				'type' => 'int',
			),

			'gemstone_id' => array(
				'type' => 'int',
			),
		);

		$this->dbforge->add_column('zodiac', $field);

		$data = array(
               'gemstone_id' => 1,
               'color_id' => 1,
            );

		$this->db->update('zodiac', $data, array('id' => 1));

		$data = array(
               'gemstone_id' => 2,
               'color_id' => 2,
            );
		
		$this->db->update('zodiac', $data, array('id' => 2));

		$data = array(
               'gemstone_id' => 3,
               'color_id' => 3,
            );
		
		$this->db->update('zodiac', $data, array('id' => 3));

		$data = array(
               'gemstone_id' => 4,
               'color_id' => 2,
            );
		
		$this->db->update('zodiac', $data, array('id' => 4));

		$data = array(
               'gemstone_id' => 5,
               'color_id' => 4,
            );
		
		$this->db->update('zodiac', $data, array('id' => 5));

		$data = array(
               'gemstone_id' => 3,
               'color_id' => 3,
            );
		
		$this->db->update('zodiac', $data, array('id' => 6));

		$data = array(
               'gemstone_id' => 2,
               'color_id' => 5,
            );
		
		$this->db->update('zodiac', $data, array('id' => 7));

		$data = array(
               'gemstone_id' => 1,
               'color_id' => 6,
            );
		
		$this->db->update('zodiac', $data, array('id' => 8));

		$data = array(
               'gemstone_id' => 6,
               'color_id' => 7,
            );
		
		$this->db->update('zodiac', $data, array('id' => 9));

		$data = array(
               'gemstone_id' => 7,
               'color_id' => 8,
            );
		
		$this->db->update('zodiac', $data, array('id' => 10));

		$data = array(
               'gemstone_id' => 7,
               'color_id' => 9,
            );
		
		$this->db->update('zodiac', $data, array('id' => 11));

		$data = array(
               'gemstone_id' => 6,
               'color_id' => 7,
            );
		
		$this->db->update('zodiac', $data, array('id' => 12));
	}

	public function down() {
		
		$this->dbforge->drop_column('zodiac','gemstone_id');
		$this->dbforge->drop_column('zodiac','color_id');
		$this->dbforge->drop_column('zodiac','details');
	}

}