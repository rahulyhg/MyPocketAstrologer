<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class cancel_quotation extends REST_Controller {

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

			$quotation = Quotation::find_by_quotation_number($params['quotation_number']);

			if(!$quotation)
				throw new Exception("No such Quotation found");
			
			if($quotation->shipping->user_id != $current_user->id)
				throw new Exception("Invalid Data sent");
				
			$quotation->approved = 2;
			$quotation->save();

			$quotation->shipping->delete();

			$gcm_users = $current_user->gcm_users;

            $data = array(
                        'quotation_number' => $quotation->quotation_number,
                    );

            $message = json_encode(array(
                            'type' => 10,
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

            if($quotation->shipping->type == 1) {

                $params = array(
                            'user' => $current_user,
                            'object_type' => 1,
                            'notification_type' => 10,
                            'information_type' => 0,
                            'object_id' => $quotation->shipping->user->natal_chart->id,
                            'details' => 'Quotation cancelled',
                        );

                $push = new PushNotificationLog;
                $push->create($params);
            }

            elseif($quotation->shipping->type == 2) {

                $params = array(
                            'user' => $current_user,
                            'object_type' => 2,
                            'notification_type' => 10,
                            'information_type' => 0,
                            'object_id' => $quotation->shipping->gemstone_id,
                            'details' => 'Quotation cancelled',
                        );

                $push = new PushNotificationLog;
                $push->create($params);
            }

			$response = $this->response(array(
							'status' =>	'SUCCESS',
							'message' => 'Quotation cancelled for the order',
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