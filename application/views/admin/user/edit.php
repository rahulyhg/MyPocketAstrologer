<?php extend('common/base') ?>

<?php startblock('content') ?>

	<div style="text-align:center">
		<h3>Edit User Profile</h3>
	</div>
	
	<br/>

	<form class="form" role="form" method ="POST" action="<?php echo base_url('admin/users/edit/'.$user->id);?>">	
		<div class= "row">
			<div class="col-md-12">
				<div class="col-md-9 col-md-offset-2">
					<div class="form-group" style="width:80%;">
					    <label for="first_name">First Name</label>
					    <input type="text" name="first_name" value="<?php echo $user->first_name;?>" class="form-control" required>
					</div>

					<div class="form-group" style="width:80%;">
					    <label for="last_name">Last Name</label>
					    <input type="text" name="last_name" value="<?php echo $user->last_name;?>" class="form-control" required>
					</div>

					<div class="form-group" style="width:80%;">
					    <label for="email">Email</label>
					    <input type="email" name="email" value="<?php echo $user->email;?>" class="form-control" required>
					</div>

					<div class="form-group" style="width:80%;">
						<label for="Gender">Gender</label>
				        <select name="gender" id="gender" class="form-control" required>
				        	<option value="">Please Select One</option>
				        	<option value="0" <?php if($user->gender == 0) { ?> selected <?php } ?>>Male</option>
				        	<option value="1" <?php if($user->gender == 1) { ?> selected <?php } ?>>Female</option>
				        </select>
					</div>

					<div class="form-group" style="width:80%;">
					    <label for="place_of_birth">Birth Place</label>
					    <input type="text" name="place_of_birth" value="<?php echo $user->place_of_birth;?>" class="form-control" required>
					</div>

					<div class="form-group" style="width:80%;">
					    <label for="date_of_birth">Date of Birth</label>
					    <input type="date" name="date_of_birth" value="<?php echo date('Y-m-d', strtotime($user->date_of_birth));?>" class="form-control" required>
					</div>

					<div class="form-group" style="width:80%;">
					    <label for="time_of_birth">Time of Birth</label>
					    <input type="text" name="time_of_birth" value="<?php echo date('H:i:s', strtotime($user->date_of_birth));?>" class="form-control" placeholder="HH:mm:ss" required>
					</div>
				</div>
			</div>
	    </div>

	    <br/>
	    <div class="row">
			<div class="col-md-12">
				<div class="col-md-9 col-md-offset-2">
					<div class="form-group" style="width:80%;">
						<button id="submit" class="btn btn-lg btn-primary btn-block">Update</button>
					</div>
				</div>		
			</div>
		</div>
	</form>
</div><!-- /bootstrap --> 

<?php endblock() ?>

<?php end_extend() ?>