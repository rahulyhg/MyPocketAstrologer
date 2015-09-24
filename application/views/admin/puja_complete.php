<?php extend('common/base') ?>

<?php startblock('content') ?>

	<div style="text-align:center">
		<h3>Confirm Puja Completion</h3>
	</div>
	
	<br/>

	<form class="form" role="form" method ="POST" action="<?php echo base_url('admin/pujas/complete/'.$puja->id);?>" enctype="multipart/form-data">	
		<div class= "row">
			<div class="col-md-12">
				<div class="col-md-9 col-md-offset-2">
					<label for="Image1">Puja Image 1</label>
	    		    <input type="file" name="puja_image_1">
	    		    <br/>
	    		    <label for="Details1">Details of Image 1</label>
	    		    <input type="text" name="details_1" class="form-control" placeholder="Details">
	    		    <br/>
	    		    <label for="Image2">Puja Image 2</label>
	    		    <input type="file" name="puja_image_2">
	    		    <br/>
	    		    <label for="Details2">Details of Image 2</label>
	    		    <input type="text" name="details_2" class="form-control" placeholder="Details">
	    		    <br/>
	    		    <label for="Image3">Puja Image 3</label>
	    		    <input type="file" name="puja_image_3">
	    		    <br/>
	    		    <label for="Details3">Details of Image 3</label>
	    		    <input type="text" name="details_3" class="form-control" placeholder="Details">

				</div>
			</div>
	    </div>

	    <br/>
	    <div class="row">
			<div class="col-md-12">
				<div class="col-md-9 col-md-offset-2">
					<div class="form-group" style="width:80%;">
						<button id="submit" class="btn btn-lg btn-primary btn-block">Complete Puja</button>
					</div>
				</div>		
			</div>
		</div>
	</form>
</div><!-- /bootstrap --> 

<?php endblock() ?>

<?php end_extend() ?>