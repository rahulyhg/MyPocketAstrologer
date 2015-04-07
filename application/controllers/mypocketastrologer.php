<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MyPocketAstrologer extends SessionController {

    public function __construct(){
        parent::__construct(false);
    }

    public function index(){

        if($this->isActiveSession()){
            redirect('/dashboard');
            exit();
        }

       $this->loadView('admin/auth/login');
    }
}