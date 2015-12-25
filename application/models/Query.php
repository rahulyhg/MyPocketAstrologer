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

	public function set_user(User $user) {

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

	public function set_asked_on($asked_on) {

		if($asked_on == '') {
			throw new Exception('Date required.');
        }

		$this->assign_attribute('asked_on', $asked_on);	
	}

	public function set_answered_on($answered_on) {
		$this->assign_attribute('answered_on', $answered_on);	
	}

	/* Public functions - Getters */

	public function get_device_id() {
		return $this->read_attribute('device_id');
	}

	public function get_query() {
		return $this->read_attribute('query');
	}

	public function get_answer() {
		return $this->read_attribute('answer');
	}

	public function get_asked_on() {
		return $this->read_attribute('asked_on');
	}

	public function get_answered_on() {
		return $this->read_attribute('answered_on');
	}

	/* Public static functions */

	public static function create($params) {

		$query = new Query;

		$query->check_if_exists($params['user'], $params['query'], $params['device_id']);

		$query->user = array_key_exists('user', $params) ? $params['user'] : null;
		$query->device_id = array_key_exists('device_id', $params) ? $params['device_id'] : null;
		$query->query = array_key_exists('query', $params) ? $params['query'] : null;
		$query->answer = array_key_exists('answer', $params) ? $params['answer'] : null;
		date_default_timezone_set("Asia/Kathmandu");
		$query->asked_on = date('Y-m-d H:i:s');

		$query->save();

		$query->user->increment_queries_count();
		$query->user->save();

		return $query;
	}

	public function delete() {

		parent::delete();

		$this->user->decrement_queries_count();
		$this->user->save();
	}

	private function check_if_exists($user, $query, $device) {

		if(self::exists(array('user_id' => $user->id, 'query' => $query, 'device_id' => $device))) { 
				throw new Exception('Query already exists'); 
			}
	}
}