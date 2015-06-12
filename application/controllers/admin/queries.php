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

    public function edit($query_id) {

        try {

            $query = Query::find_by_id($query_id);

            if(!$query) {
                throw new Exception("Invalid Query!");                
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return $this->load_view('admin/query/edit', array('query' => $query));
            }
            
            $query->query = $this->input->post('query');
            $query->answer = $this->input->post('answer');            

            $query->save();

            $this->session->set_flashdata(
                'alert_success', 
                "Query details edited successfully."
            );

            redirect('/admin/queries');
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

            $query->save();

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

?>