<?php extend('common/base') ?>

<?php startblock('content') ?>

<div class="container">

	<div class="row-fluid">
		<div class="span12">

			<div class="pull-left">
				<h2>Showing Gemstones for <?php echo $user->get_full_name();?></h2>
			</div>

			<br/>
		</div>
	</div>

	<br/>

	<div class="row-fluid" style="margin-top:90px;">

		<div class="span12">
			<div class="row-fluid">
					<div class="span9">
						<?php if(count($user_gemstones) > 0) { ?>

						<div class="table-responsive">
							<table class="table table-striped table-bordered" style="margin-bottom:85px;">

								<tr>
								    <th>Gemstone Name</th>
								    <th>Color</th> 
								    <th>Details</th>
								    <th>Status</th>
								    <th></th>
								</tr>

								<tbody>
									<?php foreach ($user_gemstones as $user_gemstone) { 
											switch ($user_gemstone->status) {
												case '1':
													$status = "Suggested";
													break;
												
												case '2':
													$status = "Ordered for shipping";
													break;

												case '3':
													$status = "Processed for shipping";
													break;
											}
										?>
										<tr>
											<td><?php if($user_gemstone->from_zodiac) { ?>
												<span class="label label-success">Z</span>
											<?php } echo $user_gemstone->gemstone->name;?></td>
											<td><?php echo $user_gemstone->color;?></td>
											<td><?php echo $user_gemstone->details;?></td>
											<td><?php echo $status;?></td>
											
											<td style="text-align:center;width:65px;">
											<div class="btn-group">
						  						<a class="btn dropdown-toggle" style="border:1px solid #eee;" data-toggle="dropdown" href="#">
						    						Actions <span class="caret"></span>
						  						</a>
												<ul class="dropdown-menu" style="text-align:left;">
													<?php //if($user_gemstone->status == 2) { ?>
													<!-- <li><a href="<?php echo base_url('admin/gemstones/process_shipping/'.$user_gemstone->id);?>">Confirm Processing of Gemstone</a></li> -->
													<?php //} ?>
													<li><a href="<?php echo base_url('admin/gemstones/delete/'.$user_gemstone->id);?>" onclick="return confirm_delete();">Delete</a></li>
												</ul>
											</div>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>

						<div class="pull-right">
							<div>
								<strong><small>Legend</small></strong> &nbsp;
								<span class="label label-success">Z - Gemstone assigned from Zodiac sign</span>
							</div>
						</div>

						<?php } else { ?>
							<div class="well" style="text-align:center; padding:100px 0;">
								<p style="font-size:24px;">No Gemstones found.</p>
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
						<button class="btn btn-lg btn-primary btn-block" style="margin-bottom:10px;" data-toggle="modal" data-target="#myModal">Add New Gemstone</button>
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
	        <h4 class="modal-title" id="myModalLabel">Add Gemstone</h4>
	      </div>

	      <form class="form" role="form" method ="POST" action="<?php echo base_url('admin/gemstones/add/'.$user->id);?>">
	      <div class="modal-body">
	    		<div class="form-group" style="width:80%;">

	    		    <div class="form-group" style="width:80%;">
						<label for="Gemstone">Gemstone</label>
				        <select name="gemstone" class="form-control">
				        	<option value="">Please Select One</option>
				        	<?php foreach ($gemstones as $gemstone) { ?>
				        		<option value="<?php echo $gemstone->id;?>"><?php echo $gemstone->name;?></option>
				        	<?php } ?>
				        </select>
					</div>

					<div class="form-group" style="width:80%;">
						<label for="Color">Color</label>
				        <select name="color" class="form-control">
				        	<option value="">Please Select One</option>
				        	<?php foreach ($colors as $color) { ?>
				        		<option value="<?php echo $color->id;?>"><?php echo $color->color;?></option>
				        	<?php } ?>
				        </select>
					</div>

	    		    <label for="Details">Details</label>
	    		    <textarea class="form-control" rows="5" name="details"  id="details" placeholder="Details"></textarea>

	    		</div>

	      </div>
	      <div class="modal-footer">
	   
	        <button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Save</button>
	      </div>
	    </form>	
	</div>
</div>

<?php endblock() ?>

<?php end_extend() ?>

<script type="text/javascript">

	function confirm_delete() {
		return confirm('Are you sure you want to Delete the gemstone?');
	}

</script>