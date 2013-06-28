<?php $this->load->view('admin/header');?>
	<div id="content">
		<div id="main">
			<h2><?php echo $title;?></h2>
			<?php echo form_open('admin/jobs/search', array('class' => 'search'));?>
				<input type="text" name="keyword" value="" class="search" />
				<input type="submit" name="search" value="Search" class="searchbutton" />
			<?php echo form_close();?>
			<?php
			if ($jobs->num_rows() > 0):
			$jobs = $jobs->result();
			?>
			<?php echo form_open('admin/jobs/delete');?>
			<input type="submit" name="delete" value="Delete" class="delete"/>
				<table id="manage">
					<tr>
						<th>&nbsp;</th>
						<th>Job</th>
						<th>Account</th>
						<th>Last Update</th>
					</tr>
					<?php foreach ($jobs as $job):?>
					<tr>
						<td class="checkbox"><input type="checkbox" name="jobs[]" value="<?php echo  $job->jobs_id;?>" class="checkbox"/></td>
						<td><?php echo anchor('admin/jobs/edit/'.$job->jobs_id, $job->jobs_title);?></td>
						<td><?php echo $job->accounts_name;?></td>
						<td><abbr title="<?php echo $job->jobs_date_upd;?>"><?php echo $job->jobs_date_upd;?></abbr></td>
					</tr>
					<?php endforeach;?>
				</table>
				<?php echo pagination_links();?>
			<?php echo form_close();?>
			<?php
			endif;
			?>
		</div>
	</div>
<?php $this->load->view('admin/footer');?>