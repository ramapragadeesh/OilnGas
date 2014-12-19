<?php
$guserselect=0;
$abfuserselect=0;
$acfuserselect=0;
function user_pictures($ar)
{
	$r="<table><tr>";
	$rc=0;
	$de=0;
	foreach($ar as &$value)
	{
		$rc=$rc+1;
		$de=1;
		if ($rc==3)
		{
			$r .='</tr><tr><td>
			<img src="'.$value->pic_url.'" style="width:300px;height:200px"/>
		</td>';
		$rc=1;
	}
	else
	{
		$r .='<td>
		<img src="'.$value->pic_url.'" style="width:300px;height:200px"/>
	</td>';
}

}
if ($de==1)
{
	return $r."</tr></table>";
}
else
{
	return "";
}
}
function free_modules(& $av,$module,$y=0)
{
	foreach($av as &$fus)
	{
		$e=explode(":",$fus->modules);
		foreach($e as &$value)
		{
			if ($value==$module)
			{
				if ($y==1)
				{
					return "<i class='icon-ok'></i>";		
				}
				else
				{
					return "checked";		
				}
			}
			
		}

	}

}
function subs_check(& $sus,$isv,$c,$y=0)
{
	if ($isv==true and $sus[0]->paypal_validated == 1)
	{

		$e=explode(":",$sus[0]->subs_module);
		foreach($e as &$value)
		{
			
			if ($value==$c)
			{
				if ($y==1)
				{
					return "<i class='icon-ok'></i>";
				}
				else
				{
					return "disabled";
				}
			}
		}
	}
	else
	{
	}

}
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


function is_sel_user($arr1,$arr2,$v)
{
//echo $arr1." - ".$v;
	$r="";
	$ds=$arr1.$arr2;
	$arre=explode(";",$ds);
	for($i=0;$i<count($arre);$i++)
	{

		if ($arre[$i]==$v)
		{
			$r="checked";
		}
	}
	return $r;

}
function getuinfo(& $inf,& $inh,$utype,$mms,$sms,$ot1,$ot2)
{

	$utypeo="";
	$ot="";

	$utypeo1=$utype."FO";
	$utypeo2=$utype."SO";

	$utype1=$utype."F[]";
	$utype2=$utype."S[]";

	$st='<table><tr style="line-height:10px"><td colspan="2"><h4>'.dp($inh,"").'</h4></td>
</tr>';
$st='<table>';
$stt="";
$iss="";
$op=false;
$optext="";
$utype=$utype1;
$utypeo=$utypeo1;
$ot=$ot1;

$f=0;
foreach ($inf as &$value) 
{
	if ($value->option !=  $iss)
	{
		if ($op==true)
		{
			if (is_ch($ot) == "checked" )
			{
				$stt .='<tr style="line-height:30px"> <td style="width:5%"> <span> &#10004; </span>'.$optext.'</td><td>'.$ot.'</td></tr>
				';
			}
		}
		$stt .= '<tr style="line-height:10px"><td colspan="2"><h5>'.dp($inh,$value->description).'</h5></td></tr>';
		if ($f==0)
		{
			$utype=$utype1;
			$utypeo=$utypeo1;
			$ot=$ot1;
			$f=$f+1;
		}
		else
		{
			$utype=$utype2;
			$utypeo=$utypeo2;
			$ot=$ot2;
		}
		$iss=$value->option;
		$op=false;
	}
	if (strtolower($value->show_dropdown) == "others, please specify")
	{
		$op=true;
//$optext=dp($inh,$value->show_dropdown);
		$optext="";
	}
	else
	{
		if (is_sel_user($mms,$sms,$value->recordno)=="checked")
		{
			$stt .='<tr style="line-height:30px"><td style="width:5%"> <span> &#10004; </span></td><td>'.dp($inh,$value->show_dropdown).'</td></tr>';
		}
	}
}
if ($op==true)
{
	if (is_ch($ot)=="checked")
	{
		$stt .='<tr style="line-height:30px"><td style="width:5%"> <span> &#10004; </span></td><td> <span> '.$ot.' </span></td></tr>
		';
	}
}
if ($stt=="")
{
	return "";
}		
return $st.$stt."</table>";		 
}

