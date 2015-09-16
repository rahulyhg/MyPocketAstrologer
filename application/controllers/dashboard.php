<?php

class Dashboard extends BaseController {

	public function index() {

    	return $this->load_view('dashboard');
    }
}

?>