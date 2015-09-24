<?php extend('common/base') ?>

<?php startblock('content') ?>

	<div style="text-align:center">
		<h3>Add Quotation</h3>
	</div>
	
	<br/>

	<form class="form" role="form" method ="POST" action="<?php echo base_url('admin/shippings/add_quotation/'.$shipping->id);?>">	
		<div class= "row">
			<div class="col-md-12">
				<div class="col-md-9 col-md-offset-2">
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
	    </div>

	    <br/>
	    <div class="row">
			<div class="col-md-12">
				<div class="col-md-9 col-md-offset-2">
					<div class="form-group" style="width:80%;">
						<button id="submit" class="btn btn-lg btn-primary btn-block">Add Quotation</button>
					</div>
				</div>		
			</div>
		</div>
	</form>
</div><!-- /bootstrap --> 

<?php endblock() ?>

<?php end_extend() ?>