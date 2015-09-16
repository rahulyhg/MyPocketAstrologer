<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Forgot_password extends REST_Controller {

	public function index_get() {

	}

	public function index_post() {
		
		try {

			$date_of_birth = $this->post('date_of_birth').' '.$this->post('time_of_birth');

			$user = User::find_by_email_and_date_of_birth($this->post('email'), $date_of_birth);

			if(!$user)
				throw new Exception("Invalid Credentials provided");

			$response = $this->response(array(
							'status'	=>	'SUCCESS',
							'message'=>'Verified credentials',
							'user'=> $params['first_name'],
							'data' => array('user_id' => $user->id)
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