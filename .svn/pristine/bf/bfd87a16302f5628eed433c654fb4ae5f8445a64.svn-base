<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
	var $template_data = [];

	function set($name, $value)
	{
		$this->template_data[$name] = $value;
	}

	function load($view = '' , $view_data = [], $return = FALSE)
	{
		$this->CI =& get_instance();
		$this->set('contents', $this->CI->load->view($view, $view_data, TRUE));         
		return $this->CI->load->view('layouts/app-layout', $this->template_data, $return);
	}
}
