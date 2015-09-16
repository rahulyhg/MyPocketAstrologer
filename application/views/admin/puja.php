<?php extend('common/base') ?>

<?php startblock('content') ?>

<div class="container">

	<div class="row-fluid">
		<div class="span12">

			<div class="pull-left">
				<h2>Listing Pujas for <?php echo $user->get_full_name();?></h2>
			</div>

			<br/>
		</div>
	</div>

	<br/>

	<div class="row-fluid" style="margin-top:90px;">

		<div class="span12">
			<div class="row-fluid">
					<div class="span9">
						<?php if(count($pujas) > 0) { ?>

						<div class="table-container">
							<table class="table table-striped table-bordered" style="margin-bottom:85px;">

								<tr>
								    <th>Name</th>
								    <th>Details</th> 
								    <th>Status</th>  
								    <th>Images</th>
								    <th></th>
								</tr>

								<tbody>
									<?php foreach ($pujas as $puja){ ?>
										<tr>
											<td><?php echo $puja->name;?></td>
											<td><?php echo $puja->details;?></td>
											<td><?php echo $puja->status;?></td>
											<td><?php echo count($puja->images);?></td>															
											
											<td style="text-align:center;width:65px;">
											<div class="btn-group">
						  						<a class="btn dropdown-toggle" style="border:1px solid #eee;" data-toggle="dropdown" href="#">
						    						Actions <span class="caret"></span>
						  						</a>
												<ul class="dropdown-menu" style="text-align:left;">
													<?php if($puja->status == 2) { ?>
													<li><a href="<?php echo base_url('admin/pujas/start/'.$puja->id);?>">Confirm Start of Puja</a></li>
													<?php } ?>
													<?php if($puja->status == 3) { ?>
													<li><a href="<?php echo base_url('admin/pujas/complete/'.$puja->id);?>">Confirm Puja Completion</a></li>
													<?php } ?>
													<?php if($puja->status == 4) { ?>
													<li><a href="<?php echo base_url('admin/pujas/add_images/'.$puja->id);?>">Add/View Images</a></li>
													<?php } ?>
													<li><a href="<?php echo base_url('admin/pujas/delete/'.$puja->id);?>" onclick="return confirm_delete();">Delete</a></li>
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
								<p style="font-size:24px;">No Pujas found.</p>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
			<div class="col-md-12">
				<div class="col-md-4 col-md-offset-1">
					<div class="form-group" style="width:60%;">
						<button class="btn btn-lg btn-primary btn-block" style="margin-bottom:10px;" data-toggle="modal" data-target="#myModal">Suggest Puja</button>
					</div>
				</div>		
			</div>
		</div>

</div>


<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="myModalLabel">Suggest Puja</h4>
	      </div>

	      <form class="form" role="form" method ="POST" action="<?php echo base_url('admin/pujas/suggest/'.$user->id);?>">
	      <div class="modal-body">
	    		<div class="form-group" style="width:80%;">

	    		    <label for="Name">Name</label>
	    		    <input type="text" name="name" id="name" class="form-control" placeholder="Name of Puja" required>

	    		    <label for="Details">Details</label>
	    		    <textarea class="form-control" rows="5" name="details"  id="details" placeholder="Details of Puja"></textarea>

	    		</div>

	      </div>
	      <div class="modal-footer">
	   
	        <button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Suggest Puja</button>
	      </div>
	    </form>	
	</div>
</div>

<?php endblock() ?>

<?php end_extend() ?>

<script type="text/javascript">

	function confirm_delete() {
		return confirm('Are you sure you want to Delete the puja?');
	}

</script>