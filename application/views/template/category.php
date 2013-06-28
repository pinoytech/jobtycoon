<?php get_header();?>
	<div id="content">
		<div id="main">
			<div id="mainbar">
				<h2><?php echo $title;?></h2>
				<?php
				if ($jobs->num_rows() > 0):
				$jobs = $jobs->result();
				?>
				<table id="manage">
					<tr>
						<th>Jobs</th>
						<th>Last Update</th>
					</tr>
					<?php foreach ($jobs as $job):?>
					<tr>
						<td><?php echo anchor('job/view/'.$job->jobs_id.'/'.$job->jobs_uri, $job->jobs_title);?> at <?php echo $job->accounts_name;?></td>
						<td class="date_add"><abbr title="<?php echo $job->jobs_date_add;?>"><?php echo $job->jobs_date_add;?></abbr></td>
					</tr>
					<?php endforeach;?>
				</table>
				<?php echo pagination_links();?>
				<?php
				endif;
				?>
			</div><!-- mainbar -->
			<?php get_sidebar();?>
		</div><!-- main -->
	</div><!-- content -->
<?php get_footer();?>