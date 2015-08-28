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
				
			$user = User::find_valid_by_id($this->post('current_user_id'));
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