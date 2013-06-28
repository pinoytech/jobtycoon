<?php echo form_open_multipart('job/view/'.$job_id.'/'.$uri);?>
<h3><?php echo set_lang_line('header_apply_now');?></h3>
<?php echo flash_message('message');?>
<fieldset id="write">
	<?php echo validation_errors();?>
	<label for="first_name"><?php echo set_lang_line('label_first_name');?></label>
	<input type="text" id="first_name" name="first_name" class="small" value="<?php echo set_value('first_name');?>" />
	<label for="last_name"><?php echo set_lang_line('label_last_name');?></label>
	<input type="text" id="last_name" name="last_name" class="small" value="<?php echo set_value('last_name');?>" />
	<label for="email"><?php echo set_lang_line('label_email');?></label>
	<input type="text" id="email" name="email" class="small" value="<?php echo set_value('email');?>" />
	<label for="email"><?php echo set_lang_line('label_cv');?></label>
	<input type="file" id="userfile" name="userfile" />
	<input type="submit" id="submit" name="submit" class="small" value="Send" />
</fieldset>
<?php echo form_close();?>
