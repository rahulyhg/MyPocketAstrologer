<?php extend('common/base') ?>

<?php startblock('content') ?>

<div class="container">

	<div class="row-fluid">
		<div class="span12">

			<div class="pull-left">
				<h2>Showing Natal Chart for <?php echo $user->get_full_name();?></h2>
			</div>
	</div>

	<div class="row-fluid" style="margin-top:90px;padding-top:100px">

		<div class="span12">
			<div class="row-fluid">
 
			<?php if($natal_chart && $natal_chart->natal_chart && $natal_chart->status == 2) { ?>
		 	<div class="row">
		        <div class="col-md-10 col-md-push-1">
		          <img class="img-responsive center-block" src="<?php echo base_url($natal_chart->natal_chart)?>">
		        </div>
		      </div>

		      <form class="form" action="<?php echo base_url('admin/natal_charts/add/'.$user->id);?>" method="post" enctype="multipart/form-data">
			        
			    	<div class="form-group" style="width:80%;">
			        	<input type="file" name="natal_chart">
			        </div>

			        <div class="form-group" style="width:20%;">
						<button id="submit" class="btn btn-lg btn-primary btn-block">Change Natal Chart</button>
					</div>
			    </form>
		    <?php } else { ?>

		    	<div class="well" style="text-align:center; padding:100px 0;">
					<p style="font-size:24px;">Natal Chart not uploaded.</p>
				</div>

				    <form class="form" action="<?php echo base_url('admin/natal_charts/add/'.$user->id);?>" method="post" enctype="multipart/form-data">
				        
				    	<div class="form-group" style="width:80%;">
				        	<input type="file" name="natal_chart" required>
				        </div>

				        <div class="form-group" style="width:20%;">
							<button id="submit" class="btn btn-lg btn-primary btn-block">Upload Natal Chart</button>
						</div>
				    </form>
		    <?php } ?>
			</div>
		</div>
	</div>
</div>

<?php endblock() ?>

<?php end_extend() ?>