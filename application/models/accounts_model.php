<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts_model extends Model {

	function __construct()
	{
		parent::__construct();
	}

	function get_account_count($keyword = FALSE)
	{
		if ($keyword)
		{
			$this->db->like('accounts.name', $keyword);
		}

		return $this->db->count_all_results('accounts');
	}

	function get_accounts($limit = FALSE, $offset = FALSE, $keyword = FALSE)
	{
		$this->db->select('accounts.id as accounts_id, accounts.name as accounts_name, accounts.email as accounts_email');
		$this->db->select('(SELECT DATE_FORMAT(accounts.date_add, "%Y/%m/%d")) as accounts_add', FALSE);
		$this->db->select('(SELECT DATE_FORMAT(accounts.date_upd, "%Y/%m/%d")) as accounts_upd', FALSE);
		$this->db->order_by('accounts.name');

		if ($limit)
		{
			$this->db->limit($limit, $offset);
		}

		if ($keyword)
		{
			$this->db->like('accounts.name', $keyword);
		}

		return $this->db->get('accounts');
	}

	function get_account($account_id)
	{
		$this->db->select('accounts.id as accounts_id, accounts.name as accounts_name, accounts.email as accounts_email');
		$result = $this->db->get_where('accounts', array('id' => $account_id));
		if ($result->num_rows() === 0)
		{
			return FALSE;
		}
		else
		{
			return $result->row();
		}
	}

	function get_account_email($job_id)
	{
		return $this->db->select('email')
			->join('jobs', 'accounts.id = jobs.account_id', FALSE)
			->get_where('accounts', array('jobs.id' => $job_id))
			->row()
			->email;
	}

	function save($account_id = FALSE)
	{
		$account_data = array(
			'name'          => $this->name,
			'email'         => $this->email,
			'date_upd'      => $this->date_upd
		);

		if ($account_id)
		{
			$this->db->where('id', $account_id);
			$this->db->update('accounts', $account_data);
		}
		else
		{
			$account_data['date_add'] = $this->date_add;
			$this->db->insert('accounts', $account_data);
		}
	}

	function delete($account_ids = array())
	{
		if (is_array($account_ids))
		{
			foreach ($account_ids as $account_id)
			{

				$this->db->delete('accounts', array('id' => (int) $account_id));

				if ($this->db->affected_rows())
				{
					$this->_delete_job_data($account_id);
					$this->_delete_user_data($account_id);
				}
			}

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function _delete_user_data($account_id)
	{
		$this->db->where('account_id', $account_id);
		$this->db->delete('users');
	}

	function _delete_job_data($account_id)
	{
		$this->db->select('id');
		$this->db->where('account_id', $account_id);
		$jobs = $this->db->get('jobs');

		if ($jobs->num_rows > 0)
		{
			foreach ($jobs->result() as $job)
			{
				$this->db->where('id', $job->id);
				$this->db->delete('categories_jobs');
			}
		}

		$this->db->where('account_id', $account_id);
		$this->db->delete('jobs');
	}
}