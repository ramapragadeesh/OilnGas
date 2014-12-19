<?php
function build_group_selection(& $data, & $ih,$ps)
{
	$sel="";
	foreach($data as $row)
	{
		if ($row['uselectiontext']=="Others, please specify")
		{
			$sel .= '<input style="margin:0px 0px 0px 0px" type="checkbox" name="artgroup[]" value="'.dp($ih,$row['uselection']).'" '.is_selected($ps,$row['uselection']).'> <span>'.dp($ih,'Others not listed above').'</span><br/>';
		}
		else
		{
			$sel .= '<input style="margin:0px 0px 0px 0px" type="checkbox" name="artgroup[]" value="'.dp($ih,$row['uselection']).'" '.is_selected($ps,$row['uselection']).'> <span>'.dp($ih,$row['uselectiontext']).'</span><br/>';

		}
	}
	$sel .="";
	return $sel;
}

function list_rfqmain(& $rfqlist)
{
	$r="";
	foreach($rfqlist as &$v)
	{
		$r .="<tr>";
		$r .="<td><span>".$v->rfq_id."</span></td>";
		$r .="<td><span>".$v->rfq_no."</span></td>";
		$r .="<td><span>".$v->rfq_title."</span></td>";
		$r .="<td><span>".$v->rfq_issue_date."</span></td>";
		$r .="<td><span>".$v->rfq_close_date."</span></td>";
		$r .="<td><span>".$v->rfq_pref_currency."</span></td>";
		$r .="<td><span>".$v->rfq_active."</span></td>";
		$r .='<td>
		<button type="button" class="btn btn-default btn-circle"><i class="icon-info-sign"></i></button>
		<button type="button" class="btn btn-primary btn-circle"><i class="icon-edit"></i></button>
		<button type="button" class="btn btn-success btn-circle"><i class="icon-remove-circle"></i></button>
	</td>';
//$r .="<td><span>".'<i class="icon-info-sign" alt="More Information"> </i> &nbsp;&nbsp; <i class="icon-edit"></i> &nbsp;&nbsp;<i class="icon-remove-circle"> </i>'."</span></td>";
	$r .="</tr>";
}
return $r;
}
function GUID()
{

	if (function_exists('com_create_guid') === true)
	{
		return trim(com_create_guid(), '{}');
	}

	return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}
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
?>
<div class="container" style="background:whitesmoke">
	<div class="row nav-row" style="margin-top:10px">
		<div class="col-md-3">
			<div><span class="glyphicon glyphicon-user"></span> <a style="color:#3A3434;padding-left:5px" href="<?php echo base_url();?>account/my_profile"><?php echo dp($info_holder,"Edit my profile");?></a></div>
		</div>
		<div class="col-md-3">
			<div><span class="glyphicon glyphicon-lock"></span> <a style="color:#3A3434;padding-left:5px" href="<?php echo base_url();?>account/change_password"><?php echo dp($info_holder,"Change password");?></a></div>
		</div>
		<div class="col-md-3">
			<div><span class="glyphicon glyphicon-folder-close"></span> <a style="color:#3A3434;padding-left:5px" href="<?php echo base_url();?>my_article"><?php echo dp($info_holder,"Article Management System");?></a></div>
		</div>
		<div class="col-md-3 active">
			<div><span class="glyphicon glyphicon-folder-close"></span> <a style="color:#3A3434;padding-left:5px" href="<?php echo base_url();?>rfq"><?php echo dp($info_holder,"Request for quotation");?></a></div>
		</div>
	</div>


	<div  style="margin-top:10px;"> 
		<div class="row nav-row">
			<div class="col-md-3 col-md-offset-3" style="text-align:center">
				<div style="padding-top:5px;padding-bottom:5px;">          
					<a style="font-weight:100" href="<?php echo base_url();?>rfq"><i class="fa fa-pencil fa-fw"></i><?php echo dp($info_holder,"Create a new RFQ");?></a>
				</div>
			</div>
			<div class="col-md-3">
				<div style="padding-top:5px;padding-bottom:5px;text-align:center;">
					<a style="font-weight:100" href="<?php echo base_url();?>rfq/rfq_manage"><i class="fa fa-book fa-fw"></i><?php echo dp($info_holder,"Manage my RFQ");?></a>
				</div>
			</div>
		</div>
	</div>

	<div id="mainFormRFQ">
		<div id="rfqLabel">
		<h2 style="font-weight:100"><?php echo dp($info_holder,"Edit RFQ");?></h2>
		</div>
	</div>



</div>

<div id="main_container" class="main_container">
						<table class="table" style="width:100%" id="rfqtable" >
							<thead>
								<tr>
									<th>
										<?php echo dp($info_holder,"RFQ ID");?>
									</th>
									<th>
										<?php echo dp($info_holder,"RFQ No");?>
									</th>

									<th>
										<?php echo dp($info_holder,"RFQ Title");?>
									</th>
									<th>
										<?php echo dp($info_holder,"RFQ Issue Date");?>
									</th>
									<th>
										<?php echo dp($info_holder,"RFQ Close Date");?>
									</th>

									<th>
										<?php echo dp($info_holder,"Prefered Currency");?>
									</th>
									<th>
										<?php echo dp($info_holder,"Active");?>
									</th>

									<th>
										<?php echo dp($info_holder,"More Information");?>
									</th>

									<th>
									</th>
								</tr>
							</thead>

							<tbody>
								<?php echo list_rfqmain($lrfq);?>

							</tbody>
						</table>

						<div style="clear:both">
						</div>

					</div>
				</div>


			</div>





			<div style="clear:both">
			</div>
		</div>


		<!-- Modal -->
		<div style="display:none" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body" id="svauth">
						<div id="dyen">
							<p><?php echo dp($info_holder,"Please wait, while we update your password.");?></p>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo dp($info_holder,"Close");?></button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->


	</div>
