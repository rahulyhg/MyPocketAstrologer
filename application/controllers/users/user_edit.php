<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class User_Edit extends REST_Controller {

	public function index_get() {

	}

	public function index_post() {

		try {
			
			$user = User::find_valid_by_id($this->post('current_user_id'));

			if(!$user)
				throw new Exception("Invalid User Request");

			$user->first_name = $this->post('first_name');
			$user->last_name = $this->post('last_name');
			$user->email = $this->post('email');
			$user->gender = $this->post('gender');
			$user->date_of_birth = $this->post('date_of_birth')." ".$this->post('time_of_birth');
			$user->is_accurate = $this->post('is_accurate');
			$user->place_of_birth = $this->post('place_of_birth');

			$user->save();

			$response = $this->response(array(
							'status'	=>	'SUCCESS',
							'message'=>'Profile Edited Successfully',
							'user'=> $params['first_name'],
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