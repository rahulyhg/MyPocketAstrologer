<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Order_gemstone extends REST_Controller {

	public function index_get() {

		$current_user_id = $this->get('current_user_id');

		try {
			
			if(empty($this->input->server('PHP_AUTH_USER')) || empty($this->input->server('PHP_AUTH_PW'))) {

	        	$this->message->set('Access Forbidden', 'error',TRUE,'feedback');
				redirect('users/users');
	        }

	        $api = ApiAuthentication::find_by_user_and_authentication_key($this->input->server('PHP_AUTH_USER'), $this->input->server('PHP_AUTH_PW'));
	        
	        if(!$api) 
	        	throw new Exception("Access Forbidden");

			$current_user = User::find_valid_by_id($current_user_id);

			if(!$current_user)
				throw new Exception("Invalid User Request");
				
			$gemstone = UserGemstone::find_by_user_id($current_user_id);

			if(!$gemstone)
				throw new Exception("Gemstone not found");			

			$response = $this->response(array(
							'status' =>	'SUCCESS',
							'message' => 'Gemstone is ordered for shipping',
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