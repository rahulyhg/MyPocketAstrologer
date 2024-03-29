<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Get_natal_chart extends REST_Controller {

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
			
			$natal_chart = NatalChart::find_by_user_id($current_user_id);

			if(!$natal_chart) {

				$params = array(
                            'user' => $current_user,
                            );

                $natal_chart = new NatalChart;
                $natal_chart = $natal_chart->create($params);
                $natal_chart->save();
			}

			if($natal_chart->view_ordered)
				throw new Exception("you have already paid for viewing Natal Chart.");

			$natal_chart->view_ordered = 1;
			$natal_chart->status = 2;
			$natal_chart->save();

			$response = $this->response(array(
							'status' =>	'SUCCESS',
							'message' => 'View Natal Chart image',
							'user' => $current_user->first_name,
							'data' => array("natalChartUrl" => $natal_chart->natal_chart),
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