<?php $this->load->view('admin/header');?>
	<div id="content">
		<div id="main">
		<h2><?php echo $title;?></h2>
		<?php echo form_open('admin/users/add');?>
		<?php echo validation_errors('<div class="error">', '</div>');?>
		<?php echo flash_message('message');?>
			<div id="mainbar">
				<fieldset id="write">
					<label for="username"><?php echo set_lang_line('label_username');?></label>
					<input type="text" id="username" name="username" value="<?php echo set_value('username');?>" />
					<label for="first_name"><?php echo set_lang_line('label_first_name');?></label>
					<input type="text" id="first_name" name="first_name" value="<?php echo set_value('first_name');?>" />
					<label for="last_name"><?php echo set_lang_line('label_last_name');?></label>
					<input type="text" id="last_name" name="last_name" value="<?php echo set_value('last_name');?>" />
					<label for="email"><?php echo set_lang_line('label_email');?></label>
					<input type="text" id="email" name="email" value="<?php echo set_value('email');?>" />
					<label for="password"><?php echo set_lang_line('label_password');?></label>
					<input type="password" id="password" name="password" value="<?php echo set_value('password');?>" />
					<label for="password_confirmation"><?php echo set_lang_line('label_password_confirmation');?></label>
					<input type="password" id="password_confirmation" name="password_confirmation" value="<?php echo set_value('password_confirmation');?>" />
				</fieldset>
			</div>
			<div id="sidebar">
				<h2>Options</h2>
				<div class="blue_sidebar">
					<label for="account" >Account</label>
					<select name="account" id="account">
						<?php
						$accounts = $accounts->result();
						foreach ($accounts as $account):
						?>
						<option value="<?php echo $account->accounts_id;?>" <?php echo set_select('account', $account->accounts_id);?>><?php echo $account->accounts_name;?></option>
						<?php
						endforeach;
						?>
					</select><br />
				</div>
			</div>
			<div style="clear: left"></div>
			<div id="submit">
				<input type="submit" name="submit" value="<?php echo set_lang_line('form_add_user');?>" class="submit"/>
			</div>
		<?php echo form_close(); ?>
		</div><!-- main -->

	</div>
<?php $this->load->view('admin/footer');?>