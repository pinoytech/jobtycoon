<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		if ( ! $this->auth->logged_in(array('admin', 'employer')))
		{
			redirect('front/logout');
		}
		redirect('admin/jobs/manage');
	}

	function manage()
	{
		if ( ! $this->auth->logged_in(array('admin', 'employer')))
		{
			redirect('admin/front/logout');
		}

		$this->data['title'] = $this->lang->line('header_manage_jobs');

		$per_page = 10;
		$this->jobs_model->account_id = $this->session->userdata('account_id');
		$total = $this->jobs_model->get_jobs_count();
		$this->data['jobs'] = $this->jobs_model->get_jobs($per_page, (int) $this->uri->segment(4));

		$pagination['base_url'] = site_url('admin/jobs/manage');
		$pagination['total_rows'] = $total;
		$pagination['uri_segment'] = 4;

		$this->pagination->initialize($pagination);

		$this->load->view('admin/jobs/manage', $this->data);
	}

	function add()
	{
		if ( ! $this->auth->logged_in(array('admin', 'employer')))
		{
			redirect('admin/front/logout');
		}

		$this->data['title'] = $this->lang->line('header_add_job');

		if ($this->form_validation->run('add_job') == TRUE)
		{
			$this->jobs_model->account_id    = purify($this->input->post('account'));
			$this->jobs_model->title         = purify($this->input->post('job_title'));
			$this->jobs_model->uri           = url_title(purify($this->input->post('job_title')), 'dash',TRUE);
			$this->jobs_model->description   = purify($this->input->post('description'));
			$this->jobs_model->date_add      = date("Y-m-d G:i:s");
			$this->jobs_model->date_upd      = date("Y-m-d G:i:s");
			$this->jobs_model->categories    = purify($this->input->post('categories'));
			$this->jobs_model->save();

			$this->session->set_flashdata('message', $this->lang->line('job_saved'));
			redirect('admin/jobs/add');
		}

		$this->data['accounts'] = $this->accounts_model->get_accounts();
		$this->data['categories'] = $this->categories_model->get_categories();

		$this->load->view('admin/jobs/add', $this->data);
	}

	function delete()
	{
		if ( ! $this->auth->logged_in(array('admin', 'employer')))
		{
			redirect('front/logout');
		}

		if ( ! $this->jobs_model->delete(purify($this->input->post('jobs'))))
		{
			$this->session->set_flashdata('message', $this->lang->line('error_invalid_job_request'));
		}
		redirect('admin/jobs/manage');


	}

	function _check_job_permissions($job_id)
	{
		if ( ! $this->auth->logged_in('admin'))
		{
			return $this->jobs_model->check_job_permissions($job_id, (int) $this->session->userdata('account_id'));
		}
		return TRUE;
	}

	function edit()
	{
		$job_id = (int) $this->uri->segment(4);

		if ( ! $this->auth->logged_in(array('admin', 'employer')))
		{
			show_404();
		}

		if ( ! $this->jobs_model->get_job($job_id))
		{
			show_error($this->lang->line('error_invalid_job_id'));
		}

		if ( ! $this->_check_job_permissions($job_id))
		{
			show_error($this->lang->line('error_invalid_job_id'));
		}
		else
		{
			$this->data['job'] = $this->jobs_model->get_job($job_id);
		}

		if ($this->form_validation->run('edit_job') === TRUE)
		{
			$this->jobs_model->title         = purify($this->input->post('job_title'));
			$this->jobs_model->description   = purify($this->input->post('description'));
			$this->jobs_model->uri           = url_title(purify($this->input->post('job_title')), 'dash', TRUE);
			$this->jobs_model->date_upd      = date("Y-m-d G:i:s");
			$this->jobs_model->categories    = purify($this->input->post('categories'));
			$this->jobs_model->save($job_id);
			$this->session->set_flashdata('message', $this->lang->line('job_saved'));
			redirect('admin/jobs/edit/'.$job_id);
		}

		$this->data['title'] = $this->lang->line('header_edit_job');
		$this->data['categories'] = $this->categories_model->get_categories();
		$this->data['job_categories'] = $this->categories_model->get_job_categories($job_id);

		$this->load->view('admin/jobs/edit', $this->data);
	}

	function search()
	{
		if ( ! $this->auth->logged_in(array('admin', 'employer')))
		{
			redirect('admin/front/logout');
		}

		if ($this->input->post('keyword'))
		{
			$this->session->set_userdata('job_keyword', purify($this->input->post('keyword')));
		}

		$per_page = 10;
		$this->jobs_model->account_id = $this->session->userdata('account_id');
		$total = $this->jobs_model->get_jobs_count($this->session->userdata('job_keyword'));
		$this->data['jobs'] = $this->jobs_model->get_jobs($per_page, (int) $this->uri->segment(4), $this->session->userdata('job_keyword'));

		$pagination['base_url'] = site_url('admin/jobs/search');
		$pagination['total_rows'] = $total;
		$pagination['uri_segment'] = 4;

		$this->pagination->initialize($pagination);

		$this->data['title'] = $this->lang->line('header_search_jobs');
		$this->load->view('admin/jobs/search', $this->data);
	}
}

/* End of file jobs.php */
/* Location: ./application/controllers/admin/jobs.php */