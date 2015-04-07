<?php

class ApiAuthentication extends BaseModel {

	/* Table Name */

	static $table_name = 'api_authentication';

	/* Public functions - Setters */

    public function set_user($user) {

    	if($user == '') {
			throw new Exception('Please Enter User');
        }

		$this->assign_attribute('user', $user);	
    }

    public function set_authentication_key($authentication_key) {

    	if($authentication_key == '') {
			throw new Exception('Please Enter Authentication Key');
        }

		$this->assign_attribute('authentication_key', $authentication_key);	
    }

	/* Public functions - Getters */

	public function get_user() {
		return $this->read_attribute('user');
	}

	public function get_authentication_key() {
		return $this->read_attribute('authentication_key');
	}

	/* Public functions - General */


	/* Public static functions */

	public static function create($params) {

		$api_authentication = new ApiAuthentication;

		$api_authentication->user = array_key_exists('user', $params) ? $params['user'] : null;
		$api_authentication->authentication_key = array_key_exists('authentication_key', $params) ? $params['authentication_key'] : null;

		return $api_authentication;
	}
}