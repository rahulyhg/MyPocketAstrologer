<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    
class SessionController extends CI_Controller {

    function __construct($session = true, $ignoreLanguage = false){

        parent::__construct();

        if (!$session) {
            return true;
        }

        if (!$this->isActiveSession()){
            return redirect('/auth/login#f=/' . $this->uri->uri_string());
        }

    }

    public function _remap($method, $params = array()){
        if (method_exists($this, $method)){
            return call_user_func_array(array($this, $method), $params);
        }
        $this->loadView('static/404');
    }

    public function isActiveSession(){
        return ($this->session->userdata('user_id') != '');
    }

    public function getSessionData(){
        return $this->session->userdata;
    }

    public function loadView($template, $data = array(), $return_view = false){
        $data = (array) $data;

        return $this->load->view($template, $data, $return_view);
    }
}

class BaseController extends SessionController {

    protected $current_user = null;

    public function __construct($session = true) {
        parent::__construct($session);

        $this->current_user = $this->session->userdata('user_id');

    }

    public function load_view($template, $data = array()) {
        $data = (array) $data;
        $data['current_member'] = $this->current_user;

        $this->loadView($template, $data);
    }

    private function is_active_session() {
        return ($this->session->userdata('user_id') != '');
    }

}