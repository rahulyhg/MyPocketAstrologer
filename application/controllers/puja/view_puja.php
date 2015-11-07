<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class View_puja extends REST_Controller {

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
				
			$all_pujas = $current_user->pujas;

			$pujas = array();
			$i = 0;

			foreach($all_pujas as $puja) {

				$pujas[$i]['id'] = $puja->id;
				$pujas[$i]['name'] = $puja->name;
				$pujas[$i]['details'] = $puja->details;
				$pujas[$i]['price'] = $puja->price;

				switch($puja->status) {
					case 1: $pujas[$i]['status'] = "Suggested"; break;
					case 2: $pujas[$i]['status'] =  "Ordered"; break;
					case 3: $pujas[$i]['status'] =  "Started"; break;
					case 4: $pujas[$i]['status'] =  "Completed"; break;
				}

				$pujas[$i]['date'] = date("Y-m-d H:i:s", strtotime($puja->date));

				$image_urls = array();
	            foreach ($puja->images as $image) {
	                $image_urls[] = $image->image;
	            }

	            $pujas[$i]['image_urls'] = $image_urls;

				$i++;
			}

			$response = $this->response(array(
							'status' =>	'SUCCESS',
							'message' => 'View pujas',
							'user' => $current_user->first_name,
							'data' => $pujas,
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