function is_ch($v)
{
	if ($v != "")
	{
		return "checked";
	}

}
function getabf_text($i,$id)
{
	$ide1=explode(";",$id);

	$ide=explode("`",$ide1[$i-1]);

	return $ide[0];
}

function getabf_selection($i,$id,$sv)
{
	$ide1=explode(";",$id);
	$ide=explode("`",$ide1[$i-1]);

	if ($sv==$ide[1])
	{
		return $sv;
	}
	else
	{
		return "";
	}
}

function getabf_isvalue($i,$id)
{
	$ide1=explode(";",$id);
	$ide=explode("`",$ide1[$i-1]);

	if ($ide[0] != "")
	{
		return "checked";
	}
}

function getabf(& $inf,& $inh,$fs,$tv,$sv,$daf)
{
	$stt="<table>";
	$i=0;
	$isdata=0;
	foreach ($inf as &$value) 
	{

		$i=$i+1;
		$na=$tv.$i;
		$sa=$sv.$i;
		if (getabf_isvalue($i,$daf)=="checked")
		{
			$isdata=1;
			$stt .='
			<tr style="line-height:30px"><td style="width:5%"><span> &#10004; </span></td><td><span>'.dp($inh,$value->show_dropdown).'</span></td></tr><tr  style="line-height:30px"><td></td><td><span style="padding-left:30px"><b>'.dp($inh,"Annual Output",$fs).' :</b> '.getabf_text($i,$daf).'</span> <span>'.getabf_selection($i,$daf,"m2").' '.getabf_selection($i,$daf,"pcs").' '.getabf_selection($i,$daf,"ltr").''.getabf_selection($i,$daf,"kg").'</span></td></tr>';
		}
	}
	if ($stt == "")
	{
		return "";
	}
	if ($isdata==1)
	{		
		return $stt."</table>";
	}
	else
	{
		return "";
	}
}
function secondaryprim_match($ei,$si)
{
	$r="";
	$eiv=explode(";",$ei);

	for($i=0;$i<count($eiv);$i++)
	{
		if ($si==$eiv[$i])
		{
			return "checked";
		}
	}

}
function getsecondaryprim(& $inf,& $inh,$fs,$nv="",$psv,$otv="")
{
	$ovo=$nv."O";
	$nv=$nv."[]";

	$stt="";
	$op=false;
	$optext="";
	$de=0;
	foreach ($inf as &$value) 
	{
		$de=1;
		if (strtolower($value->show_dropdown) == "others, please specify")
		{
			$op=true;
			$optext=dp($inh,$value->show_dropdown);
		}
		else
		{
			if (secondaryprim_match($psv,$value->id_text)=="checked")
			{
				$stt .='<tr style="line-height:30px"><td width="5%">
				<span> &#10004; </span> </td> <td> <span> '.dp($inh,$value->show_dropdown).'
			</span></td></tr>
			';
		}
	}
}		if ($op==true)
{
	if (is_ch($otv)=="checked")
	{
		$stt .='<tr style="line-height:30px"><td width="5%"> <span> &#10004; </span></td><td> <span>'.$otv.'</span></td></tr>';
	}
}

if ($stt == "")
{
	return "";
}
return "<table>".$stt."</table>";
}


function uoda_process(& $uod)
{
	foreach($uod as &$value)
	{
		if ($value->selection == 'G')
		{
			return $value->selection_text;
		}
	}
}
function uodd_process(& $uod,$vdp,$rt)
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
		return "checked";
	}
	else
	{
		return $f;
	}

}

