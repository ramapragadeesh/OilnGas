<?php
function dp($info_holderdy,$f)
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
<div id="main_container" class="main_container">
<div> 
<div class="header_text">
<span>
<strong><?php echo dp($info_holder,"Abrasivesworld Account Activation");?></strong>
</span> 
</div>
</div> 
<div>
	<div style="padding-left:30px;padding-right:30px;padding-top:20px;font-size:14px;line-height:20px">
	<form id="fcontact" method="get" action="<?php echo base_url();?>account/activate_account">
	  <div>
			<div>
				<label><?php echo dp($info_holder,"Activation ID");?></label>
				<input type="text" id="activation_id" name="activation_id" class="span3" placeholder="<?php echo dp($info_holder,"Your activation id");?>" required>				
				
			</div>
			
			<button type="submit" class="btn btn-primary"><?php echo dp($info_holder,"Verify");?></button>
		</div>
		
		
	</form>
	</div>
	</div>
</div>
<script>
var isv=<?php echo $isval;?>;
if (isv==1)
{
alert("<?php echo dp($info_holder,"Your Activation ID is validated.");?>");
location="<?php echo base_url();?>account/my_profile";
}
else
{
alert("<?php echo dp($info_holder,"Please check your activation id,it seems invalid");?>");
}
</script>