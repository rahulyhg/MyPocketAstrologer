<?php

class Terms_and_conditions extends SessionController {

	public function __construct(){
        parent::__construct(false);
    }

	public function index() {

    	return $this->loadView('terms');
    }
}

?>