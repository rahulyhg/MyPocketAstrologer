<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Password_reset extends REST_Controller {

	public function index_get() {

	}

	public function index_post() {
		
		try {
			
			$user = User::find_by_id($this->post('current_user_id'));

			if(!$user)
				throw new Exception("Invalid User Request");

			$user->reset_password($this->post('password'), $this->post('confirm_password'));
			$user->password = $this->post('password');

			$user->save();

			$response = $this->response(array(
							'status'	=>	'SUCCESS',
							'message'=>'Password Reset Successfully',
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