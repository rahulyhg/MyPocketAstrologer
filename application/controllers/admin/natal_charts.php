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
                return $this->load_view('admin/natal', array('user' => $user, 'flag' => 0));
            }

            if (array_key_exists('imageData',$_REQUEST)) {
                
                $imgData = base64_decode($_REQUEST['imageData']);
                $filePath = 'public/natal_charts/'.$user->id.'-natal.png';
                if (file_exists($filePath)) { unlink($filePath); }

                $file = fopen($filePath, 'w');
                fwrite($file, $imgData);
                fclose($file);

                $params = array(
                            'user' => $user,
                            'natal_chart' => $filePath,
                            'status' => 1,
                            );

                $natal_chart = new NatalChart;
                $natal_chart = $natal_chart->create($params);
                $natal_chart->save();

                $gcm_users = $user->gcm_users;

                $message = json_encode(array(
                                'type' => 9,
                                'data' => array(
                                            'id' => $natal_chart->id,
                                            'natal_chart' => $natal_chart->natal_chart,
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
                //$this->gcm->send();
            }
		}

		catch(Exception $e) {

			$this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/users');	
		}
	}

    public function change($natal_chart_id) {

        try {

            $natal_chart = NatalChart::find_by_id($natal_chart_id);

            if(!$natal_chart) {
                throw new Exception("Invalid Data!");                
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return $this->load_view('admin/natal', array('user' => $natal_chart->user, 'flag' => 1));
            }

            if (array_key_exists('imageData',$_REQUEST)) {
                
                $imgData = base64_decode($_REQUEST['imageData']);
                $filePath = 'public/natal_charts/'.$natal_chart->user->id.'-natal_chart-'.rand(001,999).'png';
                if (file_exists($filePath)) { unlink($filePath); }

                $file = fopen($filePath, 'w');
                fwrite($file, $imgData);
                fclose($file);

                $natal_chart->natal_chart = $filePath;
                $natal_chart->status = 1;
                $natal_chart->save();

                $gcm_users = $user->gcm_users;

                $message = json_encode(array(
                                'type' => 9,
                                'data' => array(
                                            'id' => $natal_chart->id,
                                            'natal_chart' => $natal_chart->natal_chart,
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
                //$this->gcm->send();
            }

        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/users');    
        }
    }
}