function ab_si($ei,$ci)
{
	$r="";
	$eie=explode(";",$ei);
	for($i=0;$i<count($eie); $i++)
	{
		if ($eie[$i] == $ci)
		{
			$r="checked";
		}
	}
	return $r;
}
function abcoated_users(& $abuserl, & $hc,$si,$otn="",$otv="")
{
	$isdata=0;
	$divg="<table>";
	foreach ($abuserl as &$value) 
	{

		if ($value->au_category=="Others, please specify")
		{

			if (ab_si($si,$value->au_id) == "checked")
			{
				$isdata=1;
				$divg .='<tr style="line-height:30px"><td style="width:5%"><span> &#10004; </span></td><td><span>
				'.$otv.'</span></td></tr>';
			}
		}
		else
		{
			if (ab_si($si,$value->au_id) == "checked")
			{
				$isdata=1;
				$divg .='<tr style="line-height:30px"><td style="width:5%"><span> &#10004; </span></td><td><span>'.dp($hc,$value->au_category).'</span></td></tr>';
			}
		}
	}
	$divg .= "</table>";
	if ($isdata==1)
	{
		return $divg;
	}
	else
	{
		return "";
	}
}
function abbonded_users(& $abuserl, & $hc,$si,$otn="",$otv="")
{
	$isdata=0;
	$divg="<table>";
	foreach ($abuserl as &$value) 
	{

		if ($value->au_category=="Others, please specify")
		{
			if (ab_si($si,$value->au_id) == "checked")
			{
				$isdata=1;
				$divg .='<tr style="line-height:30px"><td style="width:5%"><span> &#10004; </span></td><td><span>'.$otv.'</span></td></tr>';
			}
		}
		else
		{
			if ( ab_si($si,$value->au_id) == "checked")
			{
				$isdata=1;
				$divg .='<tr style="line-height:30px"><td style="width:5%"><span> &#10004; </span></td><td><span>'.dp($hc,$value->au_category).'</span></td></tr>';
			}
		}
	}
	$divg .= "</table>";
	if ($isdata == 1)
	{
		return $divg;
	}
	else
	{
		return "";
	}
}
function abusers_match($ei,$ci)
{
	$eiv = explode(";",$ei);

	for($i=0;$i<count($eiv);$i++)
	{
		if ($eiv[$i]==$ci)
		{
			return "checked";
		}
	}

}
function ab_users(& $abuserl, & $hc,$us="",$oto="")
{

	$divg="";
	foreach ($abuserl as &$value) 
	{
		if ($value->au_category=="Others, please specify")
		{
			$divg .="<div> ".$oto." </div>";

		}
		else
		{
			if (abusers_match($us,$value->au_id)=="checked")
			{
				$divg .="<div> <span> &#10004; </span> "." ".dp($hc,$value->au_category).' </div>';
			}
		}
	}
	$divg .= "";
	return $divg;
}
?>
<?php
$tn=explode("-",$adu[0]->user_contactno);
?>
<div  class="container">

