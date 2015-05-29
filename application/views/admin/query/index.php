<?php extend('common/base') ?>

<?php startblock('content') ?>

<?php

$config = array(
    'headers' => (object) array(
    	'Name' => 'first_name',
    	'Email' => 'email',
    	'Query' => 'query',
    	'Answer' => 'answer',
    	'Asked On' => 'created_at',
    ),
    'cur_page' => $queries->get_current_page(),
    'base_url' => '/MyPocketAstrologer/admin/queries/index',
    'order_by_field' => $queries->get_field(),
    'order_by_direction' => $queries->get_direction(),
    'search' => $queries->get_search_term(),
    'total_rows' => $queries->get_total_rows(),
    'per_page' => $queries->get_page_size(),
);

$this->bspaginator->config($config);

?>

<div class="container">

	<div class="row-fluid">
		<div class="span12">

			<div class="pull-left">
				<h2>Listing Queries</h2>
				<h5 style="margin-left:5px;">Showing result<?php echo ($queries->get_total_rows() == 1) ? '' : 's';?> <?php echo ($queries->get_page_size() > $queries->get_total_rows()) ? $queries->get_total_rows() : ($queries->get_page_size() * ($queries->get_current_page() - 1) + 1) .' - '. ($queries->get_page_size() * ($queries->get_current_page() - 1) + $queries->get_row_per_current_page());?> of <?php echo number_format($queries->get_total_rows());?></h5>
			</div>

			<div class="pager pull-right" style="margin-top: 5px;">
				<?php echo $this->bspaginator->pagination_links();?>
			</div>

			<br/>
		</div>
	</div>

	<br/>

	<div class="row-fluid" style="margin-top:90px;">

		<div class="span12">
			<div class="row-fluid">

				<form name="search-query" action="<?php echo base_url('admin/queries/index');?>">
					<div class="row-fluid">
						<div class="col-lg-12" style="margin-bottom:2%;margin-top:20px%;">
							<div class="col-lg-3">
								<label for="Search Term">Search Term</label>
								<input style="" class="form-control" name="search" type="text" value="<?php echo $queries->get_search_term() ? $queries->get_search_term() : '';?>" placeholder="Type search term..." autofocus>
							</div>

							<div class="">
								<label for="search"></label>
								<button type="submit" class="btn btn-success" style="margin-top:2.3%;"><i class="icon-search"></i>Filter</button>
							</div>

						</div>
					</div>
					<br>

				</form>
					<hr>
					<div class="span9">
						<?php if($queries->get_total_rows() > 0){ ?>

						<div class="table-container">
							<table class="table table-striped table-bordered" style="margin-bottom:85px;">

								<?php echo $this->bspaginator->table_header();?>

								<tbody>
									<?php foreach ($queries as $query){ ?>
										<tr>
											<td><?php echo $query->user->get_full_name();?></td>
											<td><?php echo $query->user->email;?></td>
											<td><?php echo $query->query;?></td>
											<td><?php echo $query->answer;?></td>
											<td><?php echo date('M d, Y', strtotime($query->created_at));?></td>																						
											
											<td style="text-align:center;width:65px;">
											<div class="btn-group">
						  						<a class="btn dropdown-toggle" style="border:1px solid #eee;" data-toggle="dropdown" href="#">
						    						Actions <span class="caret"></span>
						  						</a>
												<ul class="dropdown-menu" style="text-align:left;">
													<?php if($query->answer == '') { ?> 
													<li><a href="<?php echo base_url('admin/queries/answer/'.$query->id);?>">Answer query</a></li>
													<?php } ?>
													<li><a href="<?php echo base_url('admin/queries/edit/'.$query->id);?>">Edit</a></li>
												</ul>
											</div>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<?php } else { ?>
							<div class="well" style="text-align:center; padding:100px 0;">
								<p style="font-size:24px;">No Queries found.</p>
								<p style="font-size:14px;">Your search query has not returned any valid results.</p>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<?php endblock() ?>

<?php end_extend() ?>