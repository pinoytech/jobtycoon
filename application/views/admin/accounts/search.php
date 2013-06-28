<?php $this->load->view('admin/header');?>
	<div id="content">
		<div id="main">
			<h2><?php echo $title;?></h2>
			<?php echo form_open('admin/accounts/search', array('class' => 'search'));?>
				<input type="text" name="keyword" value="" class="search" />
				<input type="submit" name="search" value="Search" class="searchbutton" />
			<?php echo form_close(); ?>
			<?php
			if ($accounts->num_rows() > 0):
			$accounts = $accounts->result();
			?>
			<?php echo form_open('admin/accounts/delete');?>
			<input type="submit" name="delete" value="Delete" class="delete"/>
				<table id="manage">
					<tr>
						<th>&nbsp;</th>
						<th>Account</th>
						<th>Last Update</th>
					</tr>
					<?php foreach ($accounts as $account):?>
					<tr>
						<td class="checkbox"><input type="checkbox" name="accounts[]" value="<?php echo  $account->accounts_id;?>" class="checkbox"/></td>
						<td><?php echo anchor('admin/accounts/edit/'.$account->accounts_id, $account->accounts_name);?></td>
						<td><abbr title="<?php echo $account->accounts_upd;?>"><?php echo $account->accounts_upd;?></abbr></td>
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