<?php
function userLocaleConversion(& $info_holderdy,$f) {
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
<html>
<head>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>

	<div class="container" style="margin-top:10px">
	<?php if ($showInfo == true ) { ?>
		<div class="row" style="padding-bottom:10px">
			<div class="col-xs-12 col-md-4">
				<h4 style="font-weight:100"> <?php echo userLocaleConversion($websiteLanguageInfo,"Your company mini website URL is ");?>
				</h4>
			</div>
			<div class="col-xs-12 col-md-6">
				<h4 style="font-weight:100">
				<a href="<?php echo base_url()?>members/<?php echo $orgName;?>"><?php echo base_url()?>members/<?php echo $orgName;?></a>
				</h4>
			</div>
		</div>
	<?php } ?>
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<!-- Wrapper for slides -->
			<!-- End Carousel Inner -->
			<ul class="nav nav-pills nav-justified">
				<li data-target="#myCarousel" data-slide-to="0" class="active"><a href="#"><?php echo $labelHome; ?></small></a></li>				
				<li data-target="#myCarousel" data-slide-to="1"><a href="#"><small><?php echo $labelAboutus; ?></small></a></li>
				<li data-target="#myCarousel" data-slide-to="2"><a href="#"><small><?php echo $labelServices; ?></small></a></li>
				<li data-target="#myCarousel" data-slide-to="3"><a href="#"><small><?php echo $labelContactus; ?></small></a></li>
			</ul>      
			<div class="carousel-inner">
				<div class="item active">
					<?php echo $homeContent;?>   
				</div>
				<!-- End Item -->
				<div class="item">
					<?php echo $aboutusContent;?>      
				</div>
				<!-- End Item -->
				<div class="item">
					<?php echo $servicesContent;?>  
				</div>

				<!-- End Item -->
				<div class="item">
					<?php echo $contactusContent;?>                      
				</div>
				<!-- End Item -->
			</div>

		</div>

		<!-- End Carousel -->
	</div>


	<script src="<?php echo  base_url();?>tinymce/tinymce.min.js"> </script>

	<script>
		$(document).ready( function() { 
			$('#myCarousel').carousel({
				interval:   400000000
			});

			var clickEvent = false;
			$('#myCarousel').on('click', '.nav a', function() {
				clickEvent = true;
				$('.nav li').removeClass('active');
				$(this).parent().addClass('active');        
			}).on('slid.bs.carousel', function(e) {
				if(!clickEvent) {
					var count = $('.nav').children().length -1;
					var current = $('.nav li.active');
					current.removeClass('active').next().addClass('active');
					var id = parseInt(current.data('slide-to'));
					if(count == id) {
						$('.nav li').first().addClass('active');    
					}
				}
				clickEvent = false;
			});
		});
	</script>
	<style type="text/css">
		#myCarousel .nav a small
		{
			display: block;
		}
		#myCarousel .nav
		{
			background: #eee;
		}
		.nav-justified > li > a
		{
			border-radius: 0px;
		}
		.nav-pills>li[data-slide-to="0"].active a { background-color: #16a085; }
		.nav-pills>li[data-slide-to="1"].active a { background-color: #e67e22; }
		.nav-pills>li[data-slide-to="2"].active a { background-color: #2980b9; }
		.nav-pills>li[data-slide-to="3"].active a { background-color: #8e44ad; }
	</style>
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-46868538-1', 'abrasivesworld.com');
	ga('send', 'pageview');


</script>
</body>
</html>