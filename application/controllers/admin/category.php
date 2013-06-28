<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends MY_Controller {

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
		redirect('admin/category/manage');
	}

	function manage()
	{
		if ( ! $this->auth->logged_in(array('admin')))
		{
			redirect('admin/front/logout');
		}

		$this->data['title'] = $this->lang->line('header_manage_categories');

		$per_page = 10;
		$total = $this->categories_model->get_category_count();
		$this->data['categories'] = $this->categories_model->get_categories($per_page, (int) $this->uri->segment(4));

		$pagination['base_url'] = site_url('admin/category/manage');
		$pagination['total_rows'] = $total;
		$pagination['uri_segment'] = 4;

		$this->pagination->initialize($pagination);

		$this->load->view('admin/category/manage', $this->data);
	}

	function search()
	{
		if ( ! $this->auth->logged_in(array('admin')))
		{
			redirect('admin/front/logout');
		}

		$this->data['title'] = $this->lang->line('header_search_categories');

		if ($this->input->post('keyword'))
		{
			$this->session->set_userdata('category_keyword', purify($this->input->post('keyword')));
		}

		$per_page = 10;
		$total = $this->categories_model->get_category_count($this->session->userdata('category_keyword'));
		$this->data['categories'] = $this->categories_model->get_categories($per_page, (int) $this->uri->segment(4), $this->session->userdata('category_keyword'));

		$pagination['base_url'] = site_url('admin/category/search');
		$pagination['total_rows'] = $total;
		$pagination['uri_segment'] = 4;

		$this->pagination->initialize($pagination);

		$this->load->view('admin/category/search', $this->data);
	}

	function add()
	{
		if ( ! $this->auth->logged_in(array('admin')))
		{
			redirect('front/logout');
		}

		$this->data['title'] = $this->lang->line('header_add_category');;

		if ($this->form_validation->run('add_category') === TRUE)
		{
			$this->categories_model->name     = purify($this->input->post('category_name'));
			$this->categories_model->uri      = url_title(purify($this->input->post('category_name')),'dash', TRUE);
			$this->categories_model->date_add = date("Y-m-d G:i:s");
			$this->categories_model->date_upd = date("Y-m-d G:i:s");
			
			if ($this->categories_model->save())
			{
				$this->session->set_flashdata('message', $this->lang->line('category_saved'));
			}
			else
			{
				$this->session->set_flashdata('message', $this->lang->line('error_occurred_while_saving'));
			}

			redirect('admin/category/add');
		}

		$this->load->view('admin/category/add', $this->data);
	}

	function delete()
	{
		if ( ! $this->auth->logged_in(array('admin')))
		{
			redirect('front/logout');
		}

		if ( ! ($default_category = $this->categories_model->get_default_category()))
		{
			$this->session->set_flashdata('message', $this->lang->line('error_no_default_category'));
		}
		else
		{
			if ( ! $this->categories_model->delete($default_category, purify($this->input->post('categories'))))
			{
				$this->session->set_flashdata('message', $this->lang->line('error_invalid_category_request'));
			}
		}

		redirect('admin/category/manage');
	}

	function edit($category_id)
	{
		if ( ! $this->auth->logged_in(array('admin')))
		{
			redirect('front/logout');
		}

		if ($this->form_validation->run('edit_category') === TRUE)
		{
			$this->categories_model->name     = purify($this->input->post('category_name'));
			$this->categories_model->uri      = url_title(purify($this->input->post('category_name')), 'dash', TRUE);
			$this->categories_model->date_upd = date("Y-m-d G:i:s");

			if ($this->categories_model->save($category_id))
			{
				$this->session->set_flashdata('message', $this->lang->line('category_saved'));
			}
			else
			{
				$this->session->set_flashdata('message', $this->lang->line('error_occurred_while_saving'));
			}

			redirect('admin/category/edit/'.$category_id);
		}

		if ( ! ($this->data['category'] = $this->categories_model->get_category($category_id)))
		{
			show_error($this->lang->line('error_invalid_category_id'));
		}

		$this->data['category_id'] = $category_id;
		$this->data['title'] = $this->lang->line('header_edit_category');

		$this->load->view('admin/category/edit', $this->data);
	}
}

/* End of file category.php */
/* Location: ./application/controllers/category.php */