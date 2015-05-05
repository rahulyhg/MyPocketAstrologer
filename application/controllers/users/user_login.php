<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class User_Login extends REST_Controller {

	public function index_get() {

	}

	public function index_post() {
		
		$params = json_decode(file_get_contents('php://input'),true);

		try {
			
			$user = User::find_valid_by_email_and_user_type($params['email'],2);
			$user->login($params['password']);

			$params['user'] = $user;
			$login_device = LoginDevice::create($params);

			$response = $this->response(array(
							'status'	=>	'SUCCESS',
							'message'=>'Logged in Successfully'
							'user'=> $user->first_name,
							'data' => $user,
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