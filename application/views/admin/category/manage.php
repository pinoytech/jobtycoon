<?php $this->load->view('admin/header');?>
	<div id="content">
		<div id="main">
			<h2><?php echo $title;?></h2>
			<?php echo form_open('admin/category/search', array('class' => 'search'));?>
				<input type="text" name="keyword" value="" class="search" />
				<input type="submit" name="search" value="Search" class="searchbutton" />
			<?php echo form_close();?>
			<?php echo flash_message('message');?>
			<?php
			if ($categories->num_rows() > 0):
			$categories = $categories->result();
			?>
			<?php echo form_open('admin/category/delete');?>
			<input type="submit" name="delete" value="Delete" class="delete"/>
				<table id="manage">
					<tr>
						<th>&nbsp;</th>
						<th>Category</th>
					</tr>
					<?php foreach ($categories as $category):?>
					<tr>
						<td class="checkbox"><input type="checkbox" name="categories[]" value="<?php echo  $category->categories_id;?>" class="checkbox"/></td>
						<td><?php echo anchor('admin/category/edit/'.$category->categories_id, $category->categories_name);?></td>
					</tr>
					<?php endforeach;?>
				</table>
				<?php echo pagination_links();?>
			</form>
			<?php
			endif;
			?>
		</div>
	</div>
<?php $this->load->view('admin/footer');?>