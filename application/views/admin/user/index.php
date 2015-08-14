<?php extend('common/base') ?>

<?php startblock('content') ?>

<div class="container">

	<div class="row-fluid">
		<div class="span12">

			<div class="pull-left">
				<h2>Listing Users</h2>
			</div>
	</div>

	<br/>

	<div class="row-fluid" style="margin-top:90px;">

		<div class="span12">
			<div class="row-fluid">

					<div class="span9">
						<?php if(count($users) > 0){ ?>

						<div class="table-container">
							<table class="table table-striped table-bordered" style="margin-bottom:85px;">

								<tr>
								    <th>Name</th>
								    <th>Date of Birth</th> 
								    <th>Gender</th>
								    <th>Birth Place</th>
								    <th>Email</th> 
								    <th>Queries</th>
								    <th></th>
								</tr>

								<?php foreach ($users as $user){ ?>
								<tr>
									<td><?php echo $user->get_full_name();?></td>
									<td><?php echo date('M d, Y', strtotime($user->date_of_birth));?></td>
									<td>
										<?php
										if($user->gender == 0)
											echo "Male";
										else
											echo "Female";
										?>
									</td>
									<td><?php echo $user->place_of_birth;?></td>
									<td><?php echo $user->email;?></td>
									<td><a href="<?php echo base_url('admin/users/queries/'.$user->id) ?>"><?php echo $user->queries_count;?></a></td>
									
									<td style="text-align:center;width:65px;">
									<div class="btn-group">
				  						<a class="btn dropdown-toggle" style="border:1px solid #eee;" data-toggle="dropdown" href="#">
				    						Actions <span class="caret"></span>
				  						</a>
										<ul class="dropdown-menu" style="text-align:left;">	
											<li><a href="<?php echo base_url('admin/users/view/'.$user->id);?>">View Profile</a></li>
											<li><a href="<?php echo base_url('admin/users/edit/'.$user->id);?>">Edit Profile</a></li>
											<?php if(!$user->zodiac) { ?>
											<li><a href="<?php echo base_url('admin/users/assign_zodiac/'.$user->id);?>">Assign Zodiac Sign</a></li>
											<?php } ?>
											<li><a href="<?php echo base_url('admin/users/queries/'.$user->id);?>">View Queries</a></li>
											<li><a href="<?php echo base_url('admin/gemstones/index/'.$user->id);?>">View Gemstone</a></li>
											<li><a href="<?php echo base_url('admin/natal_charts/index/'.$user->id);?>">View Natal Chart</a></li>
											<li><a href="<?php echo base_url('admin/pujas/index/'.$user->id);?>">View Puja</a></li>
											<?php if($user->active) { ?>
											<li><a href="<?php echo base_url('admin/users/deactivate/'.$user->id);?>" onclick="return confirm_deactivate();">Deactivate</a></li>
											<?php } else { ?>
											<li><a href="<?php echo base_url('admin/users/activate/'.$user->id);?>" onclick="return confirm_activate();">Activate</a></li>
											<?php } ?>
											<li><a href="<?php echo base_url('admin/users/delete/'.$user->id);?>" onclick="return confirm_delete();">Delete</a></li>
										</ul>
									</div>
									</td>
								</tr>
								<?php } ?>
							</table>
						</div>
						<?php } else { ?>
							<div class="well" style="text-align:center; padding:100px 0;">
								<p style="font-size:24px;">No Users found.</p>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<?php endblock() ?>

<?php end_extend() ?>

<script type="text/javascript">

	function confirm_delete() {
		return confirm('Are you sure you want to Delete the user?');
	}

	function confirm_activate() {
		return confirm('Are you sure you want to Activate the user?');
	}

	function confirm_deactivate() {
		return confirm('Are you sure you want to Deactivate the user?');
	}

</script>