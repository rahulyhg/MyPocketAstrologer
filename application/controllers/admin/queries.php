<?php

class Queries extends BaseController {

	public function index() {

		if(array_key_exists('page', $_GET)) {

            $cur_page = $_GET['page'];
        }
        else {
            $cur_page = 1;
        }

        $page = new Page();
        $page->set_current_page_number($cur_page);
        $page->set_per_page(20);

        if(array_key_exists('order_by_field', $_GET)) {

            $order_by_field = $_GET['order_by_field'];
        }
        else {
            $order_by_field = 'created_at';
        }

        if(array_key_exists('order_by_direction', $_GET)) {

            $order_by_direction = $_GET['order_by_direction'];
        }
        else {
            $order_by_direction = 'desc';
        }

        if(array_key_exists('search', $_GET)) {

            $search = $_GET['search'];
        }
        else {
            $search = null;
        }

        $query_search = new QuerySearch();
        $query_search ->set_order($order_by_field, $order_by_direction)
                     ->set_page($page)
                     ->set_search_term(urldecode($search))
                     ->execute();

		$data['queries'] = $query_search;


		return $this->load_view('admin/query/index',$data);
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
}

?>