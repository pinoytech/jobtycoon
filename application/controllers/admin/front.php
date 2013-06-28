<?php

class Front extends Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		if ($this->auth->logged_in())
		{
			redirect('admin/front/dashboard');
		}
		else
		{
			redirect('admin/front/login');
		}
	}
	function login()
	{
		if ($this->auth->logged_in())
		{
			redirect('admin/front/dashboard');
		}

		$this->data['title'] = $this->lang->line('header_administration_login');

		if ($this->form_validation->run('login') === TRUE)
		{
			redirect('admin/front/dashboard');
		}
		$this->load->view('admin/front/login', $this->data);
	}

	function _user_check()
	{
		if ($this->auth->login(purify($this->input->post('username')), purify($this->input->post('password'))))
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('_user_check', 'Username and password combination is not valid');
			return FALSE;
		}
	}

	function dashboard()
	{
		if ( ! $this->auth->logged_in())
		{
			redirect('admin/front/logout');
		}

		$this->data['title'] = 'Dashboard';
		$this->load->view('admin/front/dashboard', $this->data);
	}

	function logout()
	{
		$this->auth->logout();
		redirect('admin/front/login');
	}
}

/* End of file front.php */
/* Location: ./system/application/controllers/front.php */