<?php

class Pujas extends BaseController {

	public function index($user_id) {

		try {

			$user = User::find_valid_by_id($user_id);

			if(!$user)
				throw new Exception("Invalid User");

			return $this->load_view('admin/puja', array('user' => $user, 'pujas' => $user->pujas));				
		}

		catch(Exception $e) {

			$this->session->set_flashdata('alert_error', $e->getMessage());
            redirect('/admin/users');
		}
	}

	public function suggest($user_id) {

		try {

			$user = User::find_valid_by_id($user_id);

			if(!$user)
				throw new Exception("Invalid User");

			if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return $this->load_view('admin/puja', array('user' => $user, 'pujas' => $user->pujas));
            }

            $params = array(
            			'user' => $user,
            			'name' => $this->input->post('name'),
            			'details' => $this->input->post('details'),
            			'status' => 1,
            			'date' => date('Y-m-d H:i:s'),
            			);

            $puja = new Puja();
            $puja = $puja->create($params);
            $puja->save();

            $gcm_users = $user->gcm_users;

            $message = json_encode(array(
                            'type' => 3,
                            'data' => array(
                                        'id' => $puja->id,
                                        'name' => $puja->name,
                                        'details' => $puja->details,
                                        'date' =>  date("Y-m-d H:i:s", strtotime($puja->date)),
                                    ),
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

            $this->session->set_flashdata(
                'alert_success', 
                "Puja suggested to the user successfully."
            );
            
			redirect('admin/pujas/index/'.$user->id);
		}

		catch(Exception $e) {

			$this->session->set_flashdata('alert_error', $e->getMessage());
            redirect('/admin/users');
		}

	}

    public function start($puja_id) {

        try {

            $puja = Puja::find_by_id_and_status($puja_id, 2);

            if(!$puja)
                throw new Exception("Invalid Data");

            $puja->status = 3;
            $puja->save();

            $this->session->set_flashdata(
                'alert_success', 
                "Puja started."
            );
            
            redirect('admin/pujas/index/'.$puja->user->id);
        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());
            redirect('/admin/users');
        }
    }

    public function complete($puja_id) {

        try {

            $puja = Puja::find_by_id_and_status($puja_id, 3);

            if(!$puja)
                throw new Exception("Invalid Data");

            $puja->status = 4;
            $puja->save();            

            $this->session->set_flashdata(
                'alert_success', 
                "Puja is completed successfully."
            );
            
            redirect('admin/pujas/index/'.$puja->user->id);
        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());
            redirect('/admin/users');
        }
    }
}