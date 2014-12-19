<?php
$gtotal=0;
function dp(& $info_holderdy,$f)
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
function subs_data(& $pd,& $sd,& $ih)
{
	global $gtotal;
	$total=0;
	$tr="";
	foreach($pd as &$pdata)
	{

		if( $sd['sub_searchprefer'] == "yes" and $pdata->subs_type == "sub_searchprefer")
		{

			$tr .= "<tr><td>".dp($ih,$pdata->subs_details)."</td><td>".$pdata->sub_payment."</td><td>USD</td>";
			$total = $total+$pdata->sub_payment;
		}

		elseif( $sd['sub_allowemails'] == "yes" and $pdata->subs_type == "sub_allowemails")
		{

			$tr .= "<tr><td>".dp($ih,$pdata->subs_details)."</td><td>".$pdata->sub_payment."</td><td>USD</td>";
			$total = $total+$pdata->sub_payment;
		}
		elseif( $sd['sub_onceweekly'] == "yes" and $pdata->subs_type == "sub_onceweekly")
		{

			$tr .= "<tr><td>".dp($ih,$pdata->subs_details)."</td><td>".$pdata->sub_payment."</td><td>USD</td>";
			$total = $total+$pdata->sub_payment;
		}
		elseif( $sd['sub_imageupload'] == "yes" and $pdata->subs_type == "sub_imageupload")
		{

			$tr .= "<tr><td>".dp($ih,$pdata->subs_details)."</td><td>".$pdata->sub_payment."</td><td>USD</td>";
			$total = $total+$pdata->sub_payment;
		}
		elseif( $sd['sub_videoupload'] == "yes" and $pdata->subs_type == "sub_videoupload")
		{
			$tr .= "<tr><td>".dp($ih,$pdata->subs_details)."</td><td>".$pdata->sub_payment."</td><td>USD</td>";
			$total = $total+$pdata->sub_payment;
		}
		elseif( $sd['sub_uniquelink'] == "yes" and $pdata->subs_type == "sub_uniquelink")
		{
			$tr .= "<tr><td>".dp($ih,$pdata->subs_details)."</td><td>".$pdata->sub_payment."</td><td>USD</td>";
			$total = $total+$pdata->sub_payment;
		}
	}
	$tr .="<tr><td>".dp($ih,"Total")."</td><td>&#36; ".$total."</td><td>USD</td></tr>";
	$GLOBALS['gtotal']=$total;
	return $tr;
}
?>
<div id="summaryinfo">

<div class="row">
<div class="col-md-12">
	<table  class="table table-bordered">
		<thead>
			<tr>
				<th>
					<?php echo dp($info_holder,"Subscription Name");?>
				</th>
				<th>
					<?php echo dp($info_holder,"Subscription Cost");?>
				</th>
				<th>
					<?php echo dp($info_holder,"Currency Type");?>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			echo subs_data($pdata,$sdata,$info_holder);
			?>
			<tr>
			<td>
			<h4><?php echo dp($info_holder,"After redemption, you pay only");?> : </h4>
			</td>
			<td>
			<b>&#36; <?php echo $salesPrice; ?></b>
			</td>
			<td>
			USD
			</td>
			</tr>
		</tbody>
	</table>
	</div>
	</div>

	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypalform">
		<input type="hidden" name="cmd" value="_xclick" />
		<input type="hidden" name="business" value="ttlpatrick@singnet.com.sg" />
		<input type="hidden" name="item_name" value="Abrasivesworld Coupon Subscription" />
		<input type="hidden" name="item_number" value="AB-COUPON" />
		<input type="hidden" id="pamount" name="amount" value="<?php  echo $salesPrice;?>" />

		<input type="hidden" name="country" value="<?php echo htmlspecialchars($udata[0]->user_country);?>">
		<input type="hidden" name="first_name" value="<?php echo htmlspecialchars($udata[0]->user_name);?>">
		<input type="hidden" name="address_name" value="<?php echo htmlspecialchars($udata[0]->user_orgname);?>">
		<input type="hidden" name="address_street" value="<?php echo htmlspecialchars($udata[0]->user_orgaddress);?>">
		<input type="hidden" name="email" value="<?php echo htmlspecialchars($udata[0]->user_email);?>">
		<INPUT TYPE="hidden" name="charset" value="utf-8">
			<INPUT TYPE="hidden" name="SOLUTIONTYPE" value="Sole">
				<INPUT TYPE="hidden" name="LANDINGPAGE" value="Billing">

					<input type="hidden" name="no_shipping" value="1" />
					<input type="hidden" name="cn" value="Abrasiveworld Subscription" />
					<input type="hidden" name="currency_code" value="USD" />
					<input type='hidden' name='rm' value='2'>
					<input type='hidden' name='custom' value='<?php echo htmlspecialchars($subm)."ZZ".$udata[0]->recordno."ZZ".$couponCode; ?>'>
					<input type="hidden" name="return" value="<?php echo base_url();?>payment/payment_auth"/>
					<input name="notify_url" value="<?php echo base_url();?>payment/payment_update" type="hidden">
					<input type="submit" style="display:none" id="paypalsubmit"/>
				</form>

			</div>