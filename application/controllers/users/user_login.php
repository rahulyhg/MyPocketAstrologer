<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class User_Login extends REST_Controller {

	public function index_get() {

	}

	public function index_post() {
		
		$params = array(
						'email' => $this->post('email'),
						'password' => $this->post('password'),
						'device_id' => $this->post('device_id'),
						);
		try {
			
			$user = User::find_valid_by_email_and_user_type($params['email'],2);
			$user->login($params['password']);

			$params['user'] = $user;
			$login_device = LoginDevice::create($params);

			$response = $this->response(array(
							'status'	=>	'SUCCESS',
							'message'=>'Logged in Successfully',
							'user'=> $user->first_name,
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
}