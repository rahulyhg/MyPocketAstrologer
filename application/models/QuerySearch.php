<?php

class QuerySearch extends Search {

	public function __construct() {

		parent::__construct();
	}

	protected function build_joins() {

		return array('user');
	}

	protected function build_conditions($options) {

		$conditions = parent::build_conditions($options, Query::$table_name);

		$condition_string = $conditions[0];

		if(isset($options->search) && $options->search !== '') {

			$condition_string .= "and (
				".Query::$table_name.".query LIKE ?
					or ".Query::$table_name.".answer LIKE ?
					or ".User::$table_name.".first_name LIKE ?
					or ".User::$table_name.".last_name LIKE ?
					or ".User::$table_name.".email LIKE ?
					or ".User::$table_name.".place_of_birth LIKE ?
			)";
			
			array_push($conditions, '%'.$options->search.'%');
        	array_push($conditions, '%'.$options->search.'%');
        	array_push($conditions, '%'.$options->search.'%');
        	array_push($conditions, '%'.$options->search.'%');
        	array_push($conditions, '%'.$options->search.'%');
        	array_push($conditions, '%'.$options->search.'%');
		}

		$conditions[0] = $condition_string;

		return $conditions;
	}

	protected function build_options() {

		$options = parent::build_options();

		return $options;
	}

	public function execute() {

		$options = $this->build_options();
		$i = 0;

		$query = array(
			'joins' => $this->build_joins($options),
			'conditions' => $this->build_conditions($options),
			'order' => $this->get_order(),
			'limit' => $this->get_page_size(),
			'offset' => $this->build_offset(),
		);

		parent::execute(new Query, $query);
	}
}