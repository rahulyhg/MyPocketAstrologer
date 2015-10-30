<?php extend('common/base') ?>

<?php startblock('content') ?>

	<div style="text-align:center">
		<h3>View Query</h3>
	</div>
	
	<br/>

	<form class="form" role="form">
		<div class= "row">
			<div class="col-md-12">
				<div class="col-md-9 col-md-offset-2">
					<div class="form-group" style="width:80%;">
					    <label for="Query">Query</label>
					    <input type="text" name="query" value="<?php echo $query->query;?>" class="form-control" readonly>
					</div>

					<div class="form-group" style="width:80%;">
					    <label for="answer">Answer from Astrologer</label>
					    <textarea class="form-control" rows="5" name="answer"  id="answer" readonly><?php echo $query->answer;?></textarea>
					</div>
				</div>
			</div>
	    </div>

	    <br/>
	    <div class="row">
			<div class="col-md-12">
				<div class="col-md-9 col-md-offset-2">
					<div class="form-group" style="width:80%;">
						<a href="<?php echo base_url('admin/queries')?>" class="btn btn-lg btn-primary btn-block">Back</a>
					</div>
				</div>		
			</div>
		</div>
	</form>
</div><!-- /bootstrap --> 

<?php endblock() ?>

<?php end_extend() ?>