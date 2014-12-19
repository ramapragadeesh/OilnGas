<?php
function dp($info_holderdy,$f,$fsl="")
{
	$rt=$f;

	if ($fsl == "F" && strtolower($f)== "annual output")
	{
		$rt="Annual Consumption";
	}

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
<div class="container" style="margin-top:10px">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo dp($info_holder,"Contact Abrasives Wordld");?></h3>
		</div>
		<div class="panel-body">
			<div>
				<div style="padding-left:30px;padding-right:30px;padding-top:20px;font-size:14px;line-height:20px">
					<form id="fcontact"  role="form">
						<div>
							<div>
								<div class="form-group">
									<label for="fname"><?php echo dp($info_holder,"First Name");?></label>
									<div >
										<input type="text" name="fname" class="form-control" placeholder="<?php echo dp($info_holder,"Your First Name");?>" required>
									</div>
								</div>
								<div class="form-group">
									<label for="lname" ><?php echo dp($info_holder,"Last Name")?></label>
									<div >
										<input type="text" name="lname" class="form-control" placeholder="<?php echo dp($info_holder,"Your Last Name");?>">
									</div>
								</div>
								<div class="form-group">
									<label for="emailaddress" ><?php echo dp($info_holder,"Email Address");?></label>
									<div >
										<input type="email" name="emailaddress" class="form-control" placeholder="<?php echo dp($info_holder,"Your email address");?>" required>
									</div>
								</div>
								<div class="form-group">
									<label for="subject" ><?php echo dp($info_holder,"Subject");?></label>
									<div > 
										<select id="subject" name="subject" class="form-control">
											<option value="na"><?php echo dp($info_holder,"Choose One");?>:</option>
											<option value="service" selected="selected"><?php echo dp($info_holder,"General Customer Service");?></option>
											<option value="suggestions"><?php echo dp($info_holder,"Suggestions");?></option>
											<option value="product"><?php echo dp($info_holder,"Product Support")?></option>
											<option value="misuse"  <?php if (isset($_GET['subject'])== true and strtolower($_GET['subject']) =="misuse"){ echo "selected";} ?>><?php echo dp($info_holder,"Misuse")?></option>

										</select>
									</div>
								</div>
							</div>
							<div class="form-group">

								<label for="message" ><?php echo dp($info_holder,"Message");?></label>
								<div >
									<textarea name="message" id="message" class="form-control" rows="10"></textarea>
								</div>
							</div>
							<div class="form-group">

								<div>
									<button type="submit" class="btn btn-u"><?php echo dp($info_holder,"Send");?></button>

								</div>
							</div>
						</div>

						<div id="dycupdate" style="display:none">
							<div style="padding-left:20px;padding-top:5px">
								<img src="<?php echo base_url();?>application/css/images/load.GIF"/>

								<?php echo dp($info_holder,"Please wait while account creation is in progress.");?></div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		var etrace;
		$("#fcontact").submit(function(){
			$("#dycupdate").show();
			$.ajax({url:"contact_us_save",type:"POST",data:$("#fcontact").serialize(),success:function(response) {
				etrace=response;
				$("#dycupdate").hide();
				alert("<?php echo "Thanks for contacting us.we will get back to you as soon as possible."?>");
				window.location.href = "<?php echo base_url();?>";
			},error:function(){
				alert("OOPS, something went wrong");
				$("#dycupdate").hide();
			}});

			return false;

		});

	</script>
