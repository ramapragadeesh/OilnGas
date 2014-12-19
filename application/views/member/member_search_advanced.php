<?php
function dp($info_holderdy,$f,$fsl="")
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
function startsWith($needle, $haystack) {
	return preg_match('/^' . preg_quote($needle, '/') . '/', $haystack);
}

function memberHasHTMLContent(& $memberHTMLList, $memberID) {

	foreach ($memberHTMLList as &$value) {
		if ( $value->user_id == $memberID ) {
			return true;
		}
	}

	return false;
}

function memberListRender(& $memberListData, & $hph,& $memberHTMLData)
{

	foreach ($memberListData as &$value) {
		$memberAddress = "";
		if (strlen($value->user_orgaddress) >= 5) {
			$memberAddress = $value->user_orgaddress;
		} else {
			$memberAddress = $value->user_country;
		}

		$memberImage ="http://placehold.it/200x200";
		if (strlen($value->user_comppic) >= 5) {
			$memberImage = $value->user_comppic;
		}

		$memberWebAddress = "";
		if (startsWith("http",$value->user_webaddress) == true) {
			$memberWebAddress = $value->user_webaddress;
		} else {
			$memberWebAddress = "http://".$value->user_webaddress;
		}


		$memberList .= '
			<div>
			<div class="row">

							<div class="col-xs-12 col-sm-12 col-md-4" style="background-color:whitesmoke">
								<img src="'.$memberImage.'" alt="" class="img-rounded img-responsive" width="200" height="200" />
							</div>

							<div class="col-xs-12 col-sm-12 col-md-4" style="background-color:whitesmoke">
								<h4>'.$value->user_orgname.'</h4>
								<small><cite title="'.$memberAddress.'">'.$memberAddress.'<i class="glyphicon glyphicon-map-marker">
								</i></cite></small>
								<p>
									<i class="glyphicon glyphicon-envelope"></i>'."<span class='sendEmail' orgname='".htmlentities($value->user_orgname, ENT_QUOTES, 'UTF-8')."' memberid='".$value->user_email."'>".dp($hph,"Click here to contact")."</span>".'
									<br>
									<i class="glyphicon glyphicon-globe"></i><a target="_blank" href="'.$memberWebAddress.'">'.$value->user_webaddress.'</a>
									<br>
									<i class="glyphicon glyphicon-gift"></i>'.$value->user_name.'
									<br>
									<i class="glyphicon glyphicon-phone"></i>'.$value->user_contactno.'
									</p>
									<div>
										<button class="btn btn-u viewProfile"  linkvalue="'.base_url().'account/public_profile/?uid='.$value->recordno.'">'.dp($hph,"View Profile").'</button>
									</div>
								</div>';
			if (memberHasHTMLContent($memberHTMLData,$value->recordno) == true ) {
				$memberList .= '	<div class="col-xs-12 col-md-3" style="background-color:#4d4582">

								<a style="color:white" href="'.base_url().'members/'.urlencode(htmlentities($value->user_orgname, ENT_QUOTES, 'UTF-8')).'">'.dp($hph,"View Member Site").'</a>
								</div>
								<div class="col-md-1" style="background-color:whitesmoke">
								</div>';
			}
			$memberList .= '</div>
							<hr>
							</div>';

		}
		return $memberList;
	}

	?>
	<?php
	$paginationInfo = "";
	$paginationInfoPages = "";
	$sub1 = $p - 1;
	$sub2 = $p - 2;
	$add1 = $p + 1;
	$add2 = $p + 2;
	$totalPages = $lastPage;
$showPages = 10;
$pinfo = "";
$currentPage = $p;

