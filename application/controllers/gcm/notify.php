<?php

class Notify extends CI_Controller {

	public function send_gcm() {

	    // simple loading
	    // note: you have to specify API key in config before
	        $this->load->library('gcm');

	    // simple adding message. You can also add message in the data,
	    // but if you specified it with setMesage() already
	    // then setMessage's messages will have bigger priority
	        $this->gcm->setMessage('Hello......');

	    // add recepient or few
	        $this->gcm->addRecepient('APA91bHUUOWDcnj5CKKDyFnAHnTqTqtx74dxeeZa2P91Y5Z-H7fve04r_JYCClrfdlP7zF-E9cQ6aXyBztrwvH1Ku2JyxZp7zJbah-8EqgH-Cee2p0fcGqpnmUZn-TaUaoff0ibNY_aH-aSesf1UmC5kJQIsOA5BTw');
	        //$this->gcm->addRecepient('afe1838279');

	    // set additional data
	        $this->gcm->setData(array(
	            'stat' => 'ok'
	        ));

	    // also you can add time to live
	        $this->gcm->setTtl(500);
	    // and unset in further
	        // $this->gcm->setTtl(false);

	    // set group for messages if needed
	        $this->gcm->setGroup('Test');
	    // or set to default
	        // $this->gcm->setGroup(false);

	    // then send
	        if ($this->gcm->send())
	            echo 'Success for all messages';
	        else
	            echo 'Some messages have errors';

	    // and see responses for more info
	        print_r($this->gcm->status);
	        print_r($this->gcm->messagesStatuses);

	    die(' Worked.');
	}
}