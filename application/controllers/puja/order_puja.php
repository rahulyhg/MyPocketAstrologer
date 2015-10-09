<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Order_puja extends REST_Controller {

	public function index_get() {

		$current_user_id = $this->get('current_user_id');
		$puja_id = $this->get('puja_id');

		try {
			
			if(!$this->input->server('PHP_AUTH_USER') || !$this->input->server('PHP_AUTH_PW')) {

	        	throw new Exception("Access Forbidden!!");
	        }

	        $api = ApiAuthentication::find_by_user_and_authentication_key($this->input->server('PHP_AUTH_USER'), $this->input->server('PHP_AUTH_PW'));
	        
	        if(!$api) 
	        	throw new Exception("Access Forbidden");

			$current_user = User::find_valid_by_id($current_user_id);

			if(!$current_user)
				throw new Exception("Invalid User Request");

			$puja = Puja::find_by_id_and_status($puja_id, 1);

			if(!$puja)
				throw new Exception("Invalid Puja Request");

			$puja->status = 2;
			$puja->save();

			$response = $this->response(array(
							'status' =>	'SUCCESS',
							'message' => 'Puja ordered',
							'user' => $current_user->first_name,
							'data' => null,
							));
			
			$this->response($response);
		}

		catch(Exception $e) {

			$response = json_encode(array(
							'status' =>	'ERROR',
							'message' => $e->getMessage(),
							));
			
			header('HTTP/1.1 400 Bad Request', true, 400);

			echo $response;
		}
	}

	public function index_post() {

	}
}