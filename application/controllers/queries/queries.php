<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Queries extends CI_Controller {

	public function index() {

	}

	public function create($params) {

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/queries/queries');
        }

        $curl_post_data = array(
							'query' => $this->post('query'),
							'device_id' => $this->post('device_id'),
							'current_user_id' => $this->post('current_user_id'),
							);

        $curl = curl_init();

		curl_setopt($curl, CURLOPT_URL,'http://127.0.0.1/MyPocketAstrologer/queries/new_query');
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-API-KEY:123456789', 'Content-Type: application/json'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl, CURLOPT_USERPWD, 'author:1234567890987654321');
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		$curl_response = curl_exec($curl);

		curl_close($curl);
		
		$result = json_decode($curl_response);

		if($result && $result->status == "SUCCESS") {

			$this->message->set('Success:'.$result->message, 'success',TRUE,'feedback');
			redirect('queries/queries');

		} else {
			$this->message->set('Error:'.$result->errorDescription, 'error',TRUE,'feedback');
			redirect('queries/queries');
		}
	}

	public function count() {

        $curl_get_data = array(
        					'current_user_id' => $this->session->userdata('current_user_id'),
        					);

        $curl = curl_init();

		curl_setopt($curl, CURLOPT_URL,'http://127.0.0.1/MyPocketAstrologer/queries/count_query');
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-API-KEY:123456789', 'Content-Type: application/json');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl, CURLOPT_USERPWD, 'author:1234567890987654321');
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_get_data);
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

	public function get_queries() {

        $curl_get_data = array(
        					'current_user_id' => $this->session->userdata('current_user_id'),
        					);

        $curl = curl_init();

		curl_setopt($curl, CURLOPT_URL,'http://127.0.0.1/MyPocketAstrologer/queries/get_query');
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-API-KEY:123456789', 'Content-Type: application/json');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl, CURLOPT_USERPWD, 'author:1234567890987654321');
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_get_data);
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