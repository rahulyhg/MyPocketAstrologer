<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_columns_zodiac extends CI_Migration {

	public function up() {

		$fields = array(

			'gemstone_details' => array(
				'type' => 'varchar',				
				'constraint'=>'250'
			),		

			'color_details' => array(
				'type' => 'varchar',				
				'constraint'=>'250'
			),
		);

		$this->dbforge->add_column('zodiac', $fields);
		$this->dbforge->drop_column('zodiac','color_id');

		$data = array(
			   'zodiac' => 'Mesha',
               'details' => 'According to your Natal chart, the Moon is positioned in Mesha Rashi. Hence your Zodiac Sign is Mesha.',
               'gemstone_details' => 'As per your Natal Chart, the lord of the Mesha Zodiac Sign is Mars, hence the gemstone for your Zodiac sign is Red Coral.',
               'color_details' => 'Mars being the lord of Mesha Zodiac Sign, the color favourable for your Zodiac sign is Red.',
            );

		$this->db->update('zodiac', $data, array('id' => 1));

		$data = array(
			   'zodiac' => 'Brisha',
               'details' => 'According to your Natal chart, the Moon is positioned in Brisha Rashi. Hence your Zodiac Sign is Brisha.',
               'gemstone_details' => 'As per your Natal Chart, the lord of the Brisha Zodiac Sign is Venus, hence the gemstone for your Zodiac sign is Diamond.',
               'color_details' => 'Mars being the lord of Brisha Zodiac Sign, the color favourable for your Zodiac sign is White.',
            );
		
		$this->db->update('zodiac', $data, array('id' => 2));

		$data = array(
			   'zodiac' => 'Mithuna',
               'details' => 'According to your Natal chart, the Moon is positioned in Mithuna Rashi. Hence your Zodiac Sign is Mithuna.',
               'gemstone_details' => 'As per your Natal Chart, the lord of the Mithuna Zodiac Sign is Mercury, hence the gemstone for your Zodiac sign is Emerald.',
               'color_details' => 'Mercury being the lord of Mithuna Zodiac Sign, the color favourable for your Zodiac sign is Green.',
            );
		
		$this->db->update('zodiac', $data, array('id' => 3));

		$data = array(
               'zodiac' => 'Karkata',
               'details' => 'According to your Natal chart, the Moon is positioned in Karkata Rashi. Hence your Zodiac Sign is Karkata.',
               'gemstone_details' => 'As per your Natal Chart, the lord of the Karkata Zodiac Sign is Moon, hence the gemstone for your Zodiac sign is Pearl.',
               'color_details' => 'Moon being the lord of Karkata Zodiac Sign, the color favourable for your Zodiac sign is White.',
            );
		
		$this->db->update('zodiac', $data, array('id' => 4));

		$data = array(
			   'color' => 'Red and Grey',
               'details' => 'According to your Natal chart, the Moon is positioned in Simha Rashi. Hence your Zodiac Sign is Simha.',
               'gemstone_details' => 'As per your Natal Chart, the lord of the Simha Zodiac Sign is Sun, hence the gemstone for your Zodiac sign is Ruby.',
               'color_details' => 'Sun being the lord of Simha Zodiac Sign, the colors favourable for your Zodiac sign are Red and Grey.',
            );
		
		$this->db->update('zodiac', $data, array('id' => 5));

		$data = array(
               'details' => 'According to your Natal chart, the Moon is positioned in Kanya Rashi. Hence your Zodiac Sign is Kanya.',
               'gemstone_details' => 'As per your Natal Chart, the lord of the Kanya Zodiac Sign is Mercury, hence the gemstone for your Zodiac sign is Emerald.',
               'color_details' => 'Mercury being the lord of Kanya Zodiac Sign, the color favourable for your Zodiac sign is Green.',
            );
		
		$this->db->update('zodiac', $data, array('id' => 6));

		$data = array(
			   'color' => 'White',
               'details' => 'According to your Natal chart, the Moon is positioned in Tula Rashi. Hence your Zodiac Sign is Tula.',
               'gemstone_details' => 'As per your Natal Chart, the lord of the Tula Zodiac Sign is Venus, hence the gemstone for your Zodiac sign is Diamond.',
               'color_details' => 'Mars being the lord of Tula Zodiac Sign, the color favourable for your Zodiac sign is White.',
            );
		
		$this->db->update('zodiac', $data, array('id' => 7));

		$data = array(
			   'zodiac' => 'Brischika',
			   'color' => 'Red',
               'details' => 'According to your Natal chart, the Moon is positioned in Brishchika Rashi. Hence your Zodiac Sign is Brishchika.',
               'gemstone_details' => 'As per your Natal Chart, the lord of the Brishchika Zodiac Sign is Mars, hence the gemstone for your Zodiac sign is Red Coral.',
               'color_details' => 'Mars being the lord of Brishchika Zodiac Sign, the color favourable for your Zodiac sign is Red.',
            );
		
		$this->db->update('zodiac', $data, array('id' => 8));

		$data = array(
			   'gemstone' => 'Yellow Sapphire',
			   'gemstone_id' => 8,
               'details' => 'According to your Natal chart, the Moon is positioned in Dhanu Rashi. Hence your Zodiac Sign is Dhanu.',
               'gemstone_details' => 'As per your Natal Chart, the lord of the Dhanu Zodiac Sign is Jupiter, hence the gemstone for your Zodiac sign is Yellow Sapphire.',
               'color_details' => 'Jupiter being the lord of Dhanu Zodiac Sign, the color favourable for your Zodiac sign is Yellow.',
            );
		
		$this->db->update('zodiac', $data, array('id' => 9));

		$data = array(
			   'zodiac' => 'Makara',
			   'color' => 'Purple and Black',
               'details' => 'According to your Natal chart, the Moon is positioned in Makara Rashi. Hence your Zodiac Sign is Makara.',
               'gemstone_details' => 'As per your Natal Chart, the lord of the Makara Zodiac Sign is Saturn, hence the gemstone for your Zodiac sign is Blue Sapphire.',
               'color_details' => 'Saturn being the lord of Makara Zodiac Sign, the colors favourable for your Zodiac sign are Purple and Black.',
            );
		
		$this->db->update('zodiac', $data, array('id' => 10));

		$data = array(
			   'color' => 'Purple and Black',
               'details' => 'According to your Natal chart, the Moon is positioned in Kumbha Rashi. Hence your Zodiac Sign is Kumbha.',
               'gemstone_details' => 'As per your Natal Chart, the lord of the Kumbha Zodiac Sign is Saturn, hence the gemstone for your Zodiac sign is Blue Sapphire.',
               'color_details' => 'Saturn being the lord of Kumbha Zodiac Sign, the colors favourable for your Zodiac sign are Purple and Black.',
            );
		
		$this->db->update('zodiac', $data, array('id' => 11));

		$data = array(
			   'zodiac' => 'Meena',
			   'gemstone' => 'Yellow Sapphire',
			   'gemstone_id' => 8,
               'details' => 'According to your Natal chart, the Moon is positioned in Meena Rashi. Hence your Zodiac Sign is Meena.',
               'gemstone_details' => 'As per your Natal Chart, the lord of the Meena Zodiac Sign is Jupiter, hence the gemstone for your Zodiac sign is Yellow Sapphire.',
               'color_details' => 'Jupiter being the lord of Meena Zodiac Sign, the color favourable for your Zodiac sign is Yellow.',
            );
		
		$this->db->update('zodiac', $data, array('id' => 12));
	}

	public function down() {

		$field = array(

			'color_id' => array(
				'type' => 'int',
			),
		);

		$this->dbforge->add_column('zodiac', $field);

		$this->dbforge->drop_column('zodiac','color_details');
		$this->dbforge->drop_column('zodiac','gemstone_details');
	}
}