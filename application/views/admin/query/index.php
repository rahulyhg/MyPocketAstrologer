<?php extend('common/base') ?>

<?php startblock('content') ?>

<div class="container">

	<div class="row-fluid">
		<div class="span12">

			<div class="pull-left">
				<h2>Listing Queries</h2>
			</div>

			<br/>
		</div>
	</div>

	<br/>

	<div class="row-fluid" style="margin-top:90px;">

		<div class="span12">
			<div class="row-fluid">
					<div class="span9">
						<?php if(count($queries) > 0) { ?>

						<div class="table-responsive">
							<table class="table table-striped table-bordered" style="margin-bottom:85px;">

								<tr>
								    <th>Name</th>
								    <th>Email</th> 
								    <th>Query</th>							    
								    <th>Answer</th> 
								    <th>Asked On</th>
								    <th></th>
								</tr>

								<tbody>
									<?php foreach ($queries as $query){ ?>
										<tr>
											<td><?php echo $query->user->get_full_name();?></td>
											<td><?php echo $query->user->email;?></td>
											<td><?php echo $query->query;?></td>
											<td><?php echo $query->answer;?></td>
											<td><?php echo date('M d, Y', strtotime($query->asked_on));?></td>																						
											
											<td style="text-align:center;width:65px;">
											<div class="btn-group">
						  						<a class="btn dropdown-toggle" style="border:1px solid #eee;" data-toggle="dropdown" href="#">
						    						Actions <span class="caret"></span>
						  						</a>
												<ul class="dropdown-menu" style="text-align:left;">
													<?php if($query->answer == '') { ?> 
													<li><a href="<?php echo base_url('admin/queries/answer/'.$query->id);?>">Answer query</a></li>
													<?php } ?>
													<li><a href="<?php echo base_url('admin/queries/view/'.$query->id);?>">View</a></li>
													<li><a href="<?php echo base_url('admin/queries/delete/'.$query->id);?>" onclick="return confirm_delete();">Delete</a></li>
												</ul>
											</div>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<?php } else { ?>
							<div class="well" style="text-align:center; padding:100px 0;">
								<p style="font-size:24px;">No Queries found.</p>
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
		return confirm('Are you sure you want to Delete the query?');
	}

</script>