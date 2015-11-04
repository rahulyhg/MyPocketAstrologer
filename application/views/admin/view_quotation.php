<?php extend('common/base') ?>

<?php startblock('content') ?>

	<div style="text-align:center">
		<h3>View Quotation</h3>
	</div>
	
	<br/>

	<form class="form" role="form">	
		<div class= "row">
			<div class="col-md-12">
				<div class="col-md-9 col-md-offset-2">
					<label for="TotalCost">Total Cost</label>
	    		    <input type="text" name="total_cost" id="total_cost" class="form-control" value="<?php echo $quotation->total_cost?>" readonly>

	    		    <label for="Date">Date</label>
	    		    <input class="form-control" type="date" name="date"  id="date" value="date" readonly>

	    		    <label for="ObjectCost">Object Cost</label>
	    		    <input type="text" name="object_cost" id="object_cost" class="form-control" value="<?php echo $quotation->object_cost; ?>" readonly>

	    		    <label for="ShippingCost">Shipping Cost</label>
	    		    <input type="text" name="shipping_cost" id="total_cost" class="form-control" value="<?php echo $quotation->shipping_cost; ?>" readonly>

	    		    <label for="CompanyName">Name of Shipping Company</label>
	    		    <input type="text" name="company_name" class="form-control" value="<?php echo $quotation->company_name; ?>" readonly>

	    		    <label for="QuotationNumber">Quotation Number</label>
	    		    <input type="text" name="quotation_number" class="form-control" value="<?php echo $quotation->quotation_number; ?>" readonly>

	    		    <label for="Days">Number of Days required for shipping</label>
	    		    <input type="text" name="days" id="days" class="form-control" value="<?php echo $quotation->days; ?>" readonly>
				</div>
			</div>
	    </div>

	    <br/>
	    <div class="row">
			<div class="col-md-12">
				<div class="col-md-9 col-md-offset-2">
					<div class="form-group" style="width:80%;">
						<?php if($quotation->approved == 1) { ?>
						<a href="<?php echo base_url('admin/shippings');?>" class="btn btn-lg btn-primary btn-block">Back</a>
						<?php } else { ?>
						<a href="<?php echo base_url('admin/shippings/send_quotation/'.$quotation->id);?>" class="btn btn-lg btn-primary btn-block">Send Quotation</a>
						<?php } ?>
					</div>
				</div>		
			</div>
		</div>
	</form>
</div><!-- /bootstrap --> 

<?php endblock() ?>

<?php end_extend() ?>