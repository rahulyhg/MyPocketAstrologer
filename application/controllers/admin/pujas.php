<?php

class Pujas extends BaseController {

	public function index($user_id) {

		try {

			$user = User::find_valid_by_id($user_id);

			if(!$user)
				throw new Exception("Invalid User");

            $pujas = Puja::find('all', array(
                                    'conditions' => array(
                                        'deleted = ?
                                        and user_id = ?',
                                        0,
                                        $user->id
                                        ),
                                ));

			return $this->load_view('admin/puja', array('user' => $user, 'pujas' => $pujas));				
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
                        'price' => $this->input->post('price'),
            			'status' => 1,
            			'date' => date('Y-m-d H:i:s'),
            			);

            $puja = new Puja();
            $puja = $puja->create($params);
            $puja->save();

            $gcm_users = $user->gcm_users;

            $data = array(
                            'information_type' => 1,
                            'puja_id' => $puja->id,
                            'name' => $puja->name,
                            'push_description' => $puja->details,
                            'price' => $puja->price,
                            'image_urls' => array()
                            );

            $message = json_encode(array(
                            'type' => 3,
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
                            'object_type' => 3,
                            'notification_type' => 3,
                            'information_type' => 1,
                            'object_id' => $puja->id,
                            'details' => $puja->details,
                        );

            $push = new PushNotificationLog;
            $push->create($params);

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

            $gcm_users = $puja->user->gcm_users;

            $data = array(
                            'information_type' => 2,
                            'puja_id' => $puja->id,
                            'name' => $puja->name,
                            'push_description' => $puja->details,
                            'price' => $puja->price,
                            'image_urls' => array()
                            );

            $message = json_encode(array(
                            'type' => 3,
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
                            'user' => $puja->user,
                            'object_type' => 3,
                            'notification_type' => 3,
                            'information_type' => 2,
                            'object_id' => $puja->id,
                            'details' => $puja->details,
                        );

            $push = new PushNotificationLog;
            $push->create($params);

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

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return $this->load_view('admin/puja_complete', array('puja' => $puja));
            }

            $puja->status = 4;
            $puja->save();

            $allowed_extension = array('jpg','png','gif','JPG','PNG','GIF');

            for($i=1; $i <= 3; $i++) {

                if(isset($_FILES['puja_image_'.$i])) {

                    if(is_uploaded_file($_FILES['puja_image_'.$i]['tmp_name'])) {
                    
                        $info = pathinfo($_FILES['puja_image_'.$i]['name']);
                        $ext = $info['extension'];

                        if(!in_array($ext, $allowed_extension))
                            throw new Exception("Invalid file uploaded for puja image");
                            
                        $filename = 'puja-'.$puja->id.'-'.rand(100, 999).'.'.$ext;

                        if(!move_uploaded_file($_FILES['puja_image_'.$i]['tmp_name'], "./public/puja_images/".$filename))
                            throw new Exception("Error in Upload");

                        $params = array('puja' => $puja, 'image' => 'public/puja_images/'.$filename, 'details' => $this->input->post('details_'.$i));
                        
                        $new_puja_image = new PujaImage;
                        $puja_image = $new_puja_image->create($params);
                        $puja_image->save();
                    }
                }
            }

            $gcm_users = $puja->user->gcm_users;

            $image_urls = array();
            foreach ($puja->images as $image) {
                $image_urls[] = $image->image;
            }

            $data = array(
                            'information_type' => 3,
                            'puja_id' => $puja->id,
                            'name' => $puja->name,
                            'push_description' => $puja->details,
                            'price' => $puja->price,
                            'image_urls' => $image_urls,
                            );

            $message = json_encode(array(
                            'type' => 3,
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
                            'user' => $puja->user,
                            'object_type' => 3,
                            'notification_type' => 3,
                            'information_type' => 3,
                            'object_id' => $puja->id,
                            'details' => $puja->details,
                        );

            $push = new PushNotificationLog;
            $push->create($params);

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

    public function view_images($puja_id) {

        try {

            $puja = Puja::find_by_id($puja_id);

            if(!$puja)
                throw new Exception("Invalid Puja");

            return $this->load_view('admin/puja_images', array('puja' => $puja, 'images' => $puja->images));             
        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());
            redirect('/admin/users');
        }
    }

    public function delete($puja_id) {

        try {

            $puja = Puja::find_by_id($puja_id);

            if(!$puja)
                throw new Exception("Puja not found");

            if($puja->deleted)
                throw new Exception("Puja already deleted for the User");

            $puja->delete();

            $this->session->set_flashdata('alert_success', "Puja deleted successfully");

            redirect('admin/pujas/index/'.$puja->user_id);

        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/users');
        }
    }
}