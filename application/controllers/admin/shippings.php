<?php

class Shippings extends BaseController {

	public function index() {

        $shippings = Shipping::find('all', array(
                                            'conditions' => array(
                                                'deleted = ?',
                                                0
                                                ),
                                            'order' => 'created_at desc'
                                            ));

		return $this->load_view('admin/shipping', array('shippings' => $shippings));
	}

    public function add_quotation($shipping_id) {

        try {

            $shipping = Shipping::find_by_id($shipping_id);

            if(!$shipping) {
                throw new Exception("Invalid Shipping order!");                
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
               return $this->load_view('admin/quotation', array('shipping' => $shipping));
            }

            $params = array(
                        'shipping' => $shipping,
                        'total_cost' => $this->input->post('total_cost'),
                        'date' => $this->input->post('date'),
                        'object_cost' => $this->input->post('object_cost'),
                        'shipping_cost' => $this->input->post('shipping_cost'),
                        'company_name' => $this->input->post('company_name'),
                        'quotation_number' => $this->input->post('quotation_number'),
                        'days' => $this->input->post('days'),
                        'gemstone_id' => $shipping->gemstone_id,
                    );
                            
            $quotation = new Quotation;
            $quotation = $quotation->create($params);
            $quotation->save();

            $gcm_users = $shipping->user->gcm_users;

            $data = array(
                        'address' => array(
                                        'country' => $shipping->country,
                                        'state' => $shipping->state,
                                        'city' => $shipping->city,
                                        'street_address' => $shipping->street,
                                        'apt_no' => $shipping->apt_no,
                                        'postal_code' => $shipping->postal_code,
                                        'phone_number' => $shipping->phone_number,
                                    ),
                        'type' => $shipping->type,
                        'total_cost' => $quotation->total_cost,                                        
                        'date' =>  date("Y-m-d H:i:s", strtotime($quotation->date)),
                        'object_cost' => $quotation->object_cost,
                        'shipping_cost' => $quotation->shipping_cost,
                        'to_whom' => $shipping->full_name,
                        'shipping_company_name' => $quotation->company_name,
                        'quotation_number' => $quotation->quotation_number,
                        'days' => $quotation->days,
                        'object_id' => $shipping->gemstone_id,
                    );

            if($shipping->type == 1)
                $data['object'] = 'Natal Chart';

            elseif($shipping->type == 2)
                $data['object'] = 'Gemstone';

            $message = json_encode(array(
                            'type' => 6,
                            'data' => $data
                            ));

            $this->gcm->setMessage($message);

            foreach ($gcm_users as $gcm_user) {
                $this->gcm->addRecepient($gcm_user->gcm_regd_id);
            }

            // set additional data
            $this->gcm->setData(array(
                'stat' => 'OK'
            ));

            $this->gcm->setTtl(false);
            $this->gcm->setGroup(false);
            $this->gcm->send();

            $this->session->set_flashdata(
                'alert_success', 
                "Quotation added to the shipping order successfully."
            );

            redirect('/admin/shippings');
        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());
            redirect('/admin/shippings');
        }
    }

    public function delete($shipping_id) {

        try {

            $shipping = Shipping::find_by_id($shipping_id);

            if(!$shipping)
                throw new Exception("Shipping Order not found");

            if($shipping->deleted)
                throw new Exception("Shipping Order already deleted");

            $shipping->delete();

            $this->session->set_flashdata('alert_success', "Shipping order deleted successfully");

            redirect('admin/shippings');

        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/shippings');
        }
    }
}