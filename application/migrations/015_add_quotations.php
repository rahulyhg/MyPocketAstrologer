<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_quotations extends CI_Migration {

	public function up() {

		$fields = array(
		
			'id' => array(
				'type' => 'int',
				'auto_increment' => true,
			),

			'shipping_id' => array(
				'type' => 'int',
			),

			'total_cost' => array(
				'type' => 'int',
				'default' => 0,
			),

			'date' => array(
				'type' => 'datetime',
			),

			'object_cost' => array(
				'type' => 'int',
				'default' => 0,
			),

			'shipping_cost' => array(
				'type' => 'int',
				'default' => 0,
			),

			'company_name' => array(
				'type' => 'varchar',
				'constraint' => '250'
			),

			'quotation_number' => array(
				'type' => 'varchar',
				'constraint' => '250',
			),

			'days' => array(
				'type' => 'int',
				'default' => 0,
			),
			
			'active' => array(
				'type' => 'boolean',
				'default' => 1,
			),

			'deleted' => array(
				'type'=>'boolean',
				'default'=> 0,
			),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('quotations');

	}

	public function down() {
		$this->dbforge->drop_table('quotations');
	}
}