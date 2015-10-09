<!DOCTYPE html>
<html lang="en">
  <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">

    <title>AstroVeda - My Pocket Astrologer</title>

    <!-- Bootstrap core CSS -->
    <!-- Bootstrap core CSS -->
       <link href="<?php echo base_url('public/css/bootstrap.min.css');?>" rel="stylesheet">
       <link href="<?php echo base_url('public/css/bootstrap.css');?>" rel="stylesheet">

       <script src="<?php echo base_url('public/js/jquery.js');?>"></script>
       <script src="<?php echo base_url('public/js/bootstrap.min.js');?>"></script>

       <!-- Custom styles for this template -->
       <link href="<?php echo base_url('public/custom/css/signin.css')?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!-- <link href="public/custom/css/signin.css" rel="stylesheet"> -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
    
        <div class = "message">
            <?php if(isset($message)){ ?>
                <div class = "alert-error">
                    <?php echo $message;?>
                </div>
            <?php } ?>

            <?php if($this->session->flashdata('alert_error')){ ?>
                <div class = "alert-error">
                    <?php echo $this->session->flashdata('alert_error');?>
                </div>
            <?php } ?>

        </div>

    </div>

    <?php start_block_marker('content') ?>
    <?php end_block_marker() ?>

  </body>
</html>