<?php
function check_loggedin($ulog,$uname,& $lng,$link)
{
$dire="";

if ($ulog== true)
{
	if ($link==1)
	{
	$dire="<li><a href='".base_url()."account/my_profile'>".dp_header($lng,"My Account")."</a></li>";
	return $dire;
	}
	else
	{
	$dire="<li><a href='#'>".dp_header($lng,"Welcome")." ".dp_header($lng,$uname)."</a></li>";
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
	$dire="<li><a href='#'>".dp_header($lng,"Welcome")." ".dp_header($lng,$uname)."</a></li>";
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
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body
{
min-width:984px;
}
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
</style>

<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	

	<link href="<?php echo base_url();?>application/assets/css/bootstrap.css" rel="stylesheet">
	<script src="<?php echo base_url();?>application/js/jquery-latest.min.js"> </script>
	
	<script src="<?php echo base_url();?>application/assets/js/bootstrap.min.js"> </script>
<script src="http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<style type="text/css" media="all">
  @import url("<?php echo base_url();?>tinymce/datepicker.css");
   
 </style>
<script src="<?php echo base_url();?>tinymce/bootstrap-datepicker.js"></script>

<?php
 if (isset($css)==true)
{
foreach($css as &$value)
{
echo '<script src="'.$value.'"></script>';
}
}
?>
</head>
<body>
<div>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">
		  <b style="color:white"> Abrasivesworld</b>

		  </a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li ><a href="<?php echo base_url();?>"><?php echo dp_header($infoheader_holder,"Home");?></a></li>
      <li ><a href="<?php echo base_url();?>abrasivesworld/about_us"><?php echo dp_header($infoheader_holder,"About Us");?></a></li>
      <li><a href="<?php echo base_url();?>abrasivesworld/contact_us"><?php echo dp_header($infoheader_holder,"Contact Us");?></a></li>
      <li><a href="#"><?php echo dp_header($infoheader_holder,"News");?></a></li>
	   <li ><a href="<?php echo base_url();?>abrasivesworld/members"><?php echo dp_header($infoheader_holder,"Members");?></a></li>
      <?php echo check_loggedin($ulogset,$usernamesses,$infoheader_holder,1);?>
          <li>
		  <?php 
if ($ulogset ==false)
{
?>

<a href="<?php echo base_url();?>account/signin"><?php echo dp_header($infoheader_holder,"sign in");?></a>
</li>
<li>
<a  href="<?php echo base_url();?>account/newaccount"><?php echo dp_header($infoheader_holder,"Sign up");?></a>
</li>
<?php echo check_loggedin($ulogset,$usernamesses,$infoheader_holder,0);?>
<?php
}
elseif($ulogset==true)
{
?>
<?php echo check_loggedin($ulogset,$usernamesses,$infoheader_holder,0);?>
<li><a  href="<?php echo base_url();?>account/logout"><?php echo dp_header($infoheader_holder,"Logout");?></a></li>
<?php
}
?>

		  <li>
		  <a href="<?php echo base_url();?>setlanguage?lan=en">English</a>
		  </li>
		  <li>
		<a href="<?php echo base_url();?>setlanguage?lan=cn">中文</a>

		  </li>
		  </ul>
        </div><!--/.nav-collapse -->
      </div>
</div>



</div>
