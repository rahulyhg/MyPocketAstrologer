<?php

class User extends BaseModel {

	/* Table Name */

	static $table_name = 'users';

	static $has_many = array(

		array(
            'login_device',
            'class_name' => 'LoginDevice',
            'foreign_key' => 'user_id',
        ),

        array(
            'payment',
            'class_name' => 'Payment',
            'foreign_key' => 'user_id',
        ),

        array(
            'puja',
            'class_name' => 'Puja',
            'foreign_key' => 'user_id'
        ),

        array(
            'query',
            'class_name' => 'Query',
            'foreign_key' => 'user_id'
        ),
	);

	static $has_one = array(

		array(
            'natal_chart',
            'class_name' => 'NatalChart',
            'foreign_key' => 'user_id'
        ),
	);

	/* Public functions - Setters */

    private function is_email_available($email) {

    	if($this->is_new_record()) {

			if(self::exists(array('email' => $email))) { 
				throw new Exception('The email entered already exists.'); 
			}
    	}
    }

    public function increment_queries_count() {
		$this->queries_count += 1;
	}

	public function decrement_queries_count() {
		$this->queries_count -= 1;
	}

    public function set_first_name($first_name) {

    	if($first_name == '') {
			throw new Exception('Please Enter First Name.');
        }

		$this->assign_attribute('first_name', $first_name);	
    }

    public function set_last_name($last_name) {

    	if($last_name == '') {
			throw new Exception('Please Enter Last Name.');
        }

		$this->assign_attribute('last_name', $last_name);	
    }

    public function set_email($email) {

    	if($email == '') {
			throw new Exception('Please Enter Email Address.');
        }

        $this->is_email_available($email);
		$this->assign_attribute('email', $email);	
    }

    public function set_password($password) {

    	if($password == '') {
			throw new Exception('Please Enter Password');
        }

        $password = sha1($password);
		$this->assign_attribute('password', $password);	
    }

    public function set_user_type($user_type) {

    	if($user_type == '') {
			throw new Exception('Please Select a User Type.');
        }

		$this->assign_attribute('user_type', $user_type);	
    }

    public function set_date_of_birth($date_of_birth) {

    	if($date_of_birth == '') {
			throw new Exception('Please Enter Date of Birth.');
        }

		$this->assign_attribute('date_of_birth', $date_of_birth);	
    }

    public function set_place_of_birth($place_of_birth) {

    	if($place_of_birth == '') {
			throw new Exception('Please Enter Place of Birth.');
        }

		$this->assign_attribute('place_of_birth', $place_of_birth);	
    }

    public function set_is_accurate($is_accurate) {

    	if($is_accurate == '') {
			throw new Exception('Please Mention if the time of birth is accurate.');
        }

		$this->assign_attribute('is_accurate', $is_accurate);	
    }

    public function set_gender($gender) {

    	if($gender == '') {
			throw new Exception('Please Enter Gender.');
        }

		$this->assign_attribute('gender', $gender);	
    }

    public function set_profile_pic($profile_pic) {
		$this->assign_attribute('profile_pic', $profile_pic);	
    }

    public function set_left_palm($left_palm) {
		$this->assign_attribute('left_palm', $left_palm);	
    }

    public function set_right_palm($right_palm) {
		$this->assign_attribute('right_palm', $right_palm);	
    }

	/* Public functions - Getters */

	public function get_first_name() {
		return $this->read_attribute('first_name');
	}

	public function get_last_name() {
		return $this->read_attribute('last_name');
	}

	public function get_email() {
		return $this->read_attribute('email');
	}

	public function get_password() {
		return $this->read_attribute('password');
	}

	public function get_user_type() {
		return $this->read_attribute('user_type');
	}

	public function get_date_of_birth() {
		return $this->read_attribute('date_of_birth');
	}

	public function get_place_of_birth() {
		return $this->read_attribute('place_of_birth');
	}

	public function get_gender() {
		return $this->read_attribute('gender');
	}

	public function get_is_accurate() {
		return $this->read_attribute('is_accurate');
	}

	public function get_profile_pic() {
		return $this->read_attribute('profile_pic');
	}

	public function get_left_palm() {
		return $this->read_attribute('left_palm');
	}

	public function get_right_palm() {
		return $this->read_attribute('right_palm');
	}

	public function get_queries_count() {
		return $this->read_attribute('queries_count');
	}


	/* Public functions - General */

	public function is_password($password) {
		return ($this->password == sha1($password));
	}

	public function login($password) {

		if(!$this->is_password($password)) {
			throw new Exception('The email/password combination is not valid.');
		}

		return true;
	}

	public function reset_password($new_password, $new_password_confirm) {

		if($new_password == '') {
			throw new Exception('Please enter a new password.');
		}

		if($new_password !== $new_password_confirm) {
			throw new Exception('The password confirmation entered does not match.');
		}

		$this->password = $new_password;
	}

	/* Public static functions */

	public static function create($params) {

		$user = new User;

		$user->first_name = array_key_exists('first_name', $params) ? $params['first_name'] : null;
		$user->last_name = array_key_exists('last_name', $params) ? $params['last_name'] : null;
		$user->email = array_key_exists('email', $params) ? $params['email'] : null;
		$user->gender = array_key_exists('gender', $params) ? $params['gender'] : null;
		$user->date_of_birth = array_key_exists('date_of_birth', $params) ? $params['date_of_birth'] : null;
		$user->profile_pic = array_key_exists('profile_pic', $params) ? $params['profile_pic'] : null;
		$user->is_accurate = array_key_exists('is_accurate', $params) ? $params['is_accurate'] : null;
		$user->left_palm = array_key_exists('left_palm', $params) ? $params['left_palm'] : null;
		$user->right_palm = array_key_exists('right_palm', $params) ? $params['right_palm'] : null;
		$user->place_of_birth = array_key_exists('place_of_birth', $params) ? $params['place_of_birth'] : null;

		$user->reset_password(
			 array_key_exists('password', $params) ? $params['password'] : null,
			 array_key_exists('confirm_password', $params) ? $params['confirm_password'] : null
		);

		$user->password = $params['password'];
		$user->user_type = array_key_exists('user_type', $params) ? $params['user_type'] : null;

		$user->save();
		return $user;
	}

	public static function __callStatic($method, $args) {

		if (substr($method,0,13) === 'find_valid_by') {
			$attributes = substr($method,14);
			$options['conditions'] = ActiveRecord\SQLBuilder::create_conditions_from_underscored_string(static::connection(),$attributes,$args,static::$alias_attribute);

			$user = static::find('first',$options);

			self::check_user_is_valid($user);

			return $user;
		}

		return parent::__callStatic($method, $args);
	}

	private static function check_user_is_valid($user) {

		if(!$user instanceOf User) {
			throw new Exception('The username entered does not exist');
		}
	}
}

?>