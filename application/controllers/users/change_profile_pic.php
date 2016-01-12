<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Change_profile_pic extends REST_Controller {

	public function index_get() {

	}

	public function index_post() {

		try {
			
			if(!$this->input->server('PHP_AUTH_USER') || !$this->input->server('PHP_AUTH_PW')) {

	        	throw new Exception("Access Forbidden!!");
	        }

	        $api = ApiAuthentication::find_by_user_and_authentication_key($this->input->server('PHP_AUTH_USER'), $this->input->server('PHP_AUTH_PW'));
	        
	        if(!$api) 
	        	throw new Exception("Access Forbidden");
			
			$user = User::find_valid_by_id($this->post('current_user_id'));

			if(!$user)
				throw new Exception("Invalid User Request");

			$allowed_extension = array('jpg','png','gif','JPG','PNG','GIF');

			if(isset($_FILES['profile_pic'])) {

				if(is_uploaded_file($_FILES['profile_pic']['tmp_name'])) {
				
					$info = pathinfo($_FILES['profile_pic']['name']);
					$ext = $info['extension'];

	 				if(!in_array($ext, $allowed_extension))
	 					throw new Exception("Invalid file uploaded for profile picture");
	 					
	 				$filename = $user->first_name.'-profile-'.$user->id.'-'.rand(100, 999).'.'.$ext;

					if(!move_uploaded_file($_FILES['profile_pic']['tmp_name'], "./public/user_images/".$user->id."-uploads/".$filename))
						throw new Exception("Error in Upload");
					
					$user->profile_pic = "public/user_images/".$user->id."-uploads/".$filename;
					$user->save();
				}
			}

			else
				throw new Exception("No picture uploaded!");

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
						'natalChartUrl' => ($user->natal_chart && $user->natal_chart->view_ordered) ? $user->natal_chart->natal_chart : '',
                        );

			$zodiac = $user->zodiac;

			if($zodiac) {

				$data['zodiac'] = $zodiac->zodiac;
				$data['gemstone'] = $zodiac->gemstone;
				$data['color'] = $zodiac->color;
				$data['gemstone_description'] = $zodiac->gemstone_details;
				$data['color_description'] = $zodiac->color_details;
				$data['zodiac_description'] = $zodiac->details;
			}

			else {

				$data['zodiac'] = null;
				$data['gemstone'] = null;
				$data['color'] = null;
				$data['gemstone_description'] = null;
				$data['color_description'] = null;
				$data['zodiac_description'] = null;
			}

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

            $params = array(
                'user' => $user,
                'object_type' => 5,
                'notification_type' => 7,
                'information_type' => 0,
                'object_id' => $user->id,
                'details' => 'Profile pic changed',
            );

            $push = new PushNotificationLog;
            $push->create($params);
			
			$response = $this->response(array(
							'status'	=>	'SUCCESS',
							'message'=>'Profile Picture Changed Successfully',
							'user'=> $user->first_name,
							'data' => array('image' => $user->profile_pic)
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