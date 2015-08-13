<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Get_query extends REST_Controller {

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
				
			$all_queries = $current_user->queries;
			$queries = array();
			$i = 0;

			foreach($all_queries as $query) {

				$queries[$i]['id'] = $query->id;
				$queries[$i]['query'] = $query->query;
				$queries[$i]['answer'] = $query->answer;
				$queries[$i]['date'] = date("Y-m-d H:i:s", strtotime($query->created_at));

				$i++;
			}

			$response = $this->response(array(
							'status' =>	'SUCCESS',
							'message' => 'Previous queries from user',
							'queries_count' => $current_user->queries_count,
							'data' => $queries,
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