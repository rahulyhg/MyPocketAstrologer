<?php

class Page {

	private $current_page_number = 1;
	private $per_page = 20;
	private $total_pages = 1;

	public function set_current_page_number($current_page_number) {

		if(!is_null($current_page_number)) {

			$this->current_page_number = $current_page_number;
		}
	}

	public function set_per_page($per_page) {

		if(!is_null($per_page)) {

			$this->per_page = $per_page;
		}
	}

	public function set_total_pages($total_pages) {

		if(!is_null($total_pages)) {

			$this->total_pages = $total_pages;
		}
	}

	public function get_current_page_number() {

		return $this->current_page_number;
	}

	public function get_per_page() {

		return $this->per_page;
	}

	public function get_total_pages() {

		return $this->total_pages;
	}

	public function get_next_page() {

		if($this->current_page_number < $this->total_pages) {

			return $this->current_page_number + 1;
		}
	}

	public function get_previous_page() {

		if($this->current_page_number > 1) {

			return $this->current_page_number - 1;
		}
	}
}