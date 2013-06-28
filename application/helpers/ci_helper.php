<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('set_lang_line'))
{
	function set_lang_line($line)
	{
		$ci =& get_instance();

		return $ci->lang->line($line);
	}
}

if ( ! function_exists('flash_message'))
{
	function flash_message($line)
	{
		$ci =& get_instance();

		return ($ci->session->flashdata($line))
			? '<div class="success">'.$ci->session->flashdata($line).'</div>'
			: '';
	}
}

if ( ! function_exists('auth_role'))
{
	function auth_role($role)
	{
		$ci =& get_instance();

		return $ci->auth->logged_in($role);
	}
}

if ( ! function_exists('pagination_links'))
{
	function pagination_links()
	{
		$ci =& get_instance();

		if ( ! $ci->pagination->create_links())
			return;
		return 'Pages '.$ci->pagination->create_links();
	}
}

if ( ! function_exists('html_script'))
{
	function html_script($src)
	{
		return "<script type=\"text/javascript\" src=\"".base_url()."$src\"></script>";
	}
}


if ( ! function_exists('html_stylesheet'))
{
	function html_stylesheet($src, $media)
	{
		return "<link rel=\"stylesheet\" href=\"".base_url()."$src\" media=\"$media\" type=\"text/css\" />";

	}
}
