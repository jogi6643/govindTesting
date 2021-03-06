<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="description" content="">
<meta name="author" content="Praveen">
<link rel="icon" href="<?=base_url()?>skin/img/icon.png" type="image/png">
<!-- Title -->
<title><?php echo $title; ?></title>
<!-- Vendor CSS -->
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/bootstrap4/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/themify-icons/themify-icons.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/vendor/toastr/toastr.min.css">
<!-- Core CSS -->
<link rel="stylesheet" href="<?php echo base_url();?>skin/css/core.css">
<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<script>
      $(document).ready(function() {
        $('input').attr('autocomplete', 'off');
      });
    </script>
</head>
<body class="auth-bg" onload="createCaptcha();">
<div class="auth">
<section class="logincont">
<div class="main">
	
    <div class="auth-header">
	
        <div class="mb-2"><img src="<?php echo base_url();?>uploads/logo/signin/<?php echo $company[0]->sign_in_logo;?>" title="">
		
				
		</div>
        <h5><?php echo $company[0]->company_name;?></h5>
    </div>
    
    <div class="container-fluid">
        <div class="row">
            <div class="">
                <form class="mb-1" method="post" name="hrm-form" id="hrm-form" data-redirect="dashboard?module=dashboard" data-form-table="login" data-is-redirect="1" autocomplete="off">
					
					<div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" name="iusername" id="iusername" placeholder="Enter e-mail ID along with @dcil.co.in only" autocomplete="off">
                            <div class="input-group-addon"><i class="ti-user"></i></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                        <input type="password" class="form-control" name="ipassword" id="ipassword" placeholder="Password" autocomplete="off">
                            <div class="input-group-addon"><i class="ti-key"></i></div>
                        </div>
                    </div>
					
					<div id="captcha" ></div>
					<div class="form-group">
                        <div class="input-group">
                        <input type="hidden" class="form-control" name="captcha_code" id="captcha_code"  placeholder="Captcha" autocomplete="off" value="">
                        <input type="text" class="form-control" name="captcha" id="cpatchaTextBox" placeholder="Captcha" autocomplete="off">
                            <div class="input-group-addon"><i class="fa fa-refresh" onclick="createCaptcha();"></i></div> 
                        </div>
                    </div>
                    
					<div class="form-group clearfix">
                        <div class="float-xs-right">
                            <a class="text-blue font-90" href="<?php echo site_url('forgot_password');?>">Forgot password?</a>
                        </div>
                    </div>
                    <div id="btnsubmit">
                        <button type="submit" class="btn btn-signin btn-block">Sign in</button>
                    </div>
                </form>
                <div class="row">
                <div class="col-md-12 .offset-md-3 copyright">
				<span class="font13">
				<?php date_default_timezone_set("Asia/Kolkata"); echo date('D M d ').", " .date('H:i:s').", IST ".date('Y') ;?><br><?php  $ip = $_SERVER['REMOTE_ADDR']; echo "Your IP is: ".$ip;?><br>
						</span>
				
                <?php if($system[0]->enable_current_year=='yes'):?><?php echo date('Y');?> <?php endif;?> ?? <?php echo $system[0]->footer_text;?>
                <?php if($system[0]->enable_page_rendered=='yes'):?>
                <!--<br>Page rendered in <strong>{elapsed_time}</strong> seconds. --><?php /*echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' */?>
                <?php endif; ?>
				<br>Powered by <a href="https://www.netprophetsglobal.com/" target="_blank">Netprophets Cyberworks Pvt. Ltd.</a>
                </div>
                </div>
            </div>
        </div>
    </div>
	</div>
</section>
</div>
<!-- Vendor JS -->
<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/tether/js/tether.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/vendor/toastr/toastr.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	toastr.options.closeButton = <?php echo $system[0]->notification_close_btn;?>;
	toastr.options.progressBar = <?php echo $system[0]->notification_bar;?>;
	toastr.options.timeOut = 3000;
	toastr.options.preventDuplicates = true;
	toastr.options.positionClass = "<?php echo $system[0]->notification_position;?>";
});

 $('#ipassword').bind("cut copy paste",function(e) {
          e.preventDefault();
          alert("Copy or Paste not allowed");
      });
</script>
<script type="text/javascript">var base_url = '<?php echo base_url(); ?>';</script>
<script type="text/javascript" src="<?php echo base_url();?>skin/js_module/xin_login.js"></script>
<script src="<?php echo base_url();?>skin/js/capthavalidation.js"></script>
</body>
</html>