<div class="panel panel-default">
  <div class="panel-heading">
    <?php echo dp($info_holder,"Company fact sheet");?>
     </div>
  <div class="panel-body">


	<div style="margin-left:20px;margin-top:10px">
		<b><?php echo dp($info_holder,"Company profile of ");?><?php echo $adu[0]->user_orgname; ?></b>
	</div>
	<div style="margin-left:40px">    
		<table>
			<tr>
				<td>
					<?php
					if ($adu[0]->user_comppic !="")
					{
						echo '<img  src="'.$adu[0]->user_comppic.'" />';
					}
					?>
				</td>
			</tr>
		</table>
		<table>
			<tr style="line-height:30px">
				<td style="width:35%;">
					<b><?php echo dp($info_holder,"Organization Name");?></b>
				</td>
				<td>
					<?php echo htmlentities($adu[0]->user_orgname,ENT_COMPAT, 'UTF-8');?>
				</td>
			</tr>
			
			<tr style="line-height:30px">
				<td>
					<b><?php echo dp($info_holder,"Address Of Registration");?></b>
				</td>
				<td>
					<?php echo htmlentities($adu[0]->user_orgaddress,ENT_COMPAT, 'UTF-8');?>
				</td>
			</tr>
			
			
			<tr style="line-height:30px">
				<td>
					<b><?php echo dp($info_holder,"Country");?></b>
				</td>
				
				<td>
					<?php echo htmlentities($adu[0]->user_country);?>
				</td>
			</tr>
			
			
			<tr style="line-height:30px">
				<td>
					<b><?php echo dp($info_holder,"Name");?></b>
				</td>
				
				<td>
					<?php echo htmlentities($adu[0]->user_name,ENT_COMPAT, 'UTF-8');?>
				</td>
			</tr>
			
			<?php
			if ($adu[0]->user_position != "")
			{
				?>
				<tr style="line-height:30px">
					<td>
						<b> <?php echo dp($info_holder,"Position");?></b>
					</td>		 
					<td>
						<?php echo htmlentities($adu[0]->user_position,ENT_COMPAT, 'UTF-8');?>
					</td>		 
				</tr>
				<?php
			}
			?>		 
		 
			<?php
			if ($adu[0]->user_webaddress != "")
			{
				?>
				<tr style="line-height:30px">
					<td>
						<b><?php echo dp($info_holder,"Company Website");?></b>
					</td>
					
					<td>
						<?php echo htmlentities($adu[0]->user_webaddress,ENT_COMPAT, 'UTF-8');?>
						
					</td>
				</tr>
				<?php
			}
			?>
			<tr style="line-height:30px">
				<td>
					<b><?php echo dp($info_holder,"Contact Number");?></b>
				</td>		 
				<td>
					<?php echo dp($info_holder,"Country Code");?> : 
					<?php echo htmlentities($tn[0]);?>
					<?php echo dp($info_holder,"Area Code");?>-<?php echo htmlentities($tn[1]);?>		 
					<?php echo dp($info_holder,"Telephone Number");?>-<?php echo htmlentities($tn[2]);?>		
				</td>		 
			</tr>		
			<tr style="line-height:30px">
				<td>
					<b><?php echo dp($info_holder,"Location");?></b>
				</td>
				<td>
					<?php if ($adu[0]->user_location_gmap == ""){ echo htmlentities( $adu[0]->user_orgaddress,ENT_COMPAT, 'UTF-8').", ".$adu[0]->user_country;} else{ echo htmlentities( $adu[0]->user_location_gmap,ENT_COMPAT, 'UTF-8');} ?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<?php
					if (strlen($adu[0]->user_location ) >= 5)
					{
						echo '<img src="http://maps.googleapis.com/maps/api/staticmap?center='.$adu[0]->user_location.'&zoom=16&size=400x200&sensor=false" />';
					}
					else
					{
					}
					?>	
				</td>		 
			</tr>
		</table>
		
		<?php if (uodd_process($uodd,'A',0)=="checked")
		{
			$hd="";
			$guserselect=1;
			if ($fs=="F")
			{
				$hd="<h4>".$adu[0]->user_orgname.dp($info_holder," is a end user" )."</h4>";
			}
			else
			{
				$hd="<h4>".$adu[0]->user_orgname.dp($info_holder," Main Focus" )."</h4>";
			}		
			echo $hd.'<table style="margin-top:10px">';
			?>
			
			
			<tr style="line-height:30px">
				<td style="width:5%"> <span> &#10004;  </span> </td>	
				<td>
					<?php echo dp($info_holder,"Machine / Equipment  Supplier");?>
				</td>		
			</tr>
			<?php } ?>
			<?php if (uodd_process($uodd,'B',0)=="checked")
			{
				$hd="";
				if ($guserselect==0)
				{
					if ($fs=="F")
					{
						$hd="<h4>".$adu[0]->user_orgname.dp($info_holder," is a end user" )."</h4>";
					}
					else
					{
						$hd="<h4>".$adu[0]->user_orgname.dp($info_holder," Main Focus" )."</h4>";
					}		
					echo $hd.'<table style="margin-top:10px">';
					$guserselect=1;
				}
				?>
				<tr style="line-height:30px">
					<td style="width:5%"> <span> &#10004;  </span> </td>		
					<td><span><?php echo trim(dp($info_holder,"Raw Material Supplier"));?></span>
					</td>
				</tr>
				<?php } ?>
				<?php if (uodd_process($uodd,'C',0)=="checked")
				{
					if ($guserselect==0)
					{
						$hd="";
						if ($fs=="F")
						{
							$hd="<h4>".$adu[0]->user_orgname.dp($info_holder," is a end user" )."</h4>";
						}
						else
						{
							$hd="<h4>".$adu[0]->user_orgname.dp($info_holder," Main Focus" )."</h4>";
						}
						echo $hd.'<table style="margin-top:10px">';
						$guserselect=1;
					}
					?>
					<tr style="line-height:30px">
						<td style="width:5%"> <span> &#10004;  </span> </td>		
						<td><span><?php echo trim(dp($info_holder,"Abrasive Producer (Bonded,Coated)"));?></span>
						</td>		
					</tr>
					<?php } ?>		
					<?php if (uodd_process($uodd,'D',0)=="checked")
					{
						if ($guserselect==0)
						{
							$hd="";
							if ($fs=="F")
							{
								$hd="<h4>".$adu[0]->user_orgname.dp($info_holder," is a end user" )."</h4>";
							}
							else
							{
								$hd="<h4>".$adu[0]->user_orgname.dp($info_holder," Main Focus" )."</h4>";
							}
							echo $hd.'<table style="margin-top:10px">';
							$guserselect=1;
						}
						?>
						<tr style="line-height:30px">
							<td style="width:5%"> <span> &#10004;  </span> </td>		
							<td><span><?php echo trim(dp($info_holder,"Coated Abrasive Converter"));?></span>
							</td>		
						</tr><?php } ?>		
						<?php if (uodd_process($uodd,'E',0)=="checked")
						{
							if ($guserselect==0)
							{
								echo '<table style="margin-top:10px">';
								$guserselect=1;
							}
							?><tr style="line-height:30px">
							<td style="width:5%"><span> &#10004; </span> </td><td> <span> <?php echo trim(dp($info_holder,"Distributor( Bonded or Coated Abrasive)"));?> </span></td></tr>
							<?php } ?>		
							<?php if (uodd_process($uodd,'F',0)=="checked")
							{
								if ($guserselect==0)
								{
									$hd="";
									if ($fs=="F")
									{
										$hd="<h4>".$adu[0]->user_orgname.dp($info_holder," is a end user" )."</h4>";
									}
									else
									{
										$hd="<h4>".$adu[0]->user_orgname.dp($info_holder," Main Focus" )."</h4>";
									}		
									echo $hd.' <table style="margin-top:10px"><tr><td colspan="2">
									';
									$guserselect=1;
								}
								?>
								<?php 
								if (uodd_process($uodd,'F',0) == "checked" )
								{
									echo ab_users($abuser,$info_holder,$adu[0]->absm,$adu[0]->absmo);		
								}
								else
								{
									echo ab_users($abuser,$info_holder,"","");
								}
								?>
							</td>
						</tr>
						<?php 
					} 
					?>
					
					<?php if (uodd_process($uodd,'G',0)=="checked")
					{
						$hd="";
						if ($guserselect==0)
						{
							if ($fs=="F")
								
								$hd="<h4>".$adu[0]->user_orgname.dp($info_holder," is a end user" )."</h4>";
						}
						else
						{
							$hd="<h4>".$adu[0]->user_orgname.dp($info_holder," Main Focus" )."</h4>";
						}		
						echo $hd.'<table style="margin-top:10px">';
						$guserselect=1;
						
						?>
						<tr style="line-height:30px">
							<td style="width:5%"> <span> &#10004; </span> </td>		
							<td><span><?php echo dp($info_holder,"");?><?php echo htmlentities(uoda_process($uodd));?></span>
							</td>
						</tr>
						<?php } ?>	
						<?php 
						if ($guserselect==1)
						{
							echo  "</table>";
						}
						?>
						
						<h4>1) <?php echo $adu[0]->user_orgname;?><?php echo dp($info_holder," focuses on Bonded Abrasives");?></h4>
