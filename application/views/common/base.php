<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="#">

    <title>My Pocket Astrologer</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('public/css/bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('public/css/bootstrap.css');?>" rel="stylesheet">

    <script src="<?php echo base_url('public/js/jquery.js');?>"></script>
    <script src="<?php echo base_url('public/js/bootstrap.min.js');?>"></script>

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('public/custom/css/offcanvas.css')?>" rel="stylesheet">
    </head>

    <body>

    <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="/MyPocketAstrologer">MyPocketAstrologer</a>
            </div>

            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/MyPocketAstrologer">Home</a></li>
                   
                    <li><a href="<?php echo base_url('auth/logout');?>">Sign Out</a></li>
                </ul>
                <div style="color:white;text-align:right;padding-top:7px;">Welcome <?php echo $this->session->userdata('user_name');?>!</div>
                <div id="datetime" style="text-align:right;padding-top:1px;"></div>
            </div><!-- /.nav-collapse -->
        </div><!--/.container -->
    </div><!-- /.navbar -->
    
    <div class="container">
    
        <div class = "message">
            <?php if(isset($message)){ ?>
                <div class = "alert-success">
                    <?php echo $message;?>
                </div>
            <?php } ?>

            <?php if($this->session->flashdata('alert_success')){ ?>
                <div class = "alert-success">
                    <h3><?php echo $this->session->flashdata('alert_success');?></h3>
                </div>
            <?php } ?>

            <?php if($this->session->flashdata('alert_error')){ ?>
                <div class = "alert-error">
                    <h3><?php echo $this->session->flashdata('alert_error');?></h3>
                </div>
            <?php } ?>

        </div>

    </div>

    <?php start_block_marker('content') ?>
    <?php end_block_marker() ?>

  </body>
</html>

<script type="text/javascript">

  display_ct(); 

  function display_c(){
    var refresh=1000; // Refresh rate in milli seconds
    mytime=setTimeout('display_ct()',refresh);
  }

  function display_ct() {
    var strcount;
    var x = new Date();
    var d = x.toString();
    document.getElementById('datetime').innerHTML = d.substring(0,24);
    document.getElementById('datetime').style.color ="White";
    tt=display_c();
  }
  
</script> 