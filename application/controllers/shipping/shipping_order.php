<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Shipping_order extends REST_Controller {

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

			$current_user = User::find_by_id($params['current_user_id']);

			if(!$current_user)
				throw new Exception("Invalid User Request");

			$params['user'] = $current_user;
		
			$new_shipping = new Shipping();
			$shipping = $new_shipping->create($params);
			$shipping->save();

			if($params['type'] == 1) {

				$natal_chart = NatalChart::find_by_user_id($current_user->id);

				if(!$natal_chart) {

					$params = array(
                            'user' => $current_user,
                            );

	                $natal_chart = new NatalChart;
	                $natal_chart = $natal_chart->create($params);
	                $natal_chart->save();
				}

				if($natal_chart->ship_ordered)
					throw new Exception("Natal Chart already ordered for shipping.");

				$natal_chart->ship_ordered = 1;
				$natal_chart->save();
			}

			if($params['type'] == 2) {

				$user_gemstone = UserGemstone::find_by_id_and_user_id_and_status_and_deleted($params['object_id'], $current_user->id, 1, 0);

				if(!$user_gemstone)
					throw new Exception("Gemstone not found");

				if($user_gemstone->ship_ordered)
					throw new Exception("Gemstone already ordered for shipping.");

				$user_gemstone->status = 2;
				$user_gemstone->ship_ordered = 1;
				$user_gemstone->save();
				
				$current_user->ring_size = $params['size'];
				$current_user->save();
			}

			$response = $this->response(array(
							'status' =>	'SUCCESS',
							'message' => 'Shipping order saved successfully',
							'user' => $current_user->first_name,
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