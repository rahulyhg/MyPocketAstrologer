<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Users extends CI_Controller {

	public function index() {

	}

	public function create($params) {

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/users/users');
        }
        	
        $curl_post_data = array(
							'first_name' => $this->post('first_name'),
							'last_name' => $this->post('last_name'),
							'profile_pic' => $this->post('profile_pic'),
							'email' => $this->post('email'),
							'password' => $this->post('password'),
							'confirm_password' => $this->post('confirm_password'),
							'gender' => $this->post('gender'),
							'date_of_birth' => $this->post('date_of_birth'),
							'time_of_birth' => $this->post('time_of_birth'),
							'is_accurate' => $this->post('is_accurate'),
							'place_of_birth' => $this->post('place_of_birth'),
							'left_palm' => $this->post('left_palm'),
							'right_palm' => $this->post('right_palm'),
							);

        $curl = curl_init();

		curl_setopt($curl, CURLOPT_URL,'http://127.0.0.1/MyPocketAstrologer/users/user_create');
		curl_setopt($curl, CURLOPT_HTTPHEADER, 'Content-Type: application/json');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		$curl_response = curl_exec($curl);

		curl_close($curl);
		
		$result = json_decode($curl_response);

		if($result && $result->status == "SUCCESS"){

			$this->message->set('Success:'.$result->message, 'success',TRUE,'feedback');
			redirect('users/users');

		} else {
			$this->message->set('Error:'.$result->errorDescription, 'error',TRUE,'feedback');
			redirect('users/users');
		}
	}

	public function login() {

        if ($this->isActiveSession()) {
            redirect('/');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('users/users');
        }

        $curl_post_data = array(
							'email' => $this->post('email'),
							'password' => $this->post('password'),
							'device_id' => $this->post('device_id'),
							);

        $curl = curl_init();

		curl_setopt($curl, CURLOPT_URL,'http://127.0.0.1/MyPocketAstrologer/users/user_login');
		curl_setopt($curl, CURLOPT_HTTPHEADER, 'Content-Type: application/json');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		$curl_response = curl_exec($curl);

		curl_close($curl);
		
		$result = json_decode($curl_response);

		if($result && $result->status == "SUCCESS") {

				$this->session->set_userdata(array(
	                'user_id' => $result->data->id,
	                'device_id' => $this->post('device_id'),
	            ));

			$this->message->set('Success:'.$result->message, 'success',TRUE,'feedback');
			redirect('users/users');

		} else {
			$this->message->set('Error:'.$result->errorDescription, 'error',TRUE,'feedback');
			redirect('users/users');
		}
    }

    public function profile() {

        $curl_get_data = array(
        					'current_user_id' => $this->session->userdata('current_user_id'),
        					);

        $curl = curl_init();

		curl_setopt($curl, CURLOPT_URL,'http://127.0.0.1/MyPocketAstrologer/users/get_profile');
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
			redirect('users/users');

		} else {
			$this->message->set('Error:'.$result->errorDescription, 'error',TRUE,'feedback');
			redirect('users/users');
		}
	}

	


    public function logout() {

		$this->session->sess_destroy();
		redirect('/');
    }
}