<?php 
echo getuinfo($user_selection,$info_holder,"BMMS",$adu[0]->bmms,$adu[0]->brms,$adu[0]->bmmso,$adu[0]->brmso);
?>
<h5><?php echo dp($info_holder,"Type of abrasive focus");?></h5>
<?php 
echo getabf($user_abfb,$info_holder,$fs,"BUDT","BUDS",$adu[0]->baf);
?>

<?php

if ( $adu[0]->bcp != "")
{
	if ( $abfuserselect==0)
	{
		echo '<table style="margin-top:10px">';
		$abfuserselect=1;
	}

	?>
	<tr style="line-height:30px">
		<td style="width:25%">
			<span><b><?php echo dp($info_holder,"Country of production");?></b></span>
		</td>
		<td>
			<span><?php echo $adu[0]->bcp;?></span>
		</td>
	</tr>
	<?php
}
?>
<?php 
if ($adu[0]->bbp != "")
{
	if ( $abfuserselect=0)
	{
		echo '<table style="margin-top:10px">';
		$abfuserselect=1;
	}
	?>
	<tr  style="line-height:30px">
		<td  style="width:25%">
			<span><b><?php echo dp($info_holder,"Brand of product");?></b></span>
		</td>
		<td>
			<span><?php echo $adu[0]->bbp;?></span>
		</td>
	</tr>
	<?php
}
?>
<?php 
if ($adu[0]->bbp != "")
{
	if ( $abfuserselect=0)
	{
		echo '<table style="margin-top:10px">';
		$abfuserselect=1;
	}
	?>
	<tr  style="line-height:30px">
		<td  style="width:25%">
			<span><b><?php echo dp($info_holder,"Brand of product");?></b></span>
		</td>
		<td>
			<span><?php echo $adu[0]->bbp;?></span>
		</td>
	</tr>
	<?php
}
?>

