<?php get_header();?>
	<div id="content">
		<div id="main">
			<div id="mainbar">
				<h2><?php echo $job->jobs_title;?></h2>
				<?php echo $job->jobs_description;?>
				<?php get_job_form();?>
			</div><!-- mainbar -->
			<?php get_sidebar(); ?>
		</div><!-- main -->
	</div><!-- content -->
<?php get_footer();?>