<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class User_Create extends REST_Controller {

	public function index_get() {

	}

	public function index_post() {

		$params = json_decode(file_get_contents('php://input'),true);
		$params['user_type'] = 2;

		try {

			if(empty($this->input->server('PHP_AUTH_USER') || empty($this->input->server('PHP_AUTH_PW')))) {

	        	$this->message->set('Access Forbidden', 'error',TRUE,'feedback');
				redirect('users/users');
	        }

	        $api = ApiAuthentication::find_by_user_and_authentication_key($this->input->server('PHP_AUTH_USER'), $this->input->server('PHP_AUTH_PW'));
	        
	        if(!$api) 
	        	throw new Exception("Access Forbidden");
			
			$new_user = new User();
			$user = $new_user->create($params);

			echo $user->id;
			mkdir('C:/xampp/htdocs/MyPocketAstrologer/public/user_images/'.$user->id.'-uploads');

			if(isset($_FILES['profile_pic'])) {

				if(is_uploaded_file($_FILES['profile_pic']['tmp_name'])) {
				
					$info = pathinfo($_FILES['profile_pic']['name']);
	 				$ext = $info['extension'];
					move_uploaded_file($_FILES['profile_pic']['tmp_name'], "./public/user_images/".$user->id."-uploads/".$params['first_name'].'-profile-'.$user->id.'.'.$ext);
					$user->profile_pic = "public/user_images/".$user->id."-uploads/".$params['first_name'].'-profile-'.$user->id.'.'.$ext;
				}
			}

			if(isset($_FILES['left_palm'])) {

				if(is_uploaded_file($_FILES['left_palm']['tmp_name'])) {

					$info = pathinfo($_FILES['left_palm']['name']);
	 				$ext = $info['extension'];
					move_uploaded_file($_FILES['left_palm']['tmp_name'], "./public/user_images/".$user->id."-uploads".$params['first_name'].'-left_palm-'.$user->id.'.'.$ext);
					$user->left_palm = "public/user_images/".$user->id."-uploads".$params['first_name'].'-left_palm-'.$user->id.'.'.$ext;
				}
			}

			if(isset($_FILES['right_palm'])) {

				if(is_uploaded_file($_FILES['right_palm']['tmp_name'])) {

					$info = pathinfo($_FILES['right_palm']['name']);
	 				$ext = $info['extension'];
					move_uploaded_file($_FILES['profile']['tmp_name'], "./public/user_images/".$user->id."-uploads".$params['first_name'].'-right_palm-'.$user->id.'.'.$ext);
					$user->right_palm = "public/user_images/".$user->id."-uploads".$params['first_name'].'-right_palm-'.$user->id.'.'.$ext;
				}
			}

			$user->save();

			$response = $this->response(array(
							'status'	=>	'SUCCESS',
							'user'=> $params['first_name'],
							'message'=>'Sign Up Successfully Completed'
							));
			
			$this->response($response, HTTP_OK);
		}

		catch(Exception $e) {
			$this->response($e->getMessage());
		}
	}
}