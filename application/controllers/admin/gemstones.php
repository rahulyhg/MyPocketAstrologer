<?php

class Gemstones extends BaseController {

	public function index($user_id) {

		try {

			$user = User::find_valid_by_id($user_id);

            if(!$user) {
                throw new Exception("Invalid User");                
            }

            $gemstone = UserGemstone::find_by_user_id($user_id);

            return $this->load_view('admin/gemstone', array(
            											'gemstone' => $gemstone,
            											'user' => $user,
            											));
        }

        catch(Exception $e) {

        	$this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/users');
        }
	}
}