<?php

class Natal_charts extends BaseController {

	public function index($user_id) {

		try {

			$user = User::find_valid_by_id($user_id);

            if(!$user) {
                throw new Exception("Invalid User");                
            }

            $natal_chart = NatalChart::find_by_user_id($user_id);

            return $this->load_view('admin/natal_chart', array(
            											'natal_chart' => $natal_chart,
            											'user' => $user,
            											));
        }

        catch(Exception $e) {

        	$this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/users');
        }
	}

	public function add($user_id) {

		try {

			$user = User::find_valid_by_id($user_id);

            if(!$user) {
                throw new Exception("Invalid User!");                
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return $this->load_view('admin/natal_chart', array('user' => $user));
            }

            $natal_chart = NatalChart::find_by_user_id($user_id);

            if(!$natal_chart)
            	throw new Exception("Natal Chart not requested or paid");

            $allowed_extension = array('jpg','png','gif','JPG','PNG','GIF');

			if(isset($_FILES['natal_chart'])) {

				if(is_uploaded_file($_FILES['natal_chart']['tmp_name'])) {
				
					$info = pathinfo($_FILES['natal_chart']['name']);
	 				$ext = $info['extension'];

	 				if(!in_array($ext, $allowed_extension))
	 					throw new Exception("Invalid file format.");

					move_uploaded_file($_FILES['natal_chart']['tmp_name'], "./public/natal_charts/".$user->first_name.'-natal_chart-'.$user->id.'.'.$ext);
					$natal_chart->natal_chart = "public/natal_charts/".$user->first_name.'-natal_chart-'.$user->id.'.'.$ext;
				}
			}

			else
				throw new Exception("File not uploaded");
			
            $natal_chart->status = 2;
            $natal_chart->save();

            redirect('admin/natal_charts/index/'.$user_id);
		}

		catch(Exception $e) {

			$this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/users');	
		}
	}
}