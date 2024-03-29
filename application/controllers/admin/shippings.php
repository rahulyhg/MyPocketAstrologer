<?php

class Shippings extends BaseController {

	public function index() {

        $shippings = Shipping::find('all', array(
                                            /*'conditions' => array(
                                                'deleted = ?',
                                                0
                                                ),*/
                                            'order' => 'id desc'
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

            if($shipping->type == 1) {

                $params = array(
                            'user' => $shipping->user,
                            'object_type' => 1,
                            'notification_type' => 6,
                            'information_type' => 0,
                            'object_id' => $shipping->user->natal_chart->id,
                            'details' => 'Quotation add to Shipping',
                        );

                $push = new PushNotificationLog;
                $push->create($params);
            }

            elseif($shipping->type == 2) {

                $params = array(
                            'user' => $shipping->user,
                            'object_type' => 2,
                            'notification_type' => 6,
                            'information_type' => 0,
                            'object_id' => $shipping->gemstone_id,
                            'details' => 'Quotation add to Shipping',
                        );

                $push = new PushNotificationLog;
                $push->create($params);
            }

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

    public function send_quotation($quotation_id) {

        try {

            $quotation = Quotation::find_by_id($quotation_id);

            if(!$quotation)
                throw new Exception("Invalid Quotation!");                
            
            if($quotation->approved == 1)
                throw new Exception("Invalid Quotation!");

            $gcm_users = $quotation->shipping->user->gcm_users;

            $data = array(
                        'address' => array(
                                        'country' => $quotation->shipping->country,
                                        'state' => $quotation->shipping->state,
                                        'city' => $quotation->shipping->city,
                                        'street_address' => $quotation->shipping->street,
                                        'apt_no' => $quotation->shipping->apt_no,
                                        'postal_code' => $quotation->shipping->postal_code,
                                        'phone_number' => $quotation->shipping->phone_number,
                                    ),
                        'type' => $quotation->shipping->type,
                        'total_cost' => $quotation->total_cost,                                        
                        'date' =>  date("Y-m-d H:i:s", strtotime($quotation->date)),
                        'object_cost' => $quotation->object_cost,
                        'shipping_cost' => $quotation->shipping_cost,
                        'to_whom' => $quotation->shipping->full_name,
                        'shipping_company_name' => $quotation->company_name,
                        'quotation_number' => $quotation->quotation_number,
                        'days' => $quotation->days,
                        'object_id' => $quotation->shipping->gemstone_id,
                    );

            if($quotation->shipping->type == 1)
                $data['object'] = 'Natal Chart';

            elseif($quotation->shipping->type == 2)
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

            if($quotation->shipping->type == 1) {

                $params = array(
                            'user' => $quotation->shipping->user,
                            'object_type' => 1,
                            'notification_type' => 6,
                            'information_type' => 0,
                            'object_id' => $quotation->shipping->user->natal_chart->id,
                            'details' => 'Quotation sent to the User',
                        );

                $push = new PushNotificationLog;
                $push->create($params);
            }

            elseif($quotation->shipping->type == 2) {

                $params = array(
                            'user' => $quotation->shipping->user,
                            'object_type' => 2,
                            'notification_type' => 6,
                            'information_type' => 0,
                            'object_id' => $quotation->shipping->gemstone_id,
                            'details' => 'Quotation sent to the User',
                        );

                $push = new PushNotificationLog;
                $push->create($params);
            }

            $this->session->set_flashdata(
                'alert_success', 
                "Quotation sent to the user successfully."
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

    public function complete($shipping_id) {

        try {

            $shipping = Shipping::find_by_id_and_completed($shipping_id, 0);

            if(!$shipping)
                throw new Exception("Shipping Order not found");

            $shipping->completed = 1;
            $shipping->save();

            $gcm_users = $shipping->user->gcm_users;

            if($shipping->type == 1) {

                $natal_chart = NatalChart::find_by_user_id($shipping->user_id);
                $natal_chart->status = 4;
                $natal_chart->save();

                $message = json_encode(array(
                                'type' => 2,
                                'data' => array(
                                            'information_type' => 3,
                                            'description' => "Your Natal Chart is shipped now. It will take ".$shipping->quotation->days." days for the delivery.",
                                        ),
                                ));

            }

            elseif($shipping->type == 2) {

                $user_gemstone = UserGemstone::find_by_id($shipping->gemstone_id);
                $user_gemstone->status = 3;
                $user_gemstone->save();

                $data = array(
                                'information_type' => 3,
                                'gemstone_id' => $user_gemstone->id,
                                'gems_description' => $user_gemstone->details,
                                'gem_stone_type' => $user_gemstone->gemstone_id,
                                );

                $message = json_encode(array(
                                'type' => 4,
                                'data' => $data
                                ));
            }

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

            if($shipping->type == 1) {

                $params = array(
                            'user' => $shipping->user,
                            'object_type' => 1,
                            'notification_type' => 2,
                            'information_type' => 3,
                            'object_id' => $shipping->user->natal_chart->id,
                            'details' => 'Shipping completed',
                        );

                $push = new PushNotificationLog;
                $push->create($params);
            }

            elseif($shipping->type == 2) {

                $params = array(
                            'user' => $shipping->user,
                            'object_type' => 2,
                            'notification_type' => 4,
                            'information_type' => 3,
                            'object_id' => $shipping->gemstone_id,
                            'details' => 'Shipping completed',
                        );

                $push = new PushNotificationLog;
                $push->create($params);
            }

            $this->session->set_flashdata('alert_success', "Shipping order completion confirmed successfully");

            redirect('admin/shippings');

        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/shippings');
        }
    }

    public function view_quotation($shipping_id) {

        try {

            $shipping = Shipping::find_by_id($shipping_id);

            if(!$shipping)
                throw new Exception("Shipping Order not found");

            if(!$shipping->quotation)
                throw new Exception("Quotation not found");

            return $this->load_view('admin/view_quotation', array('quotation' => $shipping->quotation));                
        }

        catch(Exception $e) {

            $this->session->set_flashdata('alert_error', $e->getMessage());

            redirect('admin/shippings');
        }        
    }
}