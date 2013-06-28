<div id="sidebar">
	<?php echo form_open('job/search'); ?>
		<div class="blue_sidebar">
			<h2><?php echo set_lang_line('header_search');?></h2>
			<input type="text" name="keyword" id="keyword"/><br />
			<input type="submit" name="search" id="search" value="Search" />
		</div><!-- .blue_sidebar -->
	<?php echo form_close();?>
	<div class="blue_sidebar">
		<h2><?php echo set_lang_line('header_categories');?></h2>
		<?php get_categories();?>
	</div><!-- .blue_sidebar -->
</div><!-- sidebar -->