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

			$login_device = LoginDevice::create($params);

			$this->session->set_userdata(array(
                'user_id' => $user->id,
                'user_email' => $user->email,
                'device_id' => $this->post('device_id'),
            ));

			$response = $this->response(array(
							'status'	=>	'SUCCESS',
							'user'=> $user->first_name,
							'message'=>'Logged in Successfully'
							));
			
			$this->response($response, HTTP_OK);
		}

		catch(Exception $e) {
			$this->response($e->getMessage());
		}
	}
}