<?php

class Zodiac extends BaseModel {

	/* Table Name */

	static $table_name = 'zodiac';

	/* Associations */

	static $has_many = array(
		
		array(
            'users',
            'class_name' => 'User',
            'foreign_key' => 'zodiac_id',
        ),
	);

	static $belongs_to = array(
		
		array(
            'color',
            'class_name' => 'Color',
            'foreign_key' => 'color_id'
        ),

        array(
            'gemstone',
            'class_name' => 'Gemstone',
            'foreign_key' => 'gemstone_id'
        ),
	);

	/* Public functions - Setters */

	/* Public functions - Getters */

	/* Public static functions */

}