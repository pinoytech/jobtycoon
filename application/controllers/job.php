<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job extends Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->data['title'] = $this->lang->line('header_recent_jobs');
		$per_page = 10;
		$total = $this->jobs_model->get_jobs_count();
		$this->data['jobs'] = $this->jobs_model->get_jobs($per_page, (int) $this->uri->segment(3), FALSE);

		$pagination['base_url'] = site_url('job/index');
		$pagination['total_rows'] = $total;
		$pagination['uri_segment'] = 3;

		$this->pagination->initialize($pagination);

		$this->load->view('template/index', $this->data);
	}

	function view()
	{
		$this->data['job_id'] = (int) $this->uri->segment(3);
		$this->data['uri'] = (string) $this->uri->segment(4);

		$this->data['job'] = $this->jobs_model->verify_job($this->data['job_id'], $this->data['uri']);

		if ($this->data['job'] === 0)
		{
			show_error($this->lang->line('error_invalid_job_id'));
		}
		elseif ($this->data['job'] === FALSE)
		{
			redirect('job/view/'.$this->data['job_id'].'/'.$this->jobs_model->get_uri($this->data['job_id']));
		}

		$upload = array
		(
			'upload_path'   => './uploads/',
			'allowed_types' => 'doc|docx'
		);

		$this->load->library('upload', $upload);

		if ($this->form_validation->run('submit_cv') == TRUE)
		{

			$this->load->library('email');

			// if you want to send using your email uncomment the line below
			// $this->email->from($this->config->item('site_email'), $this->config->item('site_owner'));

			// if you want to send using the email used by the applicant uncomment the line below
			$this->email->from($this->input->post('email'), $this->input->post('first_name').' ' .$this->input->post('last_name'));
			$this->email->to($this->accounts_model->get_account_email($this->data['job_id']));
			$this->email->subject($this->lang->line('message_email_subject'));
			$this->email->message(sprintf($this->lang->line('message_job_application'), $this->data['job']->jobs_title));
			$this->email->attach($this->file_path['full_path']);

			if ($this->email->send())
			{
				$this->session->set_flashdata('message', $this->lang->line('message_email_success'));
			}
			else
			{
				$this->session->set_flashdata('message', $this->lang->line('message_email_error'));
			}

			unlink ($this->file_path['full_path']);
			redirect('job/view/'.$this->data['job_id'].'/'.$this->data['uri']);
		}
		$this->data['title'] = $this->lang->line('header_view_job');
		$this->load->view('template/view', $this->data);
	}

	function _do_upload()
	{
		if ( ! validation_errors())
		{
			if ( ! $this->upload->do_upload())
			{
				$this->form_validation->set_message('_do_upload', $this->upload->display_errors());
				return FALSE;
			}
			else
			{
				$this->file_path = $this->upload->data();
				return TRUE;
			}
		}
	}

	function search()
	{
		if ($this->input->post('keyword'))
		{
			$this->session->set_userdata('job_keyword', purify($this->input->post('keyword')));
		}

		$per_page = 10;
		$total = $this->jobs_model->get_jobs_count($this->session->userdata('job_keyword'));
		$this->data['jobs'] = $this->jobs_model->get_jobs($per_page, (int) $this->uri->segment(3), $this->session->userdata('job_keyword'));

		$pagination['base_url'] = site_url('template/search');
		$pagination['total_rows'] = $total;
		$pagination['uri_segment'] = 3;

		$this->pagination->initialize($pagination);

		$this->data['title'] = $this->lang->line('header_search_jobs');
		$this->load->view('template/search', $this->data);
	}

	function category()
	{
		$this->data['category_id'] = (int) $this->uri->segment(3);
		$this->data['uri'] = (string) $this->uri->segment(4);

		$this->data['category'] = $this->categories_model->verify_category($this->data['category_id'], $this->data['uri']);

		if ($this->data['category'] === 0)
		{
			show_error($this->lang->line('error_invalid_category_id'));
		}
		elseif ($this->data['category'] === FALSE)
		{
			redirect('job/category/'.$this->data['category_id'].'/'.$this->categories_model->get_uri($this->data['category_id']));
		}

		$per_page = 10;
		$total = $this->jobs_model->get_jobs_count(NULL, $this->data['category_id']);
		$this->data['jobs'] = $this->jobs_model->get_jobs($per_page, (int) $this->uri->segment(5), NULL, $this->data['category_id']);

		$pagination['base_url'] = site_url('template/category');
		$pagination['total_rows'] = $total;
		$pagination['uri_segment'] = 3;

		$this->pagination->initialize($pagination);

		$this->data['title'] = '';
		$this->load->view('template/category', $this->data);
	}
}

/* End of file job.php */
/* Location: ./application/controllers/job.php */