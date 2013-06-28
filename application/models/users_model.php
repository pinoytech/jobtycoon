<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends Model {

	function __construct()
	{
		parent::__construct();
	}

	function get_user_count($keyword = FALSE)
	{
		if ($keyword)
		{
			$this->db->like('users.username', $keyword);
			$this->db->or_like('users.first_name', $keyword);
			$this->db->or_like('users.last_name', $keyword);
		}

		return $this->db->count_all_results('users');
	}

	function get_users($limit = FALSE, $offset = FALSE, $keyword = FALSE)
	{
		$this->db->select('users.id as users_id, users.username as users_username, users.first_name as users_first_name, users.last_name as users_last_name, users.role as users_role');
		$this->db->select('accounts.id as accounts_id, accounts.name as accounts_name');
		$this->db->join('accounts', 'users.account_id = accounts.id', 'LEFT');

		if ($limit)
		{
			$this->db->limit($limit, $offset);
		}

		if ($keyword)
		{
			$this->db->like('users.username', $keyword);
			$this->db->or_like('users.first_name', $keyword);
			$this->db->or_like('users.last_name', $keyword);
		}

		return $this->db->get('users');
	}

	function get_user($user_id)
	{
		$this->db->select('users.id as users_id, users.username as users_username, users.first_name as users_first_name, users.last_name as users_last_name, users.email as users_email, users.role as users_role');
		$result = $this->db->get_where('users', array('users.id' => (int) $user_id));

		if ($result->num_rows() === 0)
		{
			return FALSE;
		}
		else
		{
			return $result->row();
		}
	}

	function save($user_id = FALSE)
	{
		$saved = FALSE;

		if ($user_id)
		{
			$saved = $this->_update($user_id);
		}
		else
		{
			$saved = $this->_insert();
		}

		return $saved;
	}

	function delete($user_ids = array())
	{
		if (is_array($user_ids))
		{
			foreach ($user_ids as $user_id)
			{
				$this->db->delete('users', array('id' => $user_id));
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
		$user_data = array
		(
			'username'   => $this->username,
			'first_name' => $this->first_name,
			'last_name'  => $this->last_name,
			'email'      => $this->email,
			'password'   => sha1($this->password),
			'role'       => $this->role,
			'account_id' => $this->account_id
		);

		$this->db->insert('users', $user_data);

		if ($this->db->affected_rows())
		{
			return TRUE;
		}

		return FALSE;
	}

	function _update($user_id)
	{
		$user_data = array
		(
			'first_name' => $this->first_name,
			'last_name'  => $this->last_name,
			'email'      => $this->email
		);

		if ( ! empty($this->password))
		{
			$user_data['password'] = sha1($this->password);
		}

		$this->db->where('id', $user_id);
		$this->db->update('users', $user_data);

		if ($this->db->affected_rows())
		{
			return TRUE;
		}

		return FALSE;
	}

}
