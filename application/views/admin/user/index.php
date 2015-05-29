<?php extend('common/base') ?>

<?php startblock('content') ?>

<?php

$config = array(
    'headers' => (object) array(
    	'Name' => 'first_name',
    	'Date of Birth' => 'date_of_birth', 
    	'Gender' => 'gender',
    	'Birth Place' => 'place_of_birth',
    	'Email' => 'email',
    	'Queries' => 'queries_count',
    ),
    'cur_page' => $users->get_current_page(),
    'base_url' => '/MyPocketAstrologer/admin/users/index',
    'order_by_field' => $users->get_field(),
    'order_by_direction' => $users->get_direction(),
    'search' => $users->get_search_term(),
    'total_rows' => $users->get_total_rows(),
    'per_page' => $users->get_page_size(),
);

$this->bspaginator->config($config);

?>

<div class="container">

	<div class="row-fluid">
		<div class="span12">

			<div class="pull-left">
				<h2>Listing Users</h2>
				<h5 style="margin-left:5px;">Showing result<?php echo ($users->get_total_rows() == 1) ? '' : 's';?> <?php echo ($users->get_page_size() > $users->get_total_rows()) ? $users->get_total_rows() : ($users->get_page_size() * ($users->get_current_page() - 1) + 1) .' - '. ($users->get_page_size() * ($users->get_current_page() - 1) + $users->get_row_per_current_page());?> of <?php echo number_format($users->get_total_rows());?></h5>
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

				<form name="search-user" action="<?php echo base_url('admin/users/index');?>">
					<div class="row-fluid">
						<div class="col-lg-12" style="margin-bottom:2%;margin-top:20px%;">
							<div class="col-lg-3">
								<label for="Search Term">Search Term</label>
								<input style="" class="form-control" name="search" type="text" value="<?php echo $users->get_search_term() ? $users->get_search_term() : '';?>" placeholder="Type search term..." autofocus>
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
						<?php if($users->get_total_rows() > 0){ ?>

						<div class="table-container">
							<table class="table table-striped table-bordered" style="margin-bottom:85px;">

								<?php echo $this->bspaginator->table_header();?>

								<tbody>
									<?php foreach ($users as $user){ ?>
										<tr>
											<td><?php echo $user->get_full_name();?></td>
											<td><?php echo date('M d, Y', strtotime($user->date_of_birth));?></td>
											<td>
												<?php
												if($user->gender == 0)
													echo "Male";
												else
													echo "Female";
												?>
											</td>
											<td><?php echo $user->place_of_birth;?></td>
											<td><?php echo $user->email;?></td>
											<td><?php echo $user->queries_count;?></td>
											
											<td style="text-align:center;width:65px;">
											<div class="btn-group">
						  						<a class="btn dropdown-toggle" style="border:1px solid #eee;" data-toggle="dropdown" href="#">
						    						Actions <span class="caret"></span>
						  						</a>
												<ul class="dropdown-menu" style="text-align:left;">	
													<!-- <li><a href="<?php echo base_url('patients/edit/'.$patient->id);?>">Edit</a></li>
													<li><a onclick="pass_pub_id('<?php echo $patient->pub_id;?>');" data-toggle="modal" data-target="#myModal">Add Follow Up</a></li>
													<li><a href="<?php echo base_url('patients/view_report/'.$patient->id);?>">View Report</a></li> -->
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
								<p style="font-size:24px;">No Users found.</p>
								<p style="font-size:14px;">Your user query has not returned any valid results.</p>
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