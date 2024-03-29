<?php extend('common/base') ?>

<?php startblock('content') ?>

<div class="container" style="padding-bottom:20px;">
	
	<div class="row-fluid">
		<div class="span12">	
			<div class="col-xs-6 col-xs-push-0">
				<?php if($user->profile_pic != '') { ?>
				<img style="height:100%;width:100%;" src="<?php echo base_url($user->profile_pic);?>">
				<?php } else { ?>
				<img src="<?php echo base_url('public/user_images/profile.png'); ?>">
				<?php } ?>
				<h3><?php echo $user->get_full_name();?></h3>
			</div>			
		</div>
	</div>
	<div class="clearfix"></div>
	
	<div class="row-fluid" style="margin-top:2px;padding-top:5px;">
		<div class="span12">

			<div class="well" style="margin-left=2px;">
				<p style="font-size:14px;">Name: <?php echo $user->get_full_name();?></p>
				<p style="font-size:14px;">Email: <?php echo $user->email;?></p>
				<p style="font-size:14px;">Gender: <?php if($user->gender == 0)
															echo "Male";
														 else
															echo "Female";?></p>
				<p style="font-size:14px;">Birth Place: <?php echo $user->place_of_birth;?></p>
				<p style="font-size:14px;">Date of Birth: <?php echo date('M d, Y', strtotime($user->date_of_birth));?></p>
				<p style="font-size:14px;">Time of Birth: <?php echo date('H:i:s', strtotime($user->date_of_birth));?></p>
				<p style="font-size:14px;">Zodiac: <?php if($user->zodiac) echo $user->zodiac->zodiac; else { echo "Not assigned";?>&nbsp&nbsp&nbsp&nbsp<a href="<?php echo base_url('admin/users/assign_zodiac/'.$user->id);?>">Assign Zodiac Sign</a><?php } ?></p>
			</div>
		</div>
	</div>

	<a href="<?php echo base_url('admin/users/edit/'.$user->id)?>"><input type="button" class="btn btn-primary" value="Edit Profile"/></a>
</div>

<?php endblock() ?>

<?php end_extend() ?>