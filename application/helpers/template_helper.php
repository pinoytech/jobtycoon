<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_sidebar'))
{
	function get_sidebar()
	{
		$ci =& get_instance();
		$ci->load->view("template/sidebar");
	}
}

if ( ! function_exists('get_header'))
{
	function get_header()
	{
		$ci =& get_instance();
		$ci->load->view("template/header");
	}
}

if ( ! function_exists('get_footer'))
{
	function get_footer()
	{
		$ci =& get_instance();
		$ci->load->view("template/footer");
	}
}

if ( ! function_exists('get_job_form'))
{
	function get_job_form()
	{
		$ci =& get_instance();
		$ci->load->view("template/job_form");
	}
}

if ( ! function_exists('get_categories'))
{
	function get_categories()
	{
		$ci =& get_instance();
		$result = $ci->categories_model->get_categories();
		if ($result->num_rows() > 0)
		{
			echo ('<ul>');
			$categories = $result->result();
			foreach ($categories as $category)
			{
				echo '<li>'.anchor('job/category/'.$category->categories_id.'/'.$category->categories_uri, $category->categories_name).'</li>';
			}
			echo ('</ul>');
		}
	}
}