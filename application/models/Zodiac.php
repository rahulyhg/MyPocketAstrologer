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

	/* Public functions - Setters */

	/* Public functions - Getters */

	/* Public static functions */

}