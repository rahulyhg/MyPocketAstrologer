<?php

class ActiveRecord_Base extends ActiveRecord\Model {

	public function __construct ($attributes=array(), $guard_attributes=TRUE, $instantiating_via_find=FALSE, $new_record=TRUE) {
		parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
	}

	public static function found_rows() {
        return static::connection()->query_and_fetch_one('SELECT FOUND_ROWS()');
    }

}