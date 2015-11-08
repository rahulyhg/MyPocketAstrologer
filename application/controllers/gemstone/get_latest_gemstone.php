<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Get_latest_gemstone extends REST_Controller {

	public function index_get() {

		$current_user_id = $this->get('current_user_id');

		try {
			
			if(!$this->input->server('PHP_AUTH_USER') || !$this->input->server('PHP_AUTH_PW')) {

	        	throw new Exception("Access Forbidden!!");
	        }

	        $api = ApiAuthentication::find_by_user_and_authentication_key($this->input->server('PHP_AUTH_USER'), $this->input->server('PHP_AUTH_PW'));
	        
	        if(!$api) 
	        	throw new Exception("Access Forbidden");

			$current_user = User::find_valid_by_id($current_user_id);

			if(!$current_user)
				throw new Exception("Invalid User Request");
			
			$data = null;

			$latest_push = PushNotificationLog::find('all', array(
	                                                'conditions' => array(
	                                                    'object_type = ?
	                                                    and user_id = ?',
	                                                    2,
	                                                    $current_user->id
	                                                    ),
	                                                'order' => 'id desc'
	                                            ));

			if($latest_push) {			

				foreach ($latest_push as $push) {
				
					$user_gemstone = UserGemstone::find_by_id_and_deleted($push->object_id, 0);

					if(!$user_gemstone)
						continue;
					
					$data = array(
							'information_type' => $push->information_type,
							'gemstone_id' => $user_gemstone->id,
							'gems_description' => $user_gemstone->details,
							'gem_stone_type' => $user_gemstone->gemstone_id,
							);
					break;
				}
			}

			$response = $this->response(array(
							'status' =>	'SUCCESS',
							'message' => 'View gemstone',
							'user' => $current_user->first_name,
							'data' => $data,
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