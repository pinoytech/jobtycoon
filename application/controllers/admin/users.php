<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		if ( ! $this->auth->logged_in(array('admin')))
		{
			redirect('admin/front/logout');
		}
		else
		{
			redirect('admin/users/manage');
		}
	}

	function manage()
	{
		if ( ! $this->auth->logged_in(array('admin')))
		{
			redirect('admin/front/logout');
		}

		$this->data['title'] = $this->lang->line('header_manage_users');

		$per_page = 10;
		$total = $this->users_model->get_user_count();
		$this->data['users'] = $this->users_model->get_users($per_page, (int) $this->uri->segment(4));

		$pagination['base_url'] = site_url('admin/users/manage');
		$pagination['total_rows'] = $total;
		$pagination['uri_segment'] = 4;

		$this->pagination->initialize($pagination);

		$this->load->view('admin/users/manage', $this->data);
	}

	function search()
	{
		if ( ! $this->auth->logged_in(array('admin')))
		{
			redirect('admin/front/logout');
		}

		$this->data['title'] = $this->lang->line('header_manage_users');

		if ($this->input->post('keyword'))
		{
			$this->session->set_userdata('user_keyword', purify($this->input->post('keyword')));
		}

		$per_page = 10;
		$total = $this->users_model->get_user_count($this->session->userdata('user_keyword'));
		$this->data['users'] = $this->users_model->get_users($per_page, (int) $this->uri->segment(4), $this->session->userdata('user_keyword'));

		$pagination['base_url'] = site_url('admin/users/manage');
		$pagination['total_rows'] = $total;
		$pagination['uri_segment'] = 4;

		$this->pagination->initialize($pagination);

		$this->load->view('admin/users/manage', $this->data);
	}

	function add()
	{
		if ( ! $this->auth->logged_in(array('admin')))
		{
			redirect('admin/front/logout');
		}

		if ($this->form_validation->run('add_user') === TRUE)
		{

			$this->users_model->username    = purify($this->input->post('username'));
			$this->users_model->first_name  = purify($this->input->post('first_name'));
			$this->users_model->last_name   = purify($this->input->post('last_name'));
			$this->users_model->email       = purify($this->input->post('email'));
			$this->users_model->password    = purify($this->input->post('password'));
			$this->users_model->role        = 'employer';
			$this->users_model->account_id  = purify($this->input->post('account'));

			if ($this->users_model->save())
			{
				$this->session->set_flashdata('message', $this->lang->line('user_saved'));
			}
			else
			{
				$this->session->set_flashdata('message', $this->lang->line('error_occurred_while_saving'));
			}

			redirect('admin/users/add');
		}

		$this->data['title'] = $this->lang->line('header_add_user');
		$this->data['accounts'] = $this->accounts_model->get_accounts();
		$this->load->view('admin/users/add', $this->data);
	}

	function edit($user_id)
	{
		if ( ! $this->auth->logged_in(array('admin')))
		{
			redirect('admin/front/logout');
		}

		if ($_POST AND $this->input->post('password'))
		{
			$validation = 'edit_user_wpassword';
		}
		else
		{
			$validation = 'edit_user';
		}

		if ($this->form_validation->run($validation) === TRUE)
		{
			$this->users_model->first_name  = purify($this->input->post('first_name'));
			$this->users_model->last_name   = purify($this->input->post('last_name'));
			$this->users_model->email       = purify($this->input->post('email'));
			$this->users_model->password    = purify($this->input->post('password'));

			if ($this->users_model->save($user_id))
			{
				$this->session->set_flashdata('message', $this->lang->line('user_saved'));
			}
			else
			{
				$this->session->set_flashdata('message', $this->lang->line('user_saved'));
			}
			redirect('admin/users/edit/'.$user_id);
		}

		$this->data['title'] = $this->lang->line('header_edit_user');

		if ( ! ($this->data['user'] = $this->users_model->get_user($user_id)))
		{
			show_error($this->lang->line('error_invalid_user_id'));
		}

		$this->data['accounts'] = $this->accounts_model->get_accounts();
		$this->load->view('admin/users/edit', $this->data);
	}

	function delete()
	{
		if ( ! $this->auth->logged_in(array('admin')))
		{
			redirect('admin/front/logout');
		}

		if ( ! $this->users_model->delete(purify($this->input->post('users'))))
		{
			$this->session->set_flashdata('message', $this->lang->line('error_invalid_user_request'));
		}

		redirect('admin/users/manage');
	}
}

/* End of file users.php */
/* Location: ./system/application/controllers/users.php */