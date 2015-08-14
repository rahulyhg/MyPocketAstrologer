<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Order_natal_chart extends REST_Controller {

	public function index_get() {

		$current_user_id = $this->get('current_user_id');

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

			$natal_chart = NatalChart::find_by_user_id($current_user_id);

			if(!$natal_chart)
				throw new Exception("Natal Chart not found");

			if($natal_chart->status == 1)
				throw new Exception("Your Natal Chart is getting ready. Please Wait.");

			$natal_chart->status = 3;
			$natal_chart->save();
			
			$response = $this->response(array(
							'status' =>	'SUCCESS',
							'message' => 'Natal Chart ordered for shipping',
							'user_name' => $current_user->first_name,
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