if ( $totalPages > $showPages ) {
	$page=$p;
	if ($p != 1 ) {
	$pinfo .= '<li><span  style="cursor:pointer;" onclick="searchSubmit('.($p-1).')">&laquo;</span>';	
	}

	for( $page=$p; $page <= ($p + ($showPages-1) ); $page++) {

		if ($page == $p ) {
		$pinfo .= '<li class="active"><span>'.$page.'</span>';
		} else if ($page > $totalPages) {

		} 
		else {
		$pinfo .= '<li><span  style="cursor:pointer;" onclick="searchSubmit('.$page.')">'.$page.'</span>';
		}

	}
	$page = ($page > $totalPages ? $totalPages : $page); 
	$pinfo .= '<li><span  style="cursor:pointer;" onclick="searchSubmit('.($page).')">&raquo;</span>';
} else {
for( $page=1; $page <= $totalPages; $page++) {
	if ($page == $p) {
	$pinfo .= '<li class="active"><span>'.$page.'</span>';
	} else {
	$pinfo .= '<li><span  style="cursor:pointer;" onclick="searchSubmit('.$page.')">'.$page.'</span>';
	}
  }
}
		// show previous button
	if ($lastPage != "1")
	{
		if ($p != 1)
		{
			$previous = $p - 1;
			$paginationInfo .=  '<li><span class="page-cursor" onclick="searchSubmit('.$previous.')">&laquo;</span>';
		}
	}

	if ($p == 1)
	{
		$paginationInfo .= '<li class="active"><span>' . $p. '</span></li>';
		$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$add1.');return false;">'.$add1.'</span></li>';
	}
	else if ($p == $lastPage)
	{
		$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$sub1.');return false;">'.$sub1.'</span></li>';
		$paginationInfo .= '<li class="active"><span>' . $p. '</span></li>';
	}
	else if ($p > 2 && $p < ($lastPage - 1))
	{
		$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$sub2.');return false;">'.$sub2.'</span></li>';
		$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$sub1.');return false;">'.$sub1.'</span></li>';
		$paginationInfo .= '<li class="active"><span>' . $p. '</span></li>';
		$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$add1.');return false;">'.$add1.'</span></li>';
		$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$add2.');return false;">'.$add2.'</span></li>';
	}
	else if ($p > 1 && $p < $lastPage)
	{
		$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$sub1.');return false;">'.$sub1.'</span></li>';
		$paginationInfo .= '<li class="active"><span>' . $p. '</span></li>';
		$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$add1.');return false;">'.$add1.'</span></li>';
	}
		// show previous button
	if ($lastPage != "1")
	{
		if ($p != $lastPage)
		{
			$nextPage = $p + 1;
			$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$nextPage.')">&raquo;</span></li>';
		}
	}

	?>
	<?php
	if ($lastPage != "1")
	{
		$paginationInfoPages .= 'Page <span class="badge">' . $p . '</span> of <span class="badge" style="background:#4d4582;">' . $lastPage. '</span>';
	}
	?>

	<?php
	error_reporting(1);
	if ( $searchResultEmpty == true)
	{
		echo "<div style='margin-bottom:10px'>
		<h5 style='color:red'>
			".dp($memberLanguageInfo,"No member is found based on your search criteria. Please try again")."
		</h5>
		<span onclick='searchReset()' class='label label-warning' style='cursor:pointer'>
			".dp($memberLanguageInfo,"You can reset your search by clicking here")."
		</span>
	</div>";
	return;
} else {
	?>
	<div id="searchPagination1" style="margin-top:10px">
		<div class="row">
			<div class="col-xs-12 col-md-9">
				<ul class="pagination" style="margin:0 0 0 0;">
					<?php echo $pinfo;?>
				</ul>
			</div>
			<div class="col-xs-12 col-md-3">
				<?php echo $paginationInfoPages;?>
			</div>
		</div>
	</div>
	<hr style="margin-top:5px;margin-bottom:5px;">

	<div>
		<?php echo memberListRender($memberList,$memberLanguageInfo,$userWebContent);?>
	</div>

	<div id="searchPagination2" style="margin-top:10px">
		<div class="row">
			<div class="col-xs-12 col-md-9">
				<ul class="pagination" style="margin:0 0 0 0;">
					<?php echo $pinfo;?>
				</ul>
			</div>
			<div class="col-xs-12 col-md-3">
				<?php echo $paginationInfoPages;?>
			</div>
		</div>
	</div>

	<?php
}
?>

<div id="loginModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabe" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			<h5 style="font-weight:100">
			<?php echo dp($memberLanguageInfo,"This feature is only for registered member, you can signin or register free to access this feature"); ?>
			</h5>
			</div>
			<div class="modal-body">
			<p style="text-align:center"><a href="<?php echo base_url();?>account/newaccount"><?php echo dp($memberLanguageInfo,"Register Free");?></a></p>
			<p style="text-align:center"><a href="<?php echo base_url();?>account/signin"><?php echo dp($memberLanguageInfo,"Signin");?></a></p>
			</div>
			<div class="modal-footer">
			<p><button type="button" class="btn btn-default" data-dismiss="modal"><?php echo dp($memberLanguageInfo,"Close");?></button></p>

			</div>
		</div>
		</div>
</div>

