<?php extend('common/base') ?>

<?php startblock('content') ?>

	<div style="text-align:center">
		<h3>Assign a Zodiac sign to <?php echo $user->get_full_name();?></h3>
	</div>
	
	<br/>

	<form class="form" role="form" method ="POST" action="<?php echo base_url('admin/users/assign_zodiac/'.$user->id);?>">	
		<div class= "row">
			<div class="col-md-12">
				<div class="col-md-9 col-md-offset-2">
					<div class="form-group" style="width:80%;">
					    
					<div class="form-group" style="width:90%;">
						<label for="Zodiac">Zodiac Sign</label>
				        <select name="zodiac_id" id="zodiac_id" class="form-control" required>
				        	<option value="">Please Select One</option>
				        	<?php foreach ($zodiac_signs as $zodiac) { ?>
				        	<option value="<?php echo $zodiac->id?>"><?php echo $zodiac->zodiac?></option>
				        	<?php } ?>
				        </select>
					</div>
	    <br/>
	    <div class="row">
			<div class="col-md-12">
				<div class="col-md-9 col-md-offset-2">
					<div class="form-group" style="width:80%;">
						<button id="submit" class="btn btn-lg btn-primary btn-block">Save</button>
					</div>
				</div>		
			</div>
		</div>
	</form>
</div><!-- /bootstrap --> 

<?php endblock() ?>

<?php end_extend() ?>