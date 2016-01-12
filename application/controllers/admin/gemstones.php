<?php

class Gemstones extends BaseController {

	public function index($user_id) {

		try {

			$user = User::find_valid_by_id($user_id);

            if(!$user) {
                throw new Exception("Invalid User");                
            }

            $user_gemstones = UserGemstone::find('all', array(
                                                'conditions' => array(
                                                    'deleted = ?
                                                    and user_id = ?',
                                                    0,
                                                    $user_id
                                                    ),
                                                'order' => 'id desc'
                                            ));

            $gemstones = Gemstone::find('all');
            $colors = Color::find('all');

            return $this->load_view('admin/gemstone', array(
            											'user_gemstones' => $user_gemstones,
            											'user' => $user,
                                                        'gemstones' => $gemstones,
                                                        'colors' => $colors,
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

            if(!$user)
                throw new Exception("Invalid User");

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                redirect('admin/gemstones/index/'.$user_id);
            }

            $gemstone = Gemstone::find_by_id($this->input->post('gemstone'));
            $color = Color::find_by_id($this->input->post('color'));

            $params = array(
                        'user' => $user,
                        'gemstone' => $gemstone,
                        'color' => $color->color,
                        'details' => $this->input->post('details'),
                        );

            $user_gemstone = new UserGemstone();
            $user_gemstone = $user_gemstone->create($params);
            $user_gemstone->save();

            $gcm_users = $user->gcm_users;

            $data = array(
                            'information_type' => 1,
                            'gemstone_id' => $user_gemstone->id,
                            'gems_description' => $user_gemstone->details,
                            'gem_stone_type' => $user_gemstone->gemstone_id,
                            );

            $message = json_encode(array(
                            'type' => 4,
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
                            'object_type' => 2,
                            'notification_type' => 4,
                            'information_type' => 1,
                            'object_id' => $user_gemstone->id,
                            'details' => $user_gemstone->details,
                        );

            $push = new PushNotificationLog;
            $push->create($params);

            $this->session->set_flashdata(
                'alert_success', 
                "Gemstone suggested to the user successfully."
            );
            
            redirect('admin/gemstones/index/'.$user->id);
        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());
            redirect('/admin/users');
        }
    }

    public function delete($user_gemstone_id) {

        try {

            $user_gemstone = UserGemstone::find_by_id($user_gemstone_id);

            if(!$user_gemstone)
                throw new Exception("Gemstone not found");

            if($user_gemstone->deleted)
                throw new Exception("Gemstone already deleted for the User");

            $user_gemstone->delete();

            $this->session->set_flashdata('alert_success', "Gemstone deleted successfully");

            redirect('admin/gemstones/index/'.$user_gemstone->user_id);

        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/users');
        }
    }

    /*public function process_shipping($user_gemstone_id) {

        try {

            $user_gemstone = UserGemstone::find_by_id_and_status($user_gemstone_id, 2);

            if(!$user_gemstone)
                throw new Exception("Gemstone not found");

            $user_gemstone->status = 3;
            $user_gemstone->save();

            $gcm_users = $user_gemstone->user->gcm_users;

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
                            'user' => $user_gemstone->user,
                            'object_type' => 2,
                            'notification_type' => 4,
                            'information_type' => 2,
                            'object_id' => $user_gemstone->id,
                            'details' => $user_gemstone->details,
                        );

            $push = new PushNotificationLog;
            $push->create($params);

            $this->session->set_flashdata('alert_success', "Gemstone processed for shipping successfully");

            redirect('admin/gemstones/index/'.$user_gemstone->user_id);

        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/users');
        }
    }*/
}