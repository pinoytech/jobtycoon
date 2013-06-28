<?php $this->load->view('admin/header');?>
	<div id="content">
		<div id="main">
			<h2><?php echo $title;?></h2>
			<?php echo form_open('admin/users/search', array('class' => 'search'));?>
				<input type="text" name="keyword" value="" class="search" />
				<input type="submit" name="search" value="Search" class="searchbutton" />
			<?php echo form_close();?>
			<?php echo flash_message('message');?>
			<?php
			if ($users->num_rows() > 0):
			$users = $users->result();
			?>
			<?php echo form_open('admin/users/delete');?>
				<input type="submit" name="delete" value="Delete" class="delete"/>
				<table id="manage">
					<tr>
						<th>&nbsp;</th>
						<th>Username</th>
						<th>Account Name</th>
						<th>Name</th>
						<th>Role</th>
					</tr>
					<?php foreach ($users as $user):?>
					<tr>
						<td class="checkbox"><input type="checkbox" name="users[]" value="<?php echo $user->users_id;?>"/></td>
						<td><?php echo anchor('admin/users/edit/'.$user->users_id, $user->users_username);?></td>
						<td><?php echo $user->accounts_name;?></td>
						<td><?php echo $user->users_first_name,' ', $user->users_last_name;?></td>
						<td><?php echo $user->users_role;?></td>
					</tr>
					<?php endforeach;?>
				</table>
				<?php echo pagination_links();?>
			<?php echo form_close(); ?>
			<?php
			endif;
			?>
		</div><!-- main -->
	</div><!-- content -->
<?php $this->load->view('admin/footer');?>