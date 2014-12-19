<?php
function dp(& $info_holderdy,$f,$fsl="")
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
return htmlentities($rt,ENT_COMPAT, 'UTF-8');
}

function uodd_process(& $uod,$vdp,$rt,$text)
{
$f="";
foreach($uod as &$value)
{
if ($rt==1 and $value->selection == $vdp)
{
$f= $value->selection_text;
break;
}
elseif ($value->selection == $vdp)
{
$f=true;
break;
}
}
if ($f==true)
{
return "<tr style='width:100%'><td style='min-width:200px'><span><img src='".base_url()."/application/img/tick.png'"."/></span> <b>".htmlentities($text,ENT_COMPAT, 'UTF-8')."</b></td></tr>";
}
else
{
return "";
}
}

function ab_users(& $abuserl, & $hc)
{
$divg="<div>";
foreach ($abuserl as &$value) 
{
 
 $divg .='<label class="checkbox description_check">
            <input type="checkbox" value="'.$value->au_id.'" id="ABL" name="ABL[]"> '.dp($hc,$value->au_category).'
        </label>'
		;
}
$divg .= "</div>";
return $divg;
}

function uoda_process(& $uod)
{
foreach($uod as &$value)
{
if ($value->selection == 'G')
{
return htmlentities($value->selection_text,ENT_COMPAT, 'UTF-8');
}
}
}
?>

<?php
$tn=explode("-",$adu[0]->user_contactno);
?>
<html>
<head>
<meta charset="utf-8" />
</head>

<body>
<div style="height:80px;background-color:rgb(158, 31, 99)">
<img src="<?php echo base_url();?>/application/img/AB.png" />
</div>
<br/>
<br/>
<div id="main_container" class="main_container" style="min-height:700px">
<div>    

</div>

<div id="maincon">
<!--Content Start -->

<div style=";border:1px solid whitesmoke">
<div style="background-color:whitesmoke;text-align:center">
 <b style="color:orange"><?php echo dp($info_holder,"Abraisvesworld  Profile :");?> <?php echo htmlentities($adu[0]->user_orgname);?>
</b>
</div>

<table style="width:100%;margin-top:10px">
<?php echo uodd_process($uodd,'A',0,dp($info_holder,"Machine / Equipment  Supplier"));?>
<?php echo uodd_process($uodd,'B',0,dp($info_holder,"Raw Material Supplier"));?>
<?php echo uodd_process($uodd,'C',0,dp($info_holder,"Abrasive Producer (Bonded,Coated)"));?>
<?php echo uodd_process($uodd,'D',0,dp($info_holder,"Coated Abrasive Converter"));?>
<?php echo uodd_process($uodd,'E',0,dp($info_holder,"Distributor( Bonded or Coated Abrasive)"));?>
<?php echo uodd_process($uodd,'F',0,dp($info_holder,"Abrasive Users"));?>
<?php echo htmlentities(uoda_process($uodd));?>


<tr style="padding-top:10px">
<td>
<div><img style="width:100px;height:100px"src="<?php if ($adu[0]->user_comppic !="") {echo $adu[0]->user_comppic;}else{ echo "http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image";}?>" /></div>
</td>
<td>
</td>
</tr>

<tr style="padding-top:10px">
<td>
<b>
<?php echo dp($info_holder,"Organization Name");?>
</b>
</td>
<td>
<?php echo htmlentities($adu[0]->user_orgname,ENT_COMPAT, 'UTF-8');?>
</td>
</tr>

<tr style="padding-top:10px">
<td>
<b>
<?php echo dp($info_holder,"Address Of Registration");?>
</b>
</td>
<td>
<?php echo htmlentities($adu[0]->user_orgaddress,ENT_COMPAT, 'UTF-8');?>
</td>
</tr>

<tr style="padding-top:10px">
<td>
<b>
<?php echo dp($info_holder,"Country");?>
</b>
</td>
<td>
<?php echo htmlentities($adu[0]->user_country,ENT_COMPAT, 'UTF-8');?>
</td>
</tr>

<tr style="padding-top:10px">
<td>
<b>
<?php echo dp($info_holder,"Preferred Language");?>
</b>
</td>
<td>
<?php 
if($adu[0]->user_language == "en")
{
echo dp($info_holder,"English");
}
elseif($adu[0]->user_language == "zh-cn")
{
 echo dp($info_holder,"Chinese");
}
else
{
echo dp($info_holder,"English");
}
?>
</td>
</tr>


<tr style="padding-top:10px">
<td>
<b>
<?php echo dp($info_holder,"Email");?>
</b>
</td>
<td>
<?php echo htmlentities($adu[0]->user_email,ENT_COMPAT, 'UTF-8');?>
</td>
</tr>

<tr style="padding-top:10px">
<td>
<b>
<?php echo dp($info_holder,"Company Website",ENT_COMPAT, 'UTF-8');?>
</b>
</td>
<td>
<?php echo htmlentities($adu[0]->user_webaddress,ENT_COMPAT, 'UTF-8');?>
</td>
</tr>


<tr style="padding-top:10px">
<td>
<b>
<?php echo dp($info_holder,"Contact Number");?>
</b>
</td>
<td>
 <span>
		  <?php echo dp($info_holder,"Country Code");?>
		  </span>
		  <b><?php echo htmlentities($tn[0]);?></b>
		  <span>
		  <?php echo dp($info_holder,"Area Code");?>
		   </span>
		  <b><?php echo htmlentities($tn[1]);?></b>
		  <span>
		  <?php echo dp($info_holder,"Telephone Number");?>
		  <b><?php echo htmlentities($tn[2]);?></b>
		   </span>
</td>
</tr>
</table>
</div>
</div>
</div>
</body>
</html>

