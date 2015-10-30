<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Receipts extends REST_Controller {

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
		
			$new_receipt = new Receipt();
			$receipt = $new_receipt->create($params);
			$receipt->save();

			$gcm_users = $current_user->gcm_users;

            if($params['type'] == 1) {

                $message = json_encode(array(
                                'type' => 2,
                                'data' => array(
                                            'information_type' => 2,
                                            'description' => "We have received your payment for Natal Chart shipping. It will be shipped soon.",
                                        ),
                                ));
            }

            elseif($params['type'] == 2) {

                $user_gemstone = UserGemstone::find_by_id($params['object_id']);

                $data = array(
                                'information_type' => 2,
                                'gemstone_id' => $user_gemstone->id,
                                'gems_description' => $user_gemstone->details,
                                'gem_stone_type' => $user_gemstone->gemstone_id,
                                );

                $message = json_encode(array(
                                'type' => 4,
                                'data' => $data
                                ));
            }

            elseif($params['type'] == 3) {

                $puja = Puja::find_by_id($params['object_id']);

                $data = array(
                            'information_type' => 2,
                            'puja_id' => $puja->id,
                            'name' => $puja->name,
                            'push_description' => "We have received your payment for the Puja. It will be started soon.",
                            'image_urls' => array()
                            );

	            $message = json_encode(array(
	                            'type' => 3,
	                            'data' => $data
	                            ));
            }

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

            if($params['type'] == 1) {

                $params = array(
                            'user' => $current_user,
                            'object_type' => 1,
                            'notification_type' => 2,
                            'information_type' => 2,
                            'object_id' => $current_user->natal_chart->id,
                            'details' => 'We have received your payment for Natal Chart shipping. It will be shipped soon.',
                        );

                $push = new PushNotificationLog;
                $push->create($params);
            }

            elseif($params['type'] == 2) {

                $params = array(
                            'user' => $current_user,
                            'object_type' => 2,
                            'notification_type' => 4,
                            'information_type' => 2,
                            'object_id' => $user_gemstone->id,
                            'details' => 'We have received your payment for Gemstone shipping. It will be shipped soon.',
                        );

                $push = new PushNotificationLog;
                $push->create($params);
            }

            elseif($params['type'] == 3) {

                $params = array(
                            'user' => $current_user,
                            'object_type' => 3,
                            'notification_type' => 3,
                            'information_type' => 2,
                            'object_id' => $puja->id,
                            'details' => 'We have received your payment for the Puja. It will be started soon.',
                        );

                $push = new PushNotificationLog;
                $push->create($params);
            }

			$response = $this->response(array(
							'status' =>	'SUCCESS',
							'message' => 'Receipt saved successfully',
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