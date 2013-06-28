<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title><?php echo $title;?></title>

<!-- Meta Tags -->
<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="author" content="" />

<!-- CSS -->
<?php echo html_stylesheet('media/css/styles.css', 'screen');?>

</head>
<body>
<div id="container">
	<div id="header">
		<h1><a href="<?php echo base_url();?>" title="<?php echo $this->config->item('app_name');?>"><?php echo $this->config->item('app_name');?></a></h1>
	</div>
	<div id="headerbar">&nbsp;</div>
	<div id="navigation">
		<ul>
			<li><?php echo anchor('admin/front/dashboard', 'Dashboard');?></li>
			<li><?php echo anchor('admin/front/logout', 'Log Out');?></li>
		</ul>
		<?php if ($this->auth->logged_in('admin')):?>
		<h3>Accounts</h3>
		<ul>
			<li><?php echo anchor('admin/accounts/add', 'Create New');?></li>
			<li><?php echo anchor('admin/accounts/manage', 'Browse Accounts');?></li>
		</ul>
		<?php endif;?>
		<h3>Jobs</h3>
		<ul>
			<li><?php echo anchor('admin/jobs/add', 'Create New');?></li>
			<li><?php echo anchor('admin/jobs/manage', 'Browse Jobs');?></li>
		</ul>
		<?php if ($this->auth->logged_in('admin')):?>
		<h3>Categories</h3>
		<ul>
			<li><?php echo anchor('admin/category/add', 'New Category');?></li>
			<li><?php echo anchor('admin/category/manage', 'Browse Categories');?></li>
		</ul>
		<h3>Users</h3>
		<ul>
			<li><?php echo anchor('admin/users/add', 'New Users');?></li>
			<li><?php echo anchor('admin/users/manage', 'Browse Users');?></li>
		</ul>
		<?php endif;?>
	</div>