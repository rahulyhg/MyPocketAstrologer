<?php  if (! defined('BASEPATH')) exit('No direct script access allowed');

class ASTROLOGER_Loader extends CI_Loader {

    public function __construct() {

        $this->initialise_php_activerecord_from_codeigniter_database_config();

        parent::__construct();
    }

    private function initialise_php_activerecord_from_codeigniter_database_config() {

        $db_config = $this->load_codigniter_database_config();
        $connections = $this->load_php_activerecord_connections_config($db_config);

        ActiveRecord\Config::initialize(function ($cfg) use ($connections, $db_config) {
            $cfg->set_model_directory(APPPATH.'models/');
            $cfg->set_connections($connections);
            $cfg->set_default_connection($db_config['active_group']);
        });
    }

    private function load_codigniter_database_config() {

        if(file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php')) {
            require($file_path);
            return array('db' => $db, 'active_group' => $active_group);
        }

        if(file_exists($file_path = APPPATH.'config/database.php')) {
            require($file_path);
            return array('db' => $db, 'active_group' => $active_group);     
        }

        show_error('PHPActiveRecord: The configuration file database.php does not exist.');
    }

    private function load_php_activerecord_connections_config($db_config) {

        $connections = array();

        foreach ($db_config['db'] as $conn_name => $conn) {

            $connections[$conn_name] = 
                            $conn['dbdriver'].
                '://'       .$conn['username'].
                ':'         .$conn['password'].
                '@'         .$conn['hostname'].
                '/'         .$conn['database'].
                '?charset=' .$conn['char_set'];
        }

        return $connections;
    }
}