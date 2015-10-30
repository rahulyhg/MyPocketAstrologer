<?php

class PushNotificationLog extends BaseModel {

	/* Table Name */

	static $table_name = 'push_notification_log';

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

	public function set_object_type($object_type) {
		$this->assign_attribute('object_type', $object_type);	
	}

	public function set_notification_type($notification_type) {

		if(!$notification_type) {
			throw new Exception('Push Notification Type required.');
        }

		$this->assign_attribute('notification_type', $notification_type);	
	}

	public function set_information_type($information_type) {
		$this->assign_attribute('information_type', $information_type);	
	}

	public function set_object_id($object_id) {
		$this->assign_attribute('object_id', $object_id);	
	}

	public function set_details($details) {
		$this->assign_attribute('details', $details);	
	}

	/*
		----NOTE----

	For object_type:
		Natal Chart = 1
		Gemstone = 2
		Puja = 3
		Query = 4
		User/Profile = 5

	For notification_type:
		TYPE_VIEW_NATAL_CHART=1
		TYPE_NATAL_CHART_SHIPPED = 2
		TYPE_PUJA=3
		TYPE_GEMS_STONE=4
		TYPE_QUERY_ANSWER=5
		TYPE_QUOTATION=6
		TYPE_PROFILE=7
		TYPE_GLOBAL=8
		TYPE_NATAL_CHART_READY (uploaded) = 9

	For information_type:
		In case of Natal Chart,
			(2: in process, 3: shipping done)
		In Case of Gemstone,
			(1: sugestion, 2: in process, 3: shipping done)
		In case of Puja,
			(1: sugestion, 2: in process,3: Puja done)

	*/

	/* Public functions - Getters */

	public function get_object_type() {
		return $this->read_attribute('object_type');
	}

	public function get_notification_type() {
		return $this->read_attribute('notification_type');
	}

	public function get_information_type() {
		return $this->read_attribute('information_type');
	}

	public function get_object_id() {
		return $this->read_attribute('object_id');
	}

	public function get_details() {
		return $this->read_attribute('details');
	}

	/* Public static functions */

	public static function create($params) {

		$push = new PushNotificationLog;

		$push->user = array_key_exists('user', $params) ? $params['user'] : null;
		$push->object_type = array_key_exists('object_type', $params) ? $params['object_type'] : 0;
		$push->notification_type = array_key_exists('notification_type', $params) ? $params['notification_type'] : 0;
		$push->information_type = array_key_exists('information_type', $params) ? $params['information_type'] : 0;
		$push->object_id = array_key_exists('object_id', $params) ? $params['object_id'] : 0;
		$push->details = array_key_exists('details', $params) ? $params['details'] : null;

		$push->save();
		return $push;
	}
}