<?php 
if ($adu[0]->bmc != "")
{
	if ( $abfuserselect=0)
	{
		echo '<table style="margin-top:10px">';
		$abfuserselect=1;
	}
	?>
	<tr  style="line-height:30px">
		<td  style="width:45%">
			<span><b><?php echo dp($info_holder,"Market of interest by country");?></b></span>
		</td>
		<td>
			<span><?php echo $adu[0]->bmc;?></span>
		</td>
	</tr>
	<?php
}
?>
<?php
if ( $abfuserselect=0)
{
	echo '</table>';
	$abfuserselect=1;
}

?>

<table>
	<tr>
		<td>
			<b><?php if ($fs=="F"){echo dp($info_holder,"");}else{echo dp($info_holder,"Market of interest by industry");}?></b>
		</td>
	</tr>
</table>			
<?php
if ($fs!="F")
{
	echo abbonded_users($abuser,$info_holder,$adu[0]->bmi,"BSELI",$adu[0]->bseli);
}
?>


<table style="margin-top:10px">
	<tr style="line-height:30px">
		<td>
			<?php
			if ($adu[0]->bonded_desc != "" )
			{
				echo "<b>".dp($info_holder,"Description")."</b>";
			}
			?>
		</td>
	</tr>
	<tr>
		<td>
			<div>
				<?php echo htmlentities($adu[0]->bonded_desc,ENT_COMPAT, 'UTF-8');?>
			</div>
		</td>
	</tr>