</div>
</div>

<script>
	function isNumeric(n) {
		return !isNaN(parseFloat(n)) && isFinite(n);
	}
	var istotaladded=0;
	$( "#rfqtableadd" ).click(function() {
		add_rfq();
		rfqtotal();
	});

	function rfqtotal()
	{
		var gt=0;
		$('#rfqtable tbody tr td:nth-child(7)').find("input").each(function() {
			try
			{
				if (isNumeric($(this).val()))
				{
					var gc= parseInt($(this).val());
					gt=gt+gc;
				}
			}
			catch(err)
			{
			}
		});

		var gr="<tr><td></td><td></td><td></td><td></td><td></td><td><b>"+"<?php echo dp($info_holder,"Total")?>"+"</b></td><td><b>"+gt.toString()+" "+$("#rfqcurrency").val()+"</b></td></tr>";
		$("#rfqtable tfoot tr").remove(); 
		$('#rfqtable tfoot').append(gr);

	}
	function add_rfq()
	{
		var row = $("#initrfqrow").html();
		$('#rfqtable tbody').append('<tr>'+row+'</tr>');
	}
	var gtrace;
	function rme(rew)
	{
		var rowCount = $('#rfqtable tbody tr').length;
		if (rowCount != 1)
		{
			$(rew.parentElement.parentElement.parentElement).remove();
			rfqtotal();
		}
	}
</script>
<style>
	.shape{	
		border-style: solid; border-width: 0 70px 40px 0; float:right; height: 0px; width: 0px;
		-ms-transform:rotate(360deg); /* IE 9 */
		-o-transform: rotate(360deg);  /* Opera 10.5 */
		-webkit-transform:rotate(360deg); /* Safari and Chrome */
		transform:rotate(360deg);
	}
	.offer{
		background:#fff; border:1px solid #ddd; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); margin: 15px 0; overflow:hidden;
	}
	.offer-radius{
		border-radius:7px;
	}
	.offer-danger {	border-color: #d9534f; }
	.offer-danger .shape{
		border-color: transparent #d9534f transparent transparent;
		border-color: rgba(255,255,255,0) #d9534f rgba(255,255,255,0) rgba(255,255,255,0);
	}
	.offer-success {	border-color: #5cb85c; }
	.offer-success .shape{
		border-color: transparent #5cb85c transparent transparent;
		border-color: rgba(255,255,255,0) #5cb85c rgba(255,255,255,0) rgba(255,255,255,0);
	}
	.offer-default {	border-color: #999999; }
	.offer-default .shape{
		border-color: transparent #999999 transparent transparent;
		border-color: rgba(255,255,255,0) #999999 rgba(255,255,255,0) rgba(255,255,255,0);
	}
	.offer-primary {	border-color: #428bca; }
	.offer-primary .shape{
		border-color: transparent #428bca transparent transparent;
		border-color: rgba(255,255,255,0) #428bca rgba(255,255,255,0) rgba(255,255,255,0);
	}
	.offer-info {	border-color: #5bc0de; }
	.offer-info .shape{
		border-color: transparent #5bc0de transparent transparent;
		border-color: rgba(255,255,255,0) #5bc0de rgba(255,255,255,0) rgba(255,255,255,0);
	}
	.offer-warning {	border-color: #f0ad4e; }
	.offer-warning .shape{
		border-color: transparent #f0ad4e transparent transparent;
		border-color: rgba(255,255,255,0) #f0ad4e rgba(255,255,255,0) rgba(255,255,255,0);
	}
	.shape-text{
		color:#fff; font-size:12px; font-weight:bold; position:relative; right:-40px; top:2px; white-space: nowrap;
		-ms-transform:rotate(30deg); /* IE 9 */
		-o-transform: rotate(360deg);  /* Opera 10.5 */
		-webkit-transform:rotate(30deg); /* Safari and Chrome */
		transform:rotate(30deg);
	}	
	.offer-content{
		padding:0 20px 10px;
	}


	.btn-circle {
		width: 30px;
		height: 30px;
		text-align: center;
		padding: 6px 0;
		font-size: 12px;
		line-height: 1.428571429;
		border-radius: 15px;
	}
	.btn-circle.btn-lg {
		width: 50px;
		height: 50px;
		padding: 10px 16px;
		font-size: 18px;
		line-height: 1.33;
		border-radius: 25px;
	}
	.btn-circle.btn-xl {
		width: 70px;
		height: 70px;
		padding: 10px 16px;
		font-size: 24px;
		line-height: 1.33;
		border-radius: 35px;
	}

</style>