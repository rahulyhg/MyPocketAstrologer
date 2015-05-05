<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Count_query extends REST_Controller {

	public function index_get() {

	}

	public function index_post() {

		$params = json_decode(file_get_contents('php://input'),true);

		try {

			$current_user = User::find_by_id($params['current_user_id']);

			$response = $this->response(array(
							'status' =>	'SUCCESS',
							'message' => 'Count of previous queries from user',
							'queries_count' => $current_user->queries_count,
							'data' => null,
							));
			
			$this->response($response);
		}

		catch(Exception $e) {

			$response = $this->response(array(
							'status' =>	'ERROR',
							'message' => $e->getMessage(),
							'user' => null,
							'data' => null
							));
			
			$this->response($response);
		}
	}
}