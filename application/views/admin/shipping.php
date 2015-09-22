<?php extend('common/base') ?>

<?php startblock('content') ?>

<div class="container">

	<div class="row-fluid">
		<div class="span12">

			<div class="pull-left">
				<h2>Listing Shipping Orders</h2>
			</div>

			<br/>
		</div>
	</div>

	<br/>

	<div class="row-fluid" style="margin-top:90px;">

		<div class="span12">
			<div class="row-fluid">
					<div class="span9">
						<?php if(count($shippings) > 0) { ?>

						<div class="table-container">
							<table class="table table-striped table-bordered" style="margin-bottom:85px;">

								<tr>
								    <th>User</th>
								    <th>Order details</th> 
								    <th>Address</th>							    
								    <th>Date</th> 
								    <th>Type</th>
								    <th></th>
								</tr>

								<tbody>
									<?php foreach ($shippings as $shipping){ ?>
										<tr>
											<td><?php echo $shipping->user->get_full_name();?></td>
											<td><?php echo $shipping->details;?></td>
											<td><?php echo $shipping->get_address();?></td>
											<td><?php echo date('M d, Y', strtotime($shipping->created_at));?></td>
											<td><?php if($shipping->type == 1) echo "Natal Chart";
													  if($shipping->type == 2) echo "Gemstone";?>
											</td>
											
											<td style="text-align:center;width:65px;">
											<div class="btn-group">
						  						<a class="btn dropdown-toggle" style="border:1px solid #eee;" data-toggle="dropdown" href="#">
						    						Actions <span class="caret"></span>
						  						</a>
												<ul class="dropdown-menu" style="text-align:left;">
													<?php if(!$shipping->quotation) { ?> 
													<li><a data-toggle="modal" data-target="#myModal">Add Quotation</a></li>
													<?php } else { ?>
													<li><a href="<?php echo base_url('admin/shippings/view_quotation/'.$shipping->id);?>">View Quotation</a></li>
													<?php } ?>
													<li><a href="<?php echo base_url('admin/shippings/delete/'.$shipping->id);?>" onclick="return confirm_delete();">Delete</a></li>
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
								<p style="font-size:24px;">No Shipping Orders found.</p>
							</div>
						<?php } ?>
					</div>
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
	        <h4 class="modal-title" id="myModalLabel">Add Quotation</h4>
	      </div>

	      <form class="form" role="form" method ="POST" action="<?php echo base_url('admin/shippings/add_quotation/'.$shipping->id);?>">
	      <div class="modal-body">
	    		<div class="form-group" style="width:80%;">

	    		    <label for="TotalCost">Total Cost</label>
	    		    <input type="text" name="total_cost" id="total_cost" class="form-control" placeholder="Total Cost" required>

	    		    <label for="Date">Date</label>
	    		    <input class="form-control" type="date" name="date"  id="date" placeholder="Date" required>

	    		    <label for="ObjectCost">Object Cost</label>
	    		    <input type="text" name="object_cost" id="object_cost" class="form-control" placeholder="Object Cost" required>

	    		    <label for="ShippingCost">Shipping Cost</label>
	    		    <input type="text" name="shipping_cost" id="total_cost" class="form-control" placeholder="Shipping Cost" required>

	    		    <label for="CompanyName">Name of Shipping Company</label>
	    		    <input type="text" name="company_name" class="form-control" placeholder="Shipping Company" required>

	    		    <label for="QuotationNumber">Quotation Number</label>
	    		    <input type="text" name="quotation_number" class="form-control" placeholder="Quotation Number" required>

	    		    <label for="Days">Number of Days required for shipping</label>
	    		    <input type="text" name="days" id="days" class="form-control" placeholder="Number of Days" required>

	    		</div>

	      </div>
	      <div class="modal-footer">
	   
	        <button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Add Quotation</button>
	      </div>
	    </form>	
	</div>
</div>


<?php endblock() ?>

<?php end_extend() ?>

<script type="text/javascript">

	function confirm_delete() {
		return confirm('Are you sure you want to Delete the order?');
	}

</script>