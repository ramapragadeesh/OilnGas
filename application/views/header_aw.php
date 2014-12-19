<?php
function check_loggedin($ulog,$uname,& $lng,$link)
{
	$dire="";

	if ($ulog== true)
	{
		if ($link==1)
		{
			$dire='
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					'.dp_header($lng,"My Account").'
				</a>
				<ul class="dropdown-menu">
										<li>
						<a  href="'.base_url().'account/my_profile">'.dp_header($lng,"My Profile").'</a>
					</li>
					<li>
						<a  href="'.base_url().'account/logout">'.dp_header($lng,"Logout").'</a>
					</li>
				</ul>
			</li>';
			return $dire;
		}
		else
		{
			//$dire="<li><a>".dp_header($lng,"Welcome")." ".dp_header($lng,$uname)."</a></li>";
			return $dire;
		}
	}
	else
	{
		if ($link==1)
		{
			$dire="";
			return $dire;
		}
		else
		{
			//$dire="<li><a>".dp_header($lng,"Welcome")." ".dp_header($lng,$uname)."</a></li>";
			return $dire;
		}

	}



}
function dp_header($info_holderdy,$f)
{
	$rt=$f;
	foreach ($info_holderdy as &$value)
	{
		if (strtolower($value->default_text) == strtolower($f))
		{
			$rt = $value->dp;
			break;
		}
	}
	return $rt;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>

	<meta charset="utf-8" />
	<meta name="Author" content="Abrasives Worlld." />
	<link rel="shortcut icon" href="<?php echo base_url();?>/application/ico/icon.png">
	<!-- start: Mobile Specific -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>		
		.headerfonte
		{
			font-family:"Century Gothic", CenturyGothic, AppleGothic, sans-serif;
			font-size:15px;

		}
		.headerfontc
		{
			font-family:"Century Gothic", CenturyGothic, AppleGothic, sans-serif;
			font-size:14px;

		}
		.bkbody{
			background:#ffffff;
			/* Old Browsers */background:-moz-linear-gradient(top, #ffffff 0%, #ffffff 20%, rgba(0, 0, 0, 0.38) 100%);
			/* FF3.6+ */background:-webkit-gradient(left top, left bottom, color-stop(0%, #ffffff), color-stop(20%, #ffffff), color-stop(100%, rgba(0, 0, 0, 0.38)));
			/* Chrome,Safari4+  */background:-webkit-linear-gradient(top, #ffffff 0%, #ffffff 20%, rgba(0, 0, 0, 0.38) 100%);
			/* Chrome10+,Safari5.1+ */background:-o-linear-gradient(top, #ffffff 0%, #ffffff 20%, rgba(0, 0, 0, 0.38) 100%);
			/* Opera 11.10+ */background:-ms-linear-gradient(top, #ffffff 0%, #ffffff 20%, rgba(0, 0, 0, 0.38) 100%);
			/* IE 10+ */background:linear-gradient(to bottom, #ffffff 0%, #ffffff 20%, rgba(0, 0, 0, 0.38) 100%);
			/* W3C */filter:progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#000000', GradientType=0 );
			/* IE6-9 */background-repeat:no-repeat;background-attachment:fixed;
		}

	</style>
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- end: Mobile Specific -->
	<link href="<?php echo base_url();?>application/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url();?>application/css/bootstrap-theme.min.css" rel="stylesheet">
	<link href="<?php echo base_url();?>application/css/custom.css" rel="stylesheet">
	<!-- start:<script src="http://code.jquery.com/jquery-latest.min.js"> </script> CSS Link-->
	<script src="<?php echo base_url();?>application/js/jquery-latest.min.js"> </script>
	<script src="<?php echo base_url();?>application/js/bootstrap.min.js"> </script>
	<link href="<?php echo base_url();?>application/css/animate.css" rel="stylesheet">
	<script src="<?php echo base_url();?>application/js/bootbox.js"> </script>
	<script src="http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
	<style type="text/css" media="all">
		@import url("<?php echo base_url();?>tinymce/datepicker.css");
	</style>
	<script src="<?php echo base_url();?>tinymce/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url();?>tinymce/jquery.validate.min.js"></script>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<!--<link href="<?php echo base_url();?>application/css/fonts/font-awesome.min.css" rel="stylesheet"> -->
	<style>
		.navbar-inverse .navbar-brand
		{
			color: #ffffff;
			font-family: initial;
		}
		.navbar-inverse .navbar-nav > li > a {
			color: #ffffff;
		}

		.panel-default
		{
			border-color:#ffffff;
		}
		.panel-default > .panel-heading
		{
			background: #1ABB9C;
			border-color: #1ABB9C;
			color: #ffffff;
		}
		.navbar
		{
			border-radius: 0px;
		}
		.form-control
		{
			max-width: 300px;
		}
	</style>
	<?php
	if (isset($css)==true)
	{
		foreach($css as &$value)
		{
			echo '<script src="'.$value.'"></script>';
		}
	}
	?>
	<style>

/*Top Bar (login, search etc.)
------------------------------------*/
.topbar {
	z-index: 12;
	padding: 8px 0;
	position: relative;
}

.topbar ul.loginbar {
	margin: 0;
}

.topbar ul.loginbar > li {
	display: inline;
	list-style: none;
	position: relative;
	padding-bottom: 15px;
}

.topbar ul.loginbar > li > a, 
.topbar ul.loginbar > li > a:hover {
	color: #7c8082;
	font-size: 11px;
	text-transform: uppercase;
}

.topbar ul.loginbar li i.fa { 
	color: #bbb;
}

.topbar ul.loginbar li.topbar-devider { 
	top: -1px;
	padding: 0;
	font-size: 8px;
	position: relative;
	margin: 0 9px 0 5px;
	font-family: Tahoma;
	border-right: solid 1px #bbb;
}

/*Lenguages*/
.topbar ul.lenguages {
	top: 25px;
	left: -5px;
	display: none;
	padding: 4px 0;
	padding-left: 0; 
	list-style: none;
	min-width: 100px;
	position: absolute;
	background: #f0f0f0;
}

.topbar li:hover ul.lenguages {
	display: block;
}

.topbar ul.lenguages:after {
	top: -4px;
	width: 0; 
	height: 0;
	left: 8px;
	content: " "; 
	display: block; 
	position: absolute;
	border-bottom: 6px solid #f0f0f0;	
	border-left: 6px solid transparent;
	border-right: 6px solid transparent;
	border-left-style: inset; /*FF fixes*/
	border-right-style: inset; /*FF fixes*/
}

.topbar ul.lenguages li a {
	color: #555;
	display: block;
	font-size: 10px;
	padding: 2px 12px;
	margin-bottom: 1px;
	text-transform: uppercase; 
}

.topbar ul.lenguages li.active a i {
	color: #999;
	float: right;
	margin-top: 2px;
}

.topbar ul.lenguages li a:hover, 
.topbar ul.lenguages li.active a {
	background: #fafafa;
}

.topbar ul.lenguages li a:hover {
	text-decoration: none; 
}


</style>
</head>
<body style="margin:auto;">
<div class="header">
	<div class="topbar">
		<div class="container">

			<!-- Topbar Navigation -->
			<ul class="loginbar pull-right">
			<?php if ($ulogset == false ) { ?>
				
				<li><a href="<?php echo base_url();?>account/signin"><?php echo dp_header($infoheader_holder,"sign in");?></a></li>
				<li class="topbar-devider"></li>
				<li><a  href="<?php echo base_url();?>account/newaccount"><?php echo dp_header($infoheader_holder,"Sign up");?></a></li>
			<?php } else { ?>
				
				<li><a href="<?php echo  base_url();?>account/my_profile"><b style="color:purple"><?php echo dp_header($infoheader_holder,"Welcome");?> <?php echo $usernamesses;?></b></a></li>
			<?php 
			}
			?>	<li class="topbar-devider"></li>
				<li><a href="<?php echo base_url();?>setlanguage?lan=en">English</a></li>
				<li class="topbar-devider"></li>
				<li><a href="<?php echo base_url();?>setlanguage?lan=cn">中文</a></li>								
				<li class="topbar-devider"></li>
				<li><a href="http://abrasivesworld.com/classic"><?php echo dp_header($infoheader_holder,"Classic Display");?></a></li>
		
			</ul>
			<!-- End Topbar Navigation -->
		</div>
	</div>
	<div class="navbar navbar-default" role="navigation">
            <div class="container">
            <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="fa fa-bars"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url();?>">
                        <img id="logo-header" src="<?php echo base_url();?>/application/img/logo.png" style="width:150px" alt="Logo">
                    </a>
                </div>
	<div class="collapse navbar-collapse navbar-responsive-collapse" style="background:#FFFFFF">
		<ul class="nav navbar-nav">
			<li >
				<a href="<?php echo base_url();?>"><?php echo dp_header($infoheader_holder,"Home");?></a>
			</li>
			<li ><a href="<?php echo base_url();?>abrasivesworld/about_us"><?php echo dp_header($infoheader_holder,"About Us");?></a></li>
			<li><a href="<?php echo base_url();?>abrasivesworld/contact_us"><?php echo dp_header($infoheader_holder,"Contact Us");?></a></li>
			<li><a href="<?php echo base_url();?>abrasivesworld/news"><?php echo dp_header($infoheader_holder,"News");?></a></li>
			<li><a href="<?php echo base_url();?>abrasivesworld/members"><?php echo dp_header($infoheader_holder,"Members");?></a></li>					
			<?php
			if ($ulogset ==false)
			{
				?>

				<li><a href="<?php echo base_url();?>account/signin"><?php echo dp_header($infoheader_holder,"sign in");?></a></li>
				<li><a  href="<?php echo base_url();?>account/newaccount"><?php echo dp_header($infoheader_holder,"Sign up");?></a></li>
				<?php echo check_loggedin($ulogset,$usernamesses,$infoheader_holder,0);?>
				<?php
			}
			else
			{
				echo check_loggedin($ulogset,$usernamesses,$infoheader_holder,1);
			}
			?>


		</ul>
	</div>
	</div>
	</div>
	</div>
