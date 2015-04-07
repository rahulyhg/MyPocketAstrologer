<?php extend('common/base') ?>

<?php startblock('content') ?>

<div class="container">

	<?php 
	if(isset($upload_data))
		print_r($upload_data);
	else
	?>

	<div class="row-fluid"  style="margin-top:90px;">
		<div class="span12">
		    <form class="form" enctype="multipart/form-data" role="form" method ="POST" action="<?php echo base_url('users/users/upload');?>">
			      
		    		<div class="form-group" style="width:80%;">		    	

		    		    <label for="upload">Photo</label>
		    		     <input type="file" name="userfile" class="form-control">
		    		    <br/><br/><br/>

		    		</div>		      
		   
		        <button type="submit" class="btn btn-primary">Upload</button>
		  	</form>
		</div>	
	</div>
</div>


<?php endblock() ?>

<?php end_extend() ?>