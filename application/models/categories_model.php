<?php

class Categories_model extends Model {

	function __construct()
	{
		parent::__construct();
	}

	function get_category_count($keyword = FALSE)
	{
		if ($keyword)
		{
			$this->db->like('categories.name', $keyword);
		}

		return $this->db->count_all_results('categories');
	}

	function get_categories($limit = FALSE, $offset = FALSE, $keyword = FALSE)
	{
		$this->db->select('categories.id as categories_id, categories.name as categories_name, categories.uri as categories_uri');
		$this->db->select('(SELECT COUNT(*) FROM categories_jobs WHERE category_id = categories.id) as job_count', FALSE);
		$this->db->join('categories_jobs', 'categories.id = categories_jobs.category_id', 'LEFT');
		$this->db->group_by('categories.id');

		if ($limit)
		{
			$this->db->limit($limit, $offset);
		}

		if ($keyword)
		{
			$this->db->like('categories.name', $keyword);
		}

		return $this->db->get('categories');
	}

	function get_job_categories($job_id)
	{
		$categories = $this->db->get_where('categories_jobs', array('job_id' => $job_id));

		$job_categories = array();

		if ($categories->num_rows() > 0)
		{
			$categories = $categories->result();
			foreach ($categories as $category)
			{
				$job_categories[] = $category->category_id;
			}
		}
		return $job_categories;
	}

	function save($category_id = FALSE)
	{
		$saved = FALSE;

		if ((int)$category_id)
		{
			$saved = $this->_update($category_id);
		}
		else
		{
			$saved = $this->_insert();
		}

		return $saved;
	}

	function delete($default_category, $category_ids = array())
	{
		if (is_array($category_ids))
		{
			foreach ($category_ids as $category_id)
			{
				if ($default_category != $category_id)
				{
					$this->db->delete('categories', array('id' => (int) $category_id));

					if ($this->db->affected_rows())
					{
						$this->_delete_pivot_data($category_id);
					}
				}
			}

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function get_default_category()
	{
		$this->db->where('setting', 'default_category');
		$result = $this->db->get('settings');

		if($result->num_rows() == 0)
		{
			return FALSE;
		}

		$default_category = (int) $result->row()->value;

		if ( ! $default_category)
		{
			return FALSE;
		}

		return $default_category;
	}

	function get_category($category_id)
	{
		$this->db->select('categories.id as categories_id, categories.name as categories_name');
		$results = $this->db->get_where('categories', array('id' => $category_id));

		if ($results->num_rows() == 0)
		{
			return FALSE;
		}
		else
		{
			return $results->row();
		}
	}

	function verify_category($id, $uri)
	{
		$this->db->where('id', $id);
		$result = $this->db->count_all_results('categories');

		if ($result == 0)
		{
			return 0;
		}

		$this->db->select('categories.id as categories_id, categories.name as categories_name');
		$query = $this->db->get_where('categories', array('categories.id' => $id, 'categories.uri' => $uri));

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
		$result = $this->db->get_where('categories', array('id' => $id));
		return $result->row()->uri;
	}

	function _insert()
	{
		$category_data = array(
			'name'          => $this->name,
			'uri'           => $this->uri,
			'date_add'      => $this->date_add,
			'date_upd'      => $this->date_upd
		);

		$this->db->insert('categories', $category_data);

		if ($this->db->affected_rows())
		{
			return TRUE;
		}

		return FALSE;
	}

	function _update($category_id)
	{
		$category_data = array(
			'name'          => $this->name,
			'uri'           => $this->uri,
			'date_upd'      => $this->date_upd
		);

		$this->db->where('id', $category_id);
		$this->db->update('categories', $category_data);

		if ($this->db->affected_rows())
		{
			return TRUE;
		}

		return FALSE;
	}

	function _delete_pivot_data($category_id)
	{
		$this->db->delete('categories_jobs', array('category_id' => (int) $category_id));
	}
}
?>
