<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migrate extends CI_Controller {

    public function __construct() {

        parent::__construct(false);

        $this->load->library('migration');
    }

    public function up() {
    
        $this->version = $this->get_migration_version() + 1;
        $this->message = 'Moved up to migration '.$this->version;
        $this->migrate_to_version();
    }

    public function down() {

        $this->version = $this->get_migration_version() - 1;
        $this->message = 'Moved down to migration '.$this->version;
        $this->migrate_to_version();
    }

    private function migrate_to_version() {

        $this->migration->version($this->version);
    }

    private function get_migration_version() {
        $row = $this->db->get('migrations')->row();
        return $row ? $row->version : 0;
    }

    public function reset() {
        $current_db = $this->db->database;

        $this->db->query("DROP DATABASE `$current_db`");
        $this->db->query("CREATE DATABASE `$current_db` DEFAULT CHARACTER SET utf8");
    }

    public function version($version) {
        $this->migration->version($version);
    }

}