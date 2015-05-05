<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class New_query extends REST_Controller {

	public function index_get() {

	}

	public function index_post() {
		
		$params = array(
					'query' => $this->post('query'),
					'device_id' => $this->post('device_id'),
					);

		$user = User::find_by_id($this->session->userdata('user_id'));

		$params['user'] = $user;

		try {

			/*if(empty($this->input->server('PHP_AUTH_USER') || empty($this->input->server('PHP_AUTH_PW')))) {

	        	$this->message->set('Access Forbidden', 'error',TRUE,'feedback');
				redirect('queries/queries');
	        }

	        $api = ApiAuthentication::find_by_user_and_authentication_key($this->input->server('PHP_AUTH_USER'), $this->input->server('PHP_AUTH_PW'));
	        
	        if(!$api) 
	        	throw new Exception("Access Forbidden");*/
			
			$new_query = new Query();
			$query = $new_query->create($params);

			$response = $this->response(array(
							'status'	=>	'SUCCESS',
							'message'=>'Your Query is sent to our astrologers. Please wait for the answer.',
							'user'=> $user->first_name,
							'data' => null
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