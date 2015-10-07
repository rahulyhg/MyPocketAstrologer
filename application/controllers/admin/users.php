<?php

class Users extends BaseController {

	public function index() {

        try {

            $users = User::find('all', array(
                                            'conditions' => array(
                                                'deleted = ?',
                                                0
                                                ),
                                            'order' => 'created_at desc'
                                            ));

    		return $this->load_view('admin/user/index', array('users' => $users));
        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('dashboard');
        }
	}

    public function view($user_id) {

        try {

            $user = User::find_by_id($user_id);

            if(!$user)
                throw new Exception("User not found");
            
            return $this->load_view('admin/user/view', array('user' => $user));
        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/users');
        }
    }

    public function edit($user_id) {

        try {

            $user = User::find_by_id($user_id);

            if(!$user) {
                throw new Exception("Invalid User!");                
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return $this->load_view('admin/user/edit', array('user' => $user));
            }

            $user->first_name = $this->input->post('first_name');
            $user->last_name = $this->input->post('last_name');
            $user->date_of_birth = $this->input->post('date_of_birth').' '.$this->input->post('time_of_birth');
            $user->place_of_birth = $this->input->post('place_of_birth');
            $user->gender = $this->input->post('gender');
            $user->email = $this->input->post('email');

            $user->save();

            $this->session->set_flashdata(
                'alert_success', 
                "User profile edited successfully."
            );

            redirect('/admin/users');
        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());
            redirect('/admin/users');
        }
    }

    public function queries($user_id) {

        try {

            $user = User::find_by_id($user_id);

            if(!$user)
                throw new Exception("User not found");
            
            $queries = Query::find('all', array(
                                            'conditions' => array(
                                                'deleted = ?
                                                and user_id = ?',
                                                0,
                                                $user->id
                                                ),
                                            'order' => 'created_at desc'
                                            )
                                    );

            $data = array(
                        'queries' => $queries,
                        'user_id' => $user->id,
                        'user' => $user,
                        );

            return $this->load_view('admin/user/queries',$data);
        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/users');
        }
    }

    public function activate($user_id) {

        try {

            $user = User::find_by_id($user_id);

            if(!$user)
                throw new Exception("User not found");

            if($user->active)
                throw new Exception("User is already active");

            $user->activate();

            $this->session->set_flashdata('alert_success', "User activated successfully");

            redirect('admin/users');

        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/users');
        }

    }

    public function deactivate($user_id) {

        try {

            $user = User::find_by_id($user_id);

            if(!$user)
                throw new Exception("User not found");

            if(!$user->active)
                throw new Exception("User already deactivated");

            $user->deactivate();

            $this->session->set_flashdata('alert_success', "User deactivated successfully");

            redirect('admin/users');

        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/users');
        }
    }

    public function delete($user_id) {

        try {

            $user = User::find_by_id($user_id);

            if(!$user)
                throw new Exception("User not found");

            if($user->deleted)
                throw new Exception("User already deleted");

            $user->delete();

            $this->session->set_flashdata('alert_success', "User deleted successfully");

            redirect('admin/users');

        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/users');
        }
    }

    public function assign_zodiac($user_id) {

        try {

            $user = User::find_by_id($user_id);

            if(!$user) {
                throw new Exception("Invalid User!");                
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

                $zodiac_signs = Zodiac::find('all');
                return $this->load_view('admin/user/zodiac', array('user' => $user, 'zodiac_signs' => $zodiac_signs));
            }

            $zodiac = Zodiac::find_by_id($this->input->post('zodiac_id'));
            if(!$zodiac)
                throw new Exception("Please select a valid zodiac sign");
                
            $user->zodiac = $zodiac;
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
                        'zodiac' => $zodiac->zodiac,
                        'gemstone' => $zodiac->gemstone,
                        'color' => $zodiac->color,
                        'zodiac_description' => $zodiac->details,
                        'gemstone_description' => $zodiac->gems->details,
                        'color_description' => $zodiac->colour->details,
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

            $params = array(
                        'user' => $user,
                        'gemstone' => $zodiac->gems,
                        'color' => $zodiac->colour,
                        'details' => $zodiac->gemstone->details,
                    );

            $user_gemstone = new UserGemstone;
            $user_gemstone = $user_gemstone->create($params);
            $user_gemstone->save();

            $data = array(
                            'information_type' => 1,
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

            $this->session->set_flashdata('alert_success', "Zodiac sign assigned to the user successfully");

            redirect('admin/users');

        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/users');
        }
    }
}

?>