<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Add_gcm_user extends REST_Controller {

	public function index_get() {

	}

	public function index_post() {

		$params = json_decode(file_get_contents('php://input'),true);

		try {

			if(!$this->input->server('PHP_AUTH_USER') || !$this->input->server('PHP_AUTH_PW')) {

	        	throw new Exception("Access Forbidden!!");
	        }

	        $api = ApiAuthentication::find_by_user_and_authentication_key($this->input->server('PHP_AUTH_USER'), $this->input->server('PHP_AUTH_PW'));
	        
	        if(!$api) 
	        	throw new Exception("Access Forbidden");
			
			$user = User::find_valid_by_id($params['current_user_id']);

			if(!$user)
				throw new Exception("Invalid User Request");

			$existing_gcm_users = GcmUser::find('all', array(
                                            'conditions' => array(
                                                'device_id = ?',
                                                $params['device_id']
                                                )
                                            ));


			if($existing_gcm_users) {

				foreach ($existing_gcm_users as $existing_gcm_user) {

					if($existing_gcm_user->user_id != $params['current_user_id']) {

						$this->db->where('id', $existing_gcm_user->id);
		        		$this->db->delete('gcm_users');
		        	}
		        }
			}

			$gcm_user = GcmUser::find_by_user_id_and_device_id_and_gcm_regd_id($params['current_user_id'], $params['device_id'], $params['gcm_regd_id']);

			if(!$gcm_user) {

				$params['user'] = $user;

				$gcm_user = new GcmUser;
				$gcm = $gcm_user->create($params);
				$gcm->save();
			}

			$response = $this->response(array(
							'status'	=>	'SUCCESS',
							'message'=>'Gcm User saved to the database Successfully',
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