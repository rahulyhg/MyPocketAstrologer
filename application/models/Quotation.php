<?php

class Quotation extends BaseModel {

	/* Table Name */

	static $table_name = 'quotations';

	/* Associations */

	static $belongs_to = array(
		
		array(
            'shipping',
            'class_name' => 'Shipping',
            'foreign_key' => 'shipping_id'
        ),
	);

	/* Public functions - Setters */

	public function set_shipping(Shipping $shipping) {

		$shipping->check_is_valid();
		$this->assign_attribute('shipping_id', $shipping->id);
	}

	public function set_total_cost($total_cost) {

		if($total_cost == '') {
			throw new Exception('Please enter the total cost.');
        }

		$this->assign_attribute('total_cost', $total_cost);	
	}

	public function set_date($date) {

		if($date == '')
			throw new Exception("Date is required");
			
		$this->assign_attribute('date', $date);	
	}

	public function set_object_cost($object_cost) {

		if($object_cost == '')
			throw new Exception("Object Cost is required");
			
		$this->assign_attribute('object_cost', $object_cost);	
	}

	public function set_shipping_cost($shipping_cost) {

		if($shipping_cost == '')
			throw new Exception("Shipping Cost is required");
			
		$this->assign_attribute('shipping_cost', $shipping_cost);	
	}

	public function set_company_name($company_name) {

		if($company_name == '')
			throw new Exception("Shipping Company Name is required");
			
		$this->assign_attribute('company_name', $company_name);	
	}

	public function set_quotation_number($quotation_number) {

		if($quotation_number == '')
			throw new Exception("Quotation Number is required");
			
		$this->assign_attribute('quotation_number', $quotation_number);	
	}

	public function set_days($days) {

		if($days == '')
			throw new Exception("Days for shipping is required");
			
		$this->assign_attribute('days', $days);	
	}


	/* Public functions - Getters */

	public function get_total_cost() {
		return $this->read_attribute('total_cost');
	}

	public function get_date() {
		return $this->read_attribute('date');
	}

	public function get_object_cost() {
		return $this->read_attribute('object_cost');
	}

	public function get_shipping_cost() {
		return $this->read_attribute('shipping_cost');
	}

	public function get_company_name() {
		return $this->read_attribute('company_name');
	}

	public function get_quotation_number() {
		return $this->read_attribute('quotation_number');
	}

	public function get_days() {
		return $this->read_attribute('days');
	}

	/* Public static functions */

	public static function create($params) {

		$quotation = new Quotation;

		$quotation->shipping = array_key_exists('shipping', $params) ? $params['shipping'] : null;
		$quotation->total_cost = array_key_exists('total_cost', $params) ? $params['total_cost'] : null;
		$quotation->date = array_key_exists('date', $params) ? $params['date'] : null;
		$quotation->object_cost = array_key_exists('object_cost', $params) ? $params['object_cost'] : null;
		$quotation->shipping_cost = array_key_exists('shipping_cost', $params) ? $params['shipping_cost'] : null;
		$quotation->company_name = array_key_exists('company_name', $params) ? $params['company_name'] : null;
		$quotation->quotation_number = array_key_exists('quotation_number', $params) ? $params['quotation_number'] : null;
		$quotation->days = array_key_exists('days', $params) ? $params['days'] : null;

		$quotation->save();

		return $quotation;
	}
}