</table>

<?php echo user_pictures($upbond);?>	
<h4>2) <?php echo $adu[0]->user_orgname." ";?><?php echo dp($info_holder,"focuses on Coated Abrasives");?></h4>
<?php
echo getuinfo($user_selectionc,$info_holder,"CMMS",$adu[0]->cmms,$adu[0]->crms,$adu[0]->cmmso,$adu[0]->crmso);
?>
<h5><?php echo dp($info_holder,"Type of abrasive focus");?></h5>
<?php echo getabf($user_abfc,$info_holder,$fs,"CUDT","CUDS",$adu[0]->caf);?>
<h5><?php echo dp($info_holder,"Forms of abrasives");?></h5>
<div><b><?php echo dp($info_holder,"Level 1 (Primary Value)");?></b></div>
<?php echo getsecondaryprim($user_udhapri,$info_holder,$fs,"CPLA",$adu[0]->pla,$adu[0]->plat);?>
<div><b><?php echo dp($info_holder,"Secondary Level");?></b></div>	 
<?php echo getsecondaryprim($user_udhasec,$info_holder,$fs,"CSLA",$adu[0]->sla,$adu[0]->slat);?>

<?php
if ( $adu[0]->ccp != "")
{
	if ($acfuserselect ==0)
	{
		echo "<table>";
		$acfuserselect=1;
	}
	?>
	<tr style="line-height:30px">
		<td>
			<?php echo dp($info_holder,"Country of production");?>
		</td>
		<td>
			<?php echo $adu[0]->ccp;?>
		</td>
		
	</tr>
	<?php
}
?>
<?php
if ( $adu[0]->cbp != "")
{
	
	if ($acfuserselect ==0)
	{
		echo "<table>";
		$acfuserselect=1;
	}
	?>
	<tr style="line-height:30px">
		<td>
			<?php echo dp($info_holder,"Brand of product");?>
		</td>
		<td>
			<?php echo $adu[0]->cbp;?>
		</td>
		
	</tr>
	<?php
}
?>

<?php
if ( $adu[0]->cmc != "")
{
	
	if ($acfuserselect ==0)
	{
		echo "<table>";
		$acfuserselect=1;
	}
	?>
	<tr style="line-height:30px">
		<td>
			<?php echo dp($info_holder,"Market of interest by country");?>
		</td>
		<td>
			<?php echo $adu[0]->cmc;?>
		</td>
		
	</tr>
	<?php
}
?>	
<?php

if ($acfuserselect ==1)
{
	echo "</table>";
	$acfuserselect=1;
}
?>

<table>
	<tr>
		<td>
			<b><?php if ($fs=="F"){echo dp($info_holder,"What are the industries you are interested?");}else{echo dp($info_holder,"Market of interest by industry");}?></b>
		</td>
	</tr>
</table>
<?php
if ($fs!="F")
{
	echo abcoated_users($abuser,$info_holder,$adu[0]->cmi,"CSELI",$adu[0]->cseli);
}
?>			
<table>
	<tr>
		<td>
			
			<?php
			if ($adu[0]->coated_desc != "" )
			{
				echo "<b>".dp($info_holder,"Description")."</b>";
			}
			?>
		</td>
	</tr>
	<tr>
		<td>
			<div>
				<?php echo htmlentities($adu[0]->coated_desc,ENT_COMPAT, 'UTF-8');?>
			</div>
		</td>
	</tr>
</table>
<?php echo user_pictures($upcoat);?>
<?php	if (isset($ishtml)) 
{
	?>

	<div style="margin-top:20px" >
		<b> <?php echo dp($info_holder,"Abrasivesworld Public Profile QR Code");?> </b>
		<div>
			<img src="<?php echo $user_qrc;?>" />
		</div>
	</div>
	
 
	<?php
}
?>	
</div>
</div>
</div>