<?php

class Queries extends BaseController {

	public function index() {

        $queries = Query::find('all', array(
                                            'conditions' => array(
                                                'deleted = ?',
                                                0
                                                ),
                                            'order' => 'created_at desc'
                                            ));

		return $this->load_view('admin/query/index', array('queries' => $queries));
	}

    public function view($query_id) {

        try {

            $query = Query::find_by_id($query_id);

            if(!$query) {
                throw new Exception("Invalid Query!");                
            }
            
            return $this->load_view('admin/query/view', array('query' => $query));
        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());
            redirect('/admin/queries');
        }
    }

    public function answer($query_id) {

        try {

            $query = Query::find_by_id($query_id);

            if(!$query) {
                throw new Exception("Invalid Query!");                
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return $this->load_view('admin/query/answer', array('query' => $query));
            }
            
            if($this->input->post('answer') == '')
                throw new Exception("Please Enter an answer to the user's query");
                
            $query->answer = $this->input->post('answer');
            $query->answered_on = date('Y-m-d H:i:s');

            $query->save();

            $gcm_users = $query->user->gcm_users;

            $message = json_encode(array(
                            'type' => 5,
                            'data' => array(
                                        'id' => $query->id,
                                        'query' => $query->query,
                                        'answer' => $query->answer,
                                        'date' =>  date("Y-m-d H:i:s", strtotime($query->asked_on)),
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

            $params = array(
                            'user' => $query->user,
                            'object_type' => 4,
                            'notification_type' => 5,
                            'information_type' => 0,
                            'object_id' => $query->id,
                            'details' => '',
                        );

            $push = new PushNotificationLog;
            $push->create($params);

            $this->session->set_flashdata(
                'alert_success', 
                "Answer added to the query successfully."
            );

            redirect('/admin/queries');
        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());
            redirect('/admin/queries');
        }
    }

    public function delete($query_id) {

        try {

            $query = Query::find_by_id($query_id);

            if(!$query)
                throw new Exception("Query not found");

            if($query->deleted)
                throw new Exception("Query already deleted");

            $query->delete();

            $this->session->set_flashdata('alert_success', "Query deleted successfully");

            redirect('admin/queries');

        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/queries');
        }
    }
}