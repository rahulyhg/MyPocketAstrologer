<?php extend('common/base') ?>

<?php startblock('content') ?>

<div class="container" style="padding-bottom:20px;">

	<div class="row-fluid">
		<div class="span12">

			<div class="pull-left">
				<h2>Showing Puja Images</h2>
			</div>
	</div>
	<div class="clearfix"></div>
	
	<div class="row-fluid" style="margin-top:2px;padding-top:5px;">
		<div class="span12">
			<?php if(count($images) == 0) { ?>
			<div class="well" style="text-align:center; padding:100px 0;">
				<p style="font-size:24px;">No Users found.</p>
			</div>
			<?php } 
				else { 
					foreach ($images as $image) { ?>
						<img style = "margin-left:2%;" src="<?php echo base_url($image->image); ?>">
						<br/><br/>
					<?php } 
				} ?>

		</div>
	</div>

	<a href=""><input type="button" class="btn btn-primary" value="Add Puja Image"/></a>
</div>

<?php endblock() ?>

<?php end_extend() ?>