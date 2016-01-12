<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Quotation_asked extends REST_Controller {

	public function index_get() {

		$current_user_id = $this->get('current_user_id');

		try {
			
			if(!$this->input->server('PHP_AUTH_USER') || !$this->input->server('PHP_AUTH_PW')) {

	        	throw new Exception("Access Forbidden!!");
	        }

	        $api = ApiAuthentication::find_by_user_and_authentication_key($this->input->server('PHP_AUTH_USER'), $this->input->server('PHP_AUTH_PW'));
	        
	        if(!$api) 
	        	throw new Exception("Access Forbidden");

			$current_user = User::find_by_id($current_user_id);

			if(!$current_user)
				throw new Exception("Invalid User Request");

			$data = null;

			//$shipping = Shipping::find_by_user_id_and_type_and_deleted($current_user->id, 2, 0);

			$shippings = Shipping::find('all', array(
                                            'conditions' => array(
                                                'deleted = ? and
                                                type = ? and
                                                user_id = ?',
                                                0,
                                                2,
                                                $current_user->id
                                                ),
                                            'order' => 'id desc',
                                            'limit' => 1
                                            ));

			if($shippings)
				foreach ($shippings as $shipping) {
					$data = array('id'=>$shipping->gemstone_id);
				}
				
			
			$response = $this->response(array(
							'status' =>	'SUCCESS',
							'message' => 'Quotation Asked',
							'user' => $current_user->first_name,
							'data' => $data
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