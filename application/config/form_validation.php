<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
	'login' => array(
		array(
			'field' => 'username',
			'label' => 'lang:username',
			'rules' => 'required'
		),
		array(
			'field' => 'password',
			'label' => 'lang:password',
			'rules' => 'required|callback__user_check'
		)
	),
	'add_account' => array(
		array(
			'field' => 'account_name',
			'label' => 'lang:account_name',
			'rules' => 'required'
		)
	),
	'edit_account' => array(
		array(
			'field' => 'account_name',
			'label' => 'lang:account_name',
			'rules' => 'required'
		)
	),
	'add_job' => array(
		array(
			'field' => 'job_title',
			'label' => 'lang:job_title',
			'rules' => 'required'
		),
		array(
			'field' => 'description',
			'label' => 'lang:description',
			'rules' => 'required'
		),
		array(
			'field' => 'account',
			'label' => 'lang:account',
			'rules' => 'required'
		),
		array(
			'field' => 'categories[]',
			'label' => 'lang:category',
			'rules' => 'required'
		)
	),
	'edit_job' => array(
		array(
			'field' => 'job_title',
			'label' => 'lang:job_title',
			'rules' => 'required'
		),
		array(
			'field' => 'description',
			'label' => 'lang:description',
			'rules' => 'required'
		),
		array(
			'field' => 'categories[]',
			'label' => 'lang:category',
			'rules' => 'required'
		)
	),
	'add_user' => array(
		array(
			'field' => 'username',
			'label' => 'lang:username',
			'rules' => 'required'
		),
		array(
			'field' => 'first_name',
			'label' => 'lang:first_name',
			'rules' => 'required'
		),
		array(
			'field' => 'last_name',
			'label' => 'lang:last_name',
			'rules' => 'required'
		),
		array(
			'field' => 'email',
			'label' => 'lang:email',
			'rules' => 'required|valid_email'
		),
		array(
			'field' => 'account',
			'label' => 'lang:account',
			'rules' => 'required'
		),
		array(
			'field' => 'password',
			'label' => 'lang:password',
			'rules' => 'required'
		),
		array(
			'field' => 'password_confirmation',
			'label' => 'lang:password_confirmation',
			'rules' => 'required'
		)
	),	
	'edit_user' => array(
		array(
			'field' => 'first_name',
			'label' => 'lang:first_name',
			'rules' => 'required'
		),
		array(
			'field' => 'last_name',
			'label' => 'lang:last_name',
			'rules' => 'required'
		),
		array(
			'field' => 'email',
			'label' => 'lang:email',
			'rules' => 'required|valid_email'
		)
	),	
	'edit_user_wpassword' => array(
		array(
			'field' => 'first_name',
			'label' => 'lang:first_name',
			'rules' => 'required'
		),
		array(
			'field' => 'last_name',
			'label' => 'lang:last_name',
			'rules' => 'required'
		),
		array(
			'field' => 'email',
			'label' => 'lang:email',
			'rules' => 'required|valid_email'
		),
		array(
			'field' => 'password',
			'label' => 'lang:password',
			'rules' => 'required|matches[password_confirmation]'
		),
		array(
			'field' => 'password_confirmation',
			'label' => 'lang:password_confirmation',
			'rules' => 'required'
		)
	),	
	'add_category' => array(
		array(
			'field' => 'category_name',
			'label' => 'lang:category_name',
			'rules' => 'required'
		)
	),	
	'edit_category' => array(
		array(
			'field' => 'category_name',
			'label' => 'lang:category_name',
			'rules' => 'required'
		)
	),	
	'submit_cv' => array(
		array(
			'field' => 'first_name',
			'label' => 'lang:first_name',
			'rules' => 'required'
		),
		array(
			'field' => 'last_name',
			'label' => 'lang:last_name',
			'rules' => 'required'
		),
		array(
			'field' => 'email',
			'label' => 'lang:email',
			'rules' => 'required|valid_email'
		),
		array(
			'field' => 'userfile',
			'label' => 'lang:userfile',
			'rules' => 'callback__do_upload'
		)
	)
);
