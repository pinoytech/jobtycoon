<?php $this->load->view('admin/header');?>
	<div id="content">
		<div id="main">
			<h2><?php echo $title;?></h2>
			<?php echo form_open('admin/accounts/edit/'.$this->uri->segment(4));?>
				<?php echo validation_errors('<div class="error">', '</div>');?>
				<?php echo flash_message('message');?>
				<fieldset id="add_account">
					<label for="account_name"><?php echo set_lang_line('label_account_name');?></label>
					<input type="text" id="account_name" name="account_name" value="<?php echo set_value('account_name', $account->accounts_name);?>" />
					<label for="email"><?php echo set_lang_line('label_email');?></label>
					<input type="text" id="email" name="email" value="<?php echo set_value('email', $account->accounts_email);?>" />
				</fieldset>
				<div style="clear: left"></div>
				<div id="submit">
					<input type="submit" name="edit_product" value="<?php echo set_lang_line('form_edit_account');?>" class="submit"/>
				</div>
			</form>
		</div>
	</div>
<?php $this->load->view('admin/footer');?>