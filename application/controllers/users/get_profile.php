<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Get_profile extends REST_Controller {

	public function index_get() {

		$current_user_id = $this->get('current_user_id');

		try {
			
			if(empty($this->input->server('PHP_AUTH_USER') || empty($this->input->server('PHP_AUTH_PW')))) {

	        	$this->message->set('Access Forbidden', 'error',TRUE,'feedback');
				redirect('users/users');
	        }

	        $api = ApiAuthentication::find_by_user_and_authentication_key($this->input->server('PHP_AUTH_USER'), $this->input->server('PHP_AUTH_PW'));
	        
	        if(!$api) 
	        	throw new Exception("Access Forbidden");

			$current_user = User::find_by_id($current_user_id);

			if(!$current_user)
				throw new Exception("Invalid User Request");
				
			$user = array(
						'first_name' => $current_user->first_name,
						'last_name' => $current_user->last_name,
						'email' => $current_user->email,
						'gender' => $current_user->gender,
						'date_of_birth' => date('Y-m-d', strtotime($current_user->date_of_birth)),
						'time_of_birth' => date('H:i:s', strtotime($current_user->date_of_birth)),
						'is_accurate' => $current_user->is_accurate,
						'place_of_birth' => $current_user->place_of_birth,
						);

			$response = $this->response(array(
							'status' =>	'SUCCESS',
							'message' => 'User profile',
							'user_name' => $current_user->first_name,
							'data' => $user,
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