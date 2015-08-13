<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Shipping_order extends REST_Controller {

	public function index_get() {

	}

	public function index_post() {

		$params = json_decode(file_get_contents('php://input'),true);
		//print_r($params); exit();

		try {
			
			if(!$this->input->server('PHP_AUTH_USER') || !$this->input->server('PHP_AUTH_PW')) {

	        	throw new Exception("Access Forbidden!!");
	        }

	        $api = ApiAuthentication::find_by_user_and_authentication_key($this->input->server('PHP_AUTH_USER'), $this->input->server('PHP_AUTH_PW'));
	        
	        if(!$api) 
	        	throw new Exception("Access Forbidden");

			$current_user = User::find_by_id($params['current_user_id']);

			if(!$current_user)
				throw new Exception("Invalid User Request");

			$params['user'] = $current_user;
		
			$new_shipping = new Shipping();
			$shipping = $new_shipping->create($params);

			$response = $this->response(array(
							'status' =>	'SUCCESS',
							'message' => 'Shipping order saved successfully',
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
}