<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Change_place_of_birth extends REST_Controller {

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

			$user->place_of_birth = $params['place_of_birth'];
			$user->save();

			$user->zodiac_id = 0;
			$user->save();

			$user_gemstone = UserGemstone::find_by_user_id($user->id);
			$isGemstoneShipped = ($user_gemstone && $user_gemstone->ship_ordered) ? true : false;

			$gcm_users = $user->gcm_users;

            $data = array(
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'gender' => $user->gender,
                        'date_of_birth' => date('Y-m-d', strtotime($user->date_of_birth)),
                        'time_of_birth' => date('H:i:s', strtotime($user->date_of_birth)),
                        'is_accurate' => $user->is_accurate,
                        'place_of_birth' => $user->place_of_birth,
                        'profile_pic' => $user->profile_pic,
                        'left_palm' => $user->left_palm,
                        'right_palm' => $user->right_palm,
                        'isGemstoneShipped' => $isGemstoneShipped,
						'isNatalShipped' => ($user->natal_chart && $user->natal_chart->ship_ordered) ? true : false,
						'natalChartUrl' => '',
                        'zodiac' => null,
                        'gemstone' => null,
                        'color' => null,
                        'zodiac_description' => null,
                        'gemstone_description' => null,
                        'color_description' => null,
                        );

            $message = json_encode(array(
                            'type' => 7,
                            'data' => $data
                            ));

            $this->gcm->setMessage($message);

            foreach ($gcm_users as $gcm_user) {
                $this->gcm->addRecepient($gcm_user->gcm_regd_id);
            }

            // set additional data
            $this->gcm->setData(array(
                'stat' => 'OK'
            ));

            $this->gcm->setTtl(false);
            $this->gcm->setGroup(false);
            $this->gcm->send();

			$response = $this->response(array(
							'status'	=>	'SUCCESS',
							'message'=>'Place of Birth Edited Successfully',
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