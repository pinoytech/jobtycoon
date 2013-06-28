<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title><?php echo $title; ?></title>

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
	<div id="content">
		<h2><?php echo $title;?></h2>
		<?php echo validation_errors('<div class="error">', '</div>');?>
		<div id="main">
		<?php echo form_open('admin/front/login');?>
			<fieldset id="login">
			<label for="username">Username:</label>
			<input type="text" name="username" id="username" value="<?php echo set_value('username');?>"/>
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" />
			<input type="submit" value="Login" id="submit" class="submit"/>
		</fieldset>
		<?php echo form_close();?>
		</div>
	</div>
<?php $this->load->view('admin/footer');?>