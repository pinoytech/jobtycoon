<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends MY_Controller {

	function __construct()
	{
		parent::__construct();

		if ( ! $this->auth->logged_in(array('admin', 'employer')))
		{
			redirect('admin/front/logout');
		}
	}
	
	function index()
	{
		if ( ! $this->auth->logged_in(array('admin')))
		{
			redirect('front/logout');
		}
		redirect('admin/accounts/manage');
	}

	function manage()
	{
		if ( ! $this->auth->logged_in(array('admin')))
		{
			redirect('admin/front/logout');
		}

		$this->data['title'] = $this->lang->line('header_manage_accounts');

		$per_page = 10;
		$total = $this->accounts_model->get_account_count();
		$this->data['accounts'] = $this->accounts_model->get_accounts($per_page, (int) $this->uri->segment(4), FALSE);

		$pagination['base_url'] = site_url('admin/accounts/manage');
		$pagination['total_rows'] = $total;
		$pagination['uri_segment'] = 4;

		$this->pagination->initialize($pagination);

		$this->load->view('admin/accounts/manage', $this->data);
	}

	function add()
	{
		if ( ! $this->auth->logged_in(array('admin')))
		{
			redirect('admin/front/logout');
		}

		$this->data['title'] = $this->lang->line('header_add_account');;

		if ($this->form_validation->run('add_account') === TRUE)
		{
			$this->accounts_model->name = purify($this->input->post('account_name'));
			$this->accounts_model->email = purify($this->input->post('email'));
			$this->accounts_model->date_add = date("Y-m-d G:i:s");
			$this->accounts_model->date_upd = date("Y-m-d G:i:s");
			$this->accounts_model->save();

			$this->session->set_flashdata('message', $this->lang->line('account_saved'));
			redirect('admin/accounts/add');
		}
		$this->load->view('admin/accounts/add', $this->data);
	}

	function delete()
	{
		if ( ! $this->auth->logged_in(array('admin')))
		{
			redirect('front/logout');
		}

		if ( ! $this->accounts_model->delete(purify($this->input->post('accounts'))))
		{
			$this->session->set_flashdata('message', $this->lang->line('error_invalid_account_request'));
		}

		redirect('admin/accounts/manage');
	}

	function edit()
	{
		$account_id = (int) $this->uri->segment(4);

		if ( ! $this->auth->logged_in('admin'))
		{
			show_404();
		}

		if ( ! ($this->data['account'] = $this->accounts_model->get_account($account_id)))
		{
			show_error($this->lang->line('error_invalid_account_id'));
		}

		if ($this->form_validation->run('edit_account') == TRUE)
		{
			$this->accounts_model->update_account($account_id);
			$this->session->set_flashdata('message', $this->lang->line('account_saved'));
			redirect('admin/accounts/edit/'.$account_id);
		}

		$this->data['title'] = $this->lang->line('header_edit_account');

		$this->load->view('admin/accounts/edit', $this->data);
	}

	function search()
	{
		if ($this->input->post('keyword'))
		{
			$this->session->set_userdata('account_keyword', purify($this->input->post('keyword')));
		}

		$this->data['title'] = $this->lang->line('header_search_accounts');

		$per_page = 10;
		$total = $this->accounts_model->get_account_count($this->session->userdata('account_keyword'));
		$this->data['accounts'] = $this->accounts_model->get_accounts($per_page, (int) $this->uri->segment(4), $this->session->userdata('account_keyword'));

		$pagination['base_url'] = site_url('admin/accounts/search');
		$pagination['total_rows'] = $total;
		$pagination['uri_segment'] = 4;

		$this->pagination->initialize($pagination);

		$this->load->view('admin/accounts/search', $this->data);
	}
}

/* End of file accounts.php */
/* Location: ./application/controllers/accounts.php */