<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('lang_url')){
	function lang_url($uri = '', $lc = false){
		if (class_exists('CI_Controller')){
			$CI =& get_instance();

			if (!$uri || $uri[0] != '/'){
				$uri = '/'.$uri;
			}

			if (!$lc){
				$lc = $CI->language_code;
			}
			$uri = '/'.$lc.$uri;
		}

		return $uri;
	}
}

if (!function_exists('switch_lang')){
	function switch_lang($lc = false){
		if ($lc && class_exists('CI_Controller')){
			$CI =& get_instance();

			$segments = $CI->uri->segment_array();
			$uri = '/'.$lc.'/';
			for ($i = 2; $i <= count($segments); $i++){
				$uri .= $segments[$i].'/';
			}

			return $uri;
		} else {
			return false;
		} 
	}
}

/* End of file AHQ_url_helper.php */
