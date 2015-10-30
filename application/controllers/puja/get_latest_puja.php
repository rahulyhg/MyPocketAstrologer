<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Get_latest_puja extends REST_Controller {

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
			
			$latest_push = PushNotificationLog::find('all', array(
	                                                'conditions' => array(
	                                                    'object_type = ?
	                                                    and user_id = ?',
	                                                    3,
	                                                    $current_user->id
	                                                    ),
	                                                'order' => 'id desc',
	                                                'limit' => 1
	                                            ));

			if(!$latest_push)
				throw new Exception("No puja found");

			foreach ($latest_push as $push) {
			
				$puja = Puja::find_by_id($push->object_id);

				$image_urls = array();
	            foreach ($puja->images as $image) {
	                $image_urls[] = $image->image;
	            }

	            $data = array(
	            			'information_type' => $push->information_type,
	            			'puja_id' => $puja->id,
	            			'name' => $puja->name,
	            			'push_description' => $push->details,
	            			'image_urls' => $image_urls
	            		);
			}

			$response = $this->response(array(
							'status' =>	'SUCCESS',
							'message' => 'View puja',
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