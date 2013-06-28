<?php $this->load->view('admin/header');?>
	<div id="content">
		<?php echo form_open('admin/category/add');?>
		<div id="main">
			<h2><?php echo $title;?></h2>
			<?php echo validation_errors('<div class="error">', '</div>');?>
			<?php echo flash_message('message');?>
			<fieldset id="write">
				<label for="category_name"><?php echo set_lang_line('label_category_name');?></label>
				<input type="text" id="category_name" name="category_name" value="<?php echo set_value('category_name');?>" />
			</fieldset>
			<div style="clear: left"></div>
			<div id="submit">
				<input type="submit" name="submit" value="<?php echo set_lang_line('form_add_category');?>" class="submit"/>
			</div>
		</div><!-- main -->
		</form>
	</div><!-- content -->
<?php $this->load->view('admin/footer');?>