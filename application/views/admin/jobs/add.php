<?php $this->load->view('admin/header');?>
	<div id="content">
		<div id="main">
			<?php echo form_open('admin/jobs/add');?>
			<h2><?php echo $title;?></h2>
			<?php echo validation_errors('<div class="error">', '</div>');?>
			<?php echo flash_message('message');?>
				<div id="mainbar">
					<fieldset id="write">
						<label for="job_title"><?php echo set_lang_line('label_job_title');?></label>
						<input type="text" id="job_title" name="job_title" value="<?php echo set_value('job_title');?>" />
						<label for="description"><?php echo set_lang_line('label_description');?></label>
						<textarea name="description" id="description"><?php echo set_value('description');?></textarea>
					</fieldset>
				</div><!-- mainbar -->
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
						<label for="category" >Category</label>
							<?php
							$categories = $categories->result();
							foreach ($categories as $category):
							?>
							<input type="checkbox" name="categories[]" <?php echo set_checkbox('categories[]', $category->categories_id);?> value="<?php echo $category->categories_id;?>" />&nbsp;&nbsp;<label class="category"><?php echo $category->categories_name;?></label><br />
							<?php
							endforeach;
							?>
					</div><!-- .blue_sidebar -->
				</div><!-- sidebar -->
				<div style="clear: left"></div>
				<div id="submit">
					<input type="submit" name="submit" value="<?php echo set_lang_line('form_add_job');?>" class="submit"/>
				</div>
			</form>
		</div><!-- main -->
	</div><!-- content -->
<?php echo html_script('media/javascript/tiny_mce/tiny_mce.js');?>
<script type="text/javascript">
tinyMCE.init({
		// General options
		mode : "exact",
		elements : "description",
		theme : "advanced",
		skin : "o2k7",
		content_css : "<?php echo base_url()?>media/css/editor.css",
		plugins: "fullscreen",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,|, justifyleft,justifycenter,justifyright, |,blockquote,outdent,indent,|,link,unlink,image,|,fullscreen",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
});
</script>
<?php $this->load->view('admin/footer');?>