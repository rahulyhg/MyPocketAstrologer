<?php

class NatalChart extends BaseModel {

	/* Table Name */

	static $table_name = 'natal_charts';

	/* Public functions - Setters */

	public function set_user(User $user) {

		$user->check_is_valid();
		$this->assign_attribute('user_id', $user->id);
	}

	public function set_natal_chart($natal_chart) {
		$this->assign_attribute('natal_chart', $natal_chart);	
	}

	public function set_status($status) {
		$this->assign_attribute('status', $status);	
	}

	/* Public functions - Getters */

	public function get_user() {
		return $this->read_attribute('user_id');
	}

	public function get_natal_chart() {
		return $this->read_attribute('natal_chart');
	}

	public function get_status() {
		return $this->read_attribute('status');
	}

	/* Public static functions */

	public static function create($params) {

		$natal_chart = new NatalChart;

		$natal_chart->user = array_key_exists('user', $params) ? $params['user'] : null;
		$natal_chart->natal_chart = array_key_exists('natal_chart', $params) ? $params['natal_chart'] : null;
		$natal_chart->status = array_key_exists('status', $params) ? $params['status'] : null;
		
		$natal_chart->save();

		return $natal_chart;
	}
}