<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Queries extends CI_Controller {

	public function index() {

	}

	public function create($params) {

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/queries/queries');
        }

        $current_user = User::find_by_id($this->session->userdata('user_id'));

        /*if($current_user->queries_count >= 2) {

        	//payment procedure
        }*/
        	
        $curl_post_data = array(
							'query' => $this->post('query'),
							);

        $curl = curl_init();

		curl_setopt($curl, CURLOPT_URL,'http://127.0.0.1/MyPocketAstrologer/queries/new_query');
		curl_setopt($curl, CURLOPT_HTTPHEADER,'Content-Type: application/json');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		$curl_response = curl_exec($curl);

		curl_close($curl);
		
		$result = json_decode($curl_response);

		if($result && $result->status == "SUCCESS"){

			$this->message->set('Success:'.$result->message, 'success',TRUE,'feedback');
			redirect('queries/queries');

		} else {
			$this->message->set('Error:'.$result->errorDescription, 'error',TRUE,'feedback');
			redirect('queries/queries');
		}
	}

	public function count() {

        $curl_post_data = array(
        					'current_user_id' => $this->session->userdata('current_user_id'),
        					);

        $curl = curl_init();

		curl_setopt($curl, CURLOPT_URL,'http://127.0.0.1/MyPocketAstrologer/queries/count_query');
		curl_setopt($curl, CURLOPT_HTTPHEADER, 'Content-Type: application/json');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		$curl_response = curl_exec($curl);

		curl_close($curl);
		
		$result = json_decode($curl_response);

		if($result && $result->status == "SUCCESS"){

			$this->message->set('Success:'.$result->message, 'success',TRUE,'feedback');
			redirect('queries/queries');

		} else {
			$this->message->set('Error:'.$result->errorDescription, 'error',TRUE,'feedback');
			redirect('queries/queries');
		}
	}
}