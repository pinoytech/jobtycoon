<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs_model extends Model {

	function __construct()
	{
		parent::__construct();
	}

	function check_job_permissions($job_id, $account_id)
	{
		if ($account_id)
		{
			$this->db->where(array('account_id' => $account_id, 'id' => $job_id));
			return $this->db->count_all_results('jobs');
		}
		return FALSE;
	}

	function get_jobs_count($keyword = FALSE, $category_id = FALSE)
	{

		if(isset($this->account_id)  AND ($this->account_id != 0))
		{
			$this->db->where('account_id', $this->account_id);
		}

		if ($keyword)
		{
			$this->db->like('jobs.title', $keyword);
		}

		if ($category_id)
		{
			$this->db->join('categories_jobs', 'categories_jobs.job_id = jobs.id', 'LEFT');
			$this->db->where('categories_jobs.category_id', $category_id);
		}

		return $this->db->count_all_results('jobs');
	}

	function get_jobs($limit, $offset, $keyword = FALSE, $category_id = FALSE)
	{
		$this->db->select('jobs.id as jobs_id, jobs.title as jobs_title, jobs.uri as jobs_uri, jobs.description as jobs_description');
		$this->db->select('accounts.id as accounts_id, accounts.name as accounts_name');
		$this->db->select('(SELECT DATE_FORMAT(jobs.date_add, "%Y/%m/%d")) as jobs_date_add', FALSE);
		$this->db->select('(SELECT DATE_FORMAT(jobs.date_upd, "%Y/%m/%d")) as jobs_date_upd', FALSE);
		$this->db->join('accounts', 'accounts.id = jobs.account_id', 'LEFT');
		$this->db->order_by('jobs.date_add', 'DESC');
		$this->db->limit($limit, $offset);

		if(isset($this->account_id)  AND ($this->account_id != 0))
		{
			$this->db->where('account_id', $this->account_id);
		}

		if ($keyword)
		{
			$this->db->like('jobs.title', $keyword);
		}

		if ($category_id)
		{
			$this->db->join('categories_jobs', 'categories_jobs.job_id = jobs.id', 'LEFT');
			$this->db->where('categories_jobs.category_id', $category_id);
		}

		return $this->db->get('jobs');
	}

	function get_job($job_id)
	{
		$this->db->select('jobs.id as jobs_id, jobs.title as jobs_title, jobs.description as jobs_description');
		$this->db->select('accounts.id as accounts_id, accounts.name as accounts_name');
		$this->db->select('(SELECT DATE_FORMAT(jobs.date_add, "%Y/%m/%d")) as jobs_date_add', FALSE);
		$this->db->select('(SELECT DATE_FORMAT(jobs.date_upd, "%Y/%m/%d")) as jobs_date_upd', FALSE);
		$this->db->join('accounts', 'accounts.id = jobs.account_id', 'LEFT');
		$job = $this->db->get_where('jobs', array('jobs.id' => (int) $job_id));

		if ($job->num_rows() === 0)
		{
			return FALSE;
		}
		else
		{
			return $job->row();
		}
	}

	function verify_job($id, $uri)
	{
		$this->db->where('id', $id);
		$result = $this->db->count_all_results('jobs');

		if ($result == 0)
		{
			return 0;
		}

		$this->db->select('jobs.id as jobs_id, jobs.title as jobs_title, jobs.description as jobs_description, jobs.uri as jobs_uri');
		$this->db->select('accounts.id as accounts_id, accounts.name as accounts_name');
		$this->db->select('(SELECT DATE_FORMAT(jobs.date_add, "%Y/%m/%d")) as jobs_date_add', FALSE);
		$this->db->select('(SELECT DATE_FORMAT(jobs.date_upd, "%Y/%m/%d")) as jobs_date_upd', FALSE);
		$this->db->join('accounts', 'accounts.id = jobs.account_id', 'LEFT');
		$this->db->where(array('jobs.id' => $id, 'jobs.uri' => $uri));
		$query = $this->db->get('jobs');
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}

	function get_uri($id)
	{
		$this->db->select('uri');
		$this->db->where('id', $id);
		$result = $this->db->get('jobs');
		return $result->row()->uri;
	}

	function save($job_id = FALSE)
	{
		if ($job_id)
		{
			$this->_update($job_id);
		}
		else
		{
			$this->_insert();
		}
	}

	function delete($job_ids = array())
	{
		if (is_array($job_ids))
		{
			foreach ($job_ids as $job_id)
			{
				$this->db->delete('jobs', array('id' => $job_id));
				$this->db->where('job_id', $job_id);
				$this->db->delete('categories_jobs', array('job_id' => $job_id));
			}

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function _insert()
	{
		$job_data = array(
			'account_id'    => $this->account_id,
			'title'         => $this->title,
			'uri'           => $this->uri,
			'description'   => $this->description,
			'date_add'      => $this->date_add,
			'date_upd'      => $this->date_upd
		);

		$this->db->insert('jobs', $job_data);

		if ($this->db->affected_rows())
		{
			$this->_process_job_category($this->db->insert_id());
		}
	}

	function _update($job_id)
	{
		$job_data = array(
			'title'         => $this->title,
			'uri'           => $this->uri,
			'description'   => $this->description,
			'date_upd'      => $this->date_upd
		);

		$this->db->where('id', $job_id);
		$this->db->update('jobs', $job_data);

		if ($this->db->affected_rows())
		{
			$this->_process_job_category($job_id);
		}
	}

	function _process_job_category($job_id)
	{
		$this->db->delete('categories_jobs', array('job_id' => $job_id));

		foreach ($this->categories as $category)
		{
			$this->db->insert('categories_jobs', array('job_id' => $job_id, 'category_id' => $category));
		}
	}
}