<?php extend('common/base') ?>

<?php startblock('content') ?>

	<div style="text-align:center">
		<h3>View Query</h3>
	</div>
	
	<br/>

	<form class="form" role="form">
		<div class= "row">
			<div class="col-md-12">
				<div class="col-md-10 col-md-offset-2">
					<div class="form-group" style="width:80%;">
					    <label for="Query">Query</label>
					    <textarea class="form-control" rows="5" name="query" readonly><?php echo $query->query;?></textarea>
					</div>

					<div class="form-group" style="width:80%;">
					    <label for="answer">Answer from Astrologer</label>
					    <textarea class="form-control" rows="12" name="answer"  id="answer" readonly><?php echo $query->answer;?></textarea>
					</div>
				</div>
			</div>
	    </div>

	    <br/>
	    <div class="row">
			<div class="col-md-12">
				<div class="col-md-10 col-md-offset-2">
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