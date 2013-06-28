<?php $this->load->view('admin/header');?>
	<div id="content">
		<div id="main">
			<h2><?php echo $title;?></h2>
			<?php echo validation_errors('<div class="error">', '</div>');?>
			<?php echo flash_message('message');?>
			<?php echo form_open('admin/category/edit/'.$category_id);?>
				<fieldset id="write">
					<label for="category_name"><?php echo set_lang_line('label_category_name');?></label>
					<input type="text" id="category_name" name="category_name" value="<?php echo set_value('category_name', $category->categories_name);?>" />
				</fieldset>
				<div style="clear: left"></div>
				<div id="submit">
					<input type="submit" name="submit" value="<?php echo set_lang_line('form_edit_category');?>" class="submit"/>
				</div>
			</form>
		</div>
	</div>
<?php $this->load->view('admin/footer');?>