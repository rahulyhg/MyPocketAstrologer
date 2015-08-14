<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class User_Edit extends REST_Controller {

	public function index_get() {

	}

	public function index_post() {

		$params = json_decode(file_get_contents('php://input'),true);

		try {

			if(!$this->input->server('PHP_AUTH_USER') || !$this->input->server('PHP_AUTH_PW')) {

	        	throw new Exception("Access Forbidden!!");
	        }

	        $api = ApiAuthentication::find_by_user_and_authentication_key($this->input->server('PHP_AUTH_USER'), $this->input->server('PHP_AUTH_PW'));
	        
	        if(!$api) 
	        	throw new Exception("Access Forbidden");
			
			$user = User::find_valid_by_id($params['current_user_id']);

			if(!$user)
				throw new Exception("Invalid User Request");

			$user->first_name = $params['first_name'];
			$user->last_name = $params['last_name'];

			$user->save();

			$response = $this->response(array(
							'status'	=>	'SUCCESS',
							'message'=>'Profile Edited Successfully',
							'user'=> $user->first_name,
							'data' => null
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
}