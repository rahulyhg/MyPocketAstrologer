<?php

class Search implements ArrayAccess, Iterator {

	protected $search_term = null;
	protected $order = '';
	private $field = 'id';
	private $direction = 'ASC';
	private $page = null;
	private $deleted = null;
	private $active = null;

	private $pointer = 0;

	private $abstract_models = array();

	public function __construct() {

	}

	public function set_search_term($search_term = null) {

		if(!is_null($search_term)) {

			$search_term = urldecode($search_term);
			$this->search_term = trim($search_term);
		}

		return $this;
	}

	public function set_page(Page $page) {

		if(!is_null($page)) {

			$this->page = $page;
		}

		return $this;
	}

	private function set_field($field = null) {

		if(!is_null($field)) {

			$this->field = $field;
		}
	}

	private function set_direction($direction = null) {

		if(!is_null($direction)) {

			$this->direction = $direction;
		}
	}

	public function set_order($field = null, $direction = null) {

		$this->set_field($field);
		$this->set_direction($direction);
		
		$this->order = $this->field . ' ' . $this->direction;

		return $this;
	}

	public function set_deleted($deleted = null) {

		if(!is_null($deleted)) {

			$this->deleted = $deleted;
		}

		return $this;
	}

	public function set_active($active = null) {

		if(!is_null($active)) {

			$this->active = $active;
		}

		return $this;
	}

	public function offsetExists($offset) {

		return array_key_exists($offset, $this->abstract_models);
	}

	public function offsetSet($offset, $values) {

		$this->abstract_models[$offset] = $values;
	}

	public function offsetGet($offset) {

		return ($this->offsetExists($offset) ? $this->abstract_models[$offset] : Null);
	}

	public function offsetUnset($offset) {

		if($this->offsetExists($offset)) {

			unset($this->abstract_models[$offset]);
		}
	}

	/* Iterator */

	public function key() {
		return $this->pointer;
	}

	public function current() {
		return $this->abstract_models[$this->pointer];
	}

	public function next() {
		$this->pointer++;
	}

	public function rewind() {
		$this->pointer = 0;
	}

	public function seek($position) {
		$this->pointer = $position;
	}

	public function valid() {
		return isset($this->abstract_models[$this->pointer]);
	}

	public function get_search_term() {

		return $this->search_term;
	}

	public function get_order() {

		if($this->order == '') {

			return $this->field. ' ' .$this->direction;
		}

		return $this->order;
	}

	public function get_field() {

		return $this->field;
	}

	public function get_direction() {

		return $this->direction;
	}

	public function get_current_page() {

		if(!is_null($this->page)) {

			return $this->page->get_current_page_number();
		}
	}

	public function get_page_size() {

		if(!is_null($this->page)) {

			return $this->page->get_per_page();
		}
	}

	public function get_deleted() {

		if(!is_null($this->deleted)) {

			return $this->deleted;
		}
	}

	public function get_active() {

		if(!is_null($this->active)) {

			return $this->active;
		}
	}

	public function get_row_per_current_page() {

		return count($this->abstract_models);
	}

	public function get_total_rows() {
		return $this->total_rows;
	}

	protected function build_offset() {

		if(!is_null($this->get_page_size())) {
			return ($this->get_current_page() - 1) * ($this->get_page_size());
		}

		return '';
	}

	protected function build_options() {

		$options = (object) array();

		if(!is_null($this->active)) {

			$options->active = $this->active;
		}

		if(!is_null($this->deleted)) {

			$options->deleted = $this->deleted;
		}

		if(!is_null($this->search_term)) {

			$options->search = $this->search_term;
		}

		return $options;
	}

	protected function build_conditions($options, $table_name) {

		$conditions = array();
        $condition_string = '1=1 ';

		if (isset($options->active)) {

			$condition_string .= 'and '.$table_name.'.active = ? ';
			array_push($conditions, $options->active);
		}

		if (isset($options->deleted)) {

			$condition_string .= 'and '.$table_name.'.deleted = ? ';
			array_push($conditions, $options->deleted);
		}

		array_unshift($conditions, $condition_string);

        return $conditions;
	}

	public function execute($model, $query) {

		$class = get_class($model);

		$query['select'] = 'SQL_CALC_FOUND_ROWS '.$class::$table_name.'.*';

		$result_models = $class::all($query);

		$this->total_rows = $class::found_rows();

		$this->abstract_models = $result_models;
	}

}