<div id="sendEmailModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h5 style="font-weight:100">
					<?php echo dp($memberLanguageInfo,"You are contacting"); ?>
					<span id="contactName">
					</span>
				</h5>
			</div>
			<div class="modal-body">
				<form method="post" class="form-horizontal" role="form" id="memberContactForm" action="<?php echo  base_url();?>abrasivesworld/member_contact">
				<div class="form-group">
   				<label for="senderName" class="col-sm-3 control-label"><?php echo dp($memberLanguageInfo,"Name");?></label>
   				<div class="col-sm-9">
    			<input type="text" class="form-control" id="senderName" name ="senderName" placeholder="<?php echo dp($memberLanguageInfo,"Enter Name");?>" required>
  				</div>
  				</div>

  				<div class="form-group">
   				<label for="senderEmail" class="col-sm-3 control-label"><?php echo dp($memberLanguageInfo,"Email Address");?></label>
   				<div class="col-sm-9">
    			<input type="email" class="form-control" id="senderEmail" name ="senderEmail" placeholder="<?php echo dp($memberLanguageInfo,"Enter Email");?>" required>
  				</div>
  				</div>

  				<div class="form-group">
   				<label for="senderEmailConfirm" class="col-sm-3 control-label"><?php echo dp($memberLanguageInfo,"Confirm Email Address");?></label>
    			<div class="col-sm-9">
    			<input type="email" class="form-control" id="senderEmailConfirm" name ="senderEmailConfirm" placeholder="<?php echo dp($memberLanguageInfo,"Enter Confirmation Email");?>" required>
  				</div>
  				</div>

  				<div class="form-group">
   				<label for="senderTelephone" class="col-sm-3 control-label"><?php echo dp($memberLanguageInfo,"Telephone No");?></label>
   				<div class="col-sm-9">
    			<input type="text" class="form-control" id="senderTelephone" name ="senderTelephone" placeholder="<?php echo dp($memberLanguageInfo,"Enter Telephone No");?>" required>
  				</div>
  				</div>

  				<div class="form-group">
   				<label for="senderCountry" class="col-sm-3 control-label"><?php echo dp($memberLanguageInfo,"Your Country");?></label>
   				<div class="col-sm-9">
    			<input type="text" class="form-control" id="senderCountry" name ="senderCountry" placeholder="<?php echo dp($memberLanguageInfo,"Enter Your Country");?>" required>
  				</div>
  				</div>

  				<div class="form-group">
   				<label for="senderCompany" class="col-sm-3 control-label"><?php echo dp($memberLanguageInfo,"Your Company");?></label>
   				<div class="col-sm-9">
    			<input type="text" class="form-control" id="senderCompany" name ="senderCompany" placeholder="<?php echo dp($memberLanguageInfo,"Enter Your Company");?>" required>
  				</div>
  				</div>

  				<div class="form-group">
   				<label for="senderMessage" class="col-sm-3 control-label"><?php echo dp($memberLanguageInfo,"Message");?></label>
   				<div class="col-sm-9">
    			<textarea  class="form-control" id="senderMessage" name ="senderMessage" rows="6" required></textarea>
  				</div>
  				</div>
  				<p><input type="hidden" name="receiverEmail" id="receiverEmail" value=""></p>
				<p><button type="submit" class="btn btn-u"><?php echo dp($memberLanguageInfo,"Send");?></button></p>
				</form>

			</div>
			<div class="modal-footer">
				<p><button type="button" class="btn btn-default" data-dismiss="modal"><?php echo dp($memberLanguageInfo,"Close");?></button></p>
				<p><a href="<?php echo base_url();?>account/newaccount"><?php echo dp($memberLanguageInfo,"Do you want to register with abrasivesworld?");?></a>
				</p>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


<style>
	.sendEmail {
		cursor: pointer;
		font-style: italic;
	}
</style>
<script>
var isSignin = false;
<?php
if ($ulogset == true) {
echo "isSignin = true;";
}
?>
	$( ".sendEmail" ).click(function() {
		if (isSignin == true) {
		$("#receiverEmail").val($(this).attr('memberid'))
		$("#contactName").text($(this).attr('orgname'))
		$( "#sendEmailModal" ).modal();
		} else {
		$( "#loginModal" ).modal();
		}
	});
		$( ".viewProfile" ).click(function() {
		if (isSignin == true) {
			console.log($(this).attr("linkvalue"))
			window.location = $(this).attr("linkvalue")
		} else {
		$( "#loginModal" ).modal();
		}
	});
	$("#memberContactForm").submit(function() {
		if ( $("#senderEmail").val() !=  $("#senderEmailConfirm").val()) {
			alert('<?php echo dp($memberLanguageInfo,"Please check your email address.");?>')
			return false;
		}
		   $.ajax({
           type: "POST",
           url: '<?php echo  base_url();?>abrasivesworld/member_contact',
           data: $("#memberContactForm").serialize(), // serializes the form's elements.
           success: function(data)
           {
               alert("Email has been sent."); // show response from the php script.
               $( "#sendEmailModal" ).modal("hide");
           }
         });
    return false; // avoid to execute the actual submit of the form.
	});
</script>