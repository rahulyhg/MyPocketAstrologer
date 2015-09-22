<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Reset_password extends REST_Controller {

	public function index_get() {

	}

	public function index_post() {
		
		try {

			$params = json_decode(file_get_contents('php://input'),true);
			
			$user = User::find_by_id($params['user_id']);

			if(!$user)
				throw new Exception("Invalid User Request");

			$user->reset_password($params['password'], $params['confirm_password']);
			$user->password = $params['password'];

			$user->save();

			$response = $this->response(array(
							'status'	=>	'SUCCESS',
							'message'=>'Password Reset Successfully',
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