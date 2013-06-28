<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth
{
	function __construct()
	{
		$this->ci =& get_instance();
	}

	function logged_in($roles = FALSE)
	{
		$status = FALSE;

		if ($this->ci->session->userdata('logged_in'))
		{
			$status = TRUE;
		}

		if ($roles)
		{
			if (is_array($roles))
			{
				if (in_array($this->ci->session->userdata('role'), $roles))
				{
					$status = TRUE;
				}
				else
				{
					$status = FALSE;
				}
			}
			else
			{
				if ($this->ci->session->userdata('role') == $roles)
				{
					$status = TRUE;
				}
				else
				{
					$status = FALSE;
				}
			}
		}

		return $status;
	}

	function login($username, $password)
	{
		$this->ci->db->select('id, account_id, username, password, role');
		$login = $this->ci->db->get_where('users', array('username' => $username, 'password'=> sha1($password)));
		if ($login->num_rows() > 0)
		{
			$login = $login->row();
			$logged_in_data = array
			(
				'user_id'    => $login->id,
				'account_id' => $login->account_id,
				'username'   => $login->username,
				'role'       => $login->role,
				'logged_in'  => TRUE
			);
			$this->ci->session->set_userdata($logged_in_data);
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function register_user($user_id = FALSE)
	{
		$user_array = array
		(
			'first_name'    => $this->first_name,
			'last_name'     => $this->last_name,
			'email'         => $this->email,
			'website'       => prep_url($this->website),
			'role'          => $this->role
		);

		if ($user_id)
		{
			if ( ! empty($this->password))
			{
				$user_array['password'] = sha1($this->password);
			}

			$this->ci->db->where('id', $user_id);
			$this->ci->db->update('users', $user_array);
			return $user_id;
		}
		else
		{
			$user_array['password'] = sha1($this->password);

			$user_array['username'] = $this->username;
			$this->ci->db->insert('users', $user_array);
			return $this->ci->db->insert_id();
		}
	}

	function username_check($username)
	{
		$this->ci->db->where('username', $username);
		$this->ci->db->from('users');
		$result = $this->ci->db->count_all_results();
		if ($result == 1)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function logout()
	{
		$this->ci->session->sess_destroy();
	}
}
/* End of file auth.php */
/* Location: ./application/libraries/auth.php */