<?php

class Query extends BaseModel {

	/* Table Name */

	static $table_name = 'queries';

	/* Associations */

	static $belongs_to = array(
		
		array(
            'user',
            'class_name' => 'User',
            'foreign_key' => 'user_id'
        ),
	);

	/* Public functions - Setters */

	public function set_user_id(User $user) {

		$user->check_is_valid();
		$this->assign_attribute('user_id', $user->id);
	}

	public function set_device_id($device_id) {

		if($device_id == '') {
			throw new Exception('Device ID is required.');
        }

		$this->assign_attribute('device_id', $device_id);	
	}

	public function set_query($query) {

		if($query == '') {
			throw new Exception('Please enter your query.');
        }

		$this->assign_attribute('query', $query);	
	}

	public function set_answer($answer) {
		$this->assign_attribute('answer', $answer);	
	}

	/* Public functions - Getters */

	public function get_user_id() {
		return $this->read_attribute('user_id');
	}

	public function get_device_id() {
		return $this->read_attribute('device_id');
	}

	public function get_query() {
		return $this->read_attribute('query');
	}

	public function get_answer() {
		return $this->read_attribute('answer');
	}

	/* Public static functions */

	public static function create($params) {

		$query = new Query;

		$query->check_if_exists($params['user'], $params['query'], $params['device_id']);

		$query->user_id = array_key_exists('user', $params) ? $params['user'] : null;
		$query->device_id = array_key_exists('device_id', $params) ? $params['device_id'] : null;
		$query->query = array_key_exists('query', $params) ? $params['query'] : null;
		$query->answer = array_key_exists('answer', $params) ? $params['answer'] : null;

		$query->save();

		$query->user->increment_queries_count();
		$query->user->save();

		return $query;
	}

	private function check_if_exists($user, $query, $device) {

		if(self::exists(array('user_id' => $user->id, 'query' => $query, 'device_id' => $device))) { 
				throw new Exception('Query already exists'); 
			}
	}
}