<?php
function module_split(& $mdata,$mname) {
	$ms=explode(":",$mdata);
	$v=false;
	foreach($ms as &$value)
	{
		if($value==$mname)
		{
			$v=true;
			break;
		}
	}
	return $v;
}
function useremaildata(& $audata) {
	$dyd="<div style='text-align:left'>
	";
	$v=0;
	$emailArray = array();

	foreach($audata as &$value) {
		$v=1;
		
		if ($value->user_email != "" && in_array(trim($value->user_email), $emailArray) == false)
		{ 
			$emailArray[] = $value->user_email;
			$dyd .='<div class="checkbox"><label><input type="checkbox" class="alreadylisted" value="'.htmlspecialchars($value->user_email).'" >'.htmlspecialchars($value->user_email).'</label></div>';
		}
	}
	$dyd .="</div>
	";
	if ( $v==1)
	{
		return $dyd;
	}
	else
	{
		return "";
	}
}
function useremaildata_popup(& $audata) {
//uemaildata
	$dyd="
	!function(source) {
		function extractor(query) {
			var result = /([^,]+)$/.exec(query);
			if(result && result[1])
				return result[1].trim();
			return '';
		}

		$('.typeahead').typeahead({
			source: source,
			updater: function(item) {
				return this.\$element.val().replace(/[^,]*$/,'')+item+',';
			},
			matcher: function (item) {
				var tquery = extractor(this.query);
				if(!tquery) return false;
				return ~item.toLowerCase().indexOf(tquery.toLowerCase())
			},
			highlighter: function (item) {

				var query = extractor(this.query).replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
				return item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
					return '<strong>' + match + '</strong>'
				})
}
});

}([";
	$v=0;
	foreach($audata as &$value)
	{
		$v=1;
		$dyd .='"'. htmlspecialchars($value->user_email).'",';
	}
	$dyd .='""]);';
if ($v==1)
{
	return $dyd;
}
else
{
	return "";
}
}
function is_selected($arrd,$fdat) {
	$pieces = explode(",", $arrd);
	foreach($pieces as &$value)
	{

		if (strtolower($value) == strtolower($fdat))
		{
			return "checked";
		}
	}
}
function build_group_selection(& $data, & $ih,$ps) {
	$sel="";
	foreach($data as $row)
	{
		if ($row['uselectiontext']=="Others, please specify")
		{
			$sel .= '<div class="checkbox"><label><input type="checkbox" name="artgroup[]" value="'.dp($ih,$row['uselection']).'" '.is_selected($ps,$row['uselection']).'> '.dp($ih,'Others not listed above').'</label></div>';
		}
		else
		{
			$sel .= '<div class="checkbox"><label><input  type="checkbox" name="artgroup[]" value="'.dp($ih,$row['uselection']).'" '.is_selected($ps,$row['uselection']).'> '.dp($ih,$row['uselectiontext']).'</label></div>';

		}
	}
	$sel .="";
	return $sel;
}
function GUID() {
	if (function_exists('com_create_guid') === true)
	{
		return trim(com_create_guid(), '{}');
	}

	return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}
function dp(& $info_holderdy,$f) {
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

if (isset($_SESSION["article_id"]) == false && isset($_SESSION["scw_arttitle"]) == false && isset($_SESSION["scw_artdate"]) == false && isset($_SESSION["scw_artauthor"]) == false && isset($_SESSION["newarticledata"]) == false)
{
	$_SESSION["article_id"]= GUID();
	$_SESSION["scw_arttitle"]="";
	$_SESSION["scw_artdate"]="";
	$_SESSION["scw_artauthor"]="";
	$_SESSION["newarticledata"]=dp($info_holder,"Your article content go here");
	$_SESSION["scw_targetemail"]="";
	$_SESSION["scw_targetgroup"]="";
	$_SESSION["scw_artlang"]="en";
	$_SESSION["scw_home"]="";
	$_SESSION["scw_artready"]="";

}


if ($isedit == 1)
{

	foreach ($aeholder as &$value)
	{
		$_SESSION["article_id"]= $value->article_id;
		$_SESSION["scw_arttitle"]=$value->article_title;
		$_SESSION["scw_artdate"]=$value->article_date;
		$_SESSION["scw_artauthor"]=$value->article_author;
		$_SESSION["newarticledata"]=$value->article_details;
		$_SESSION["scw_targetemail"]=$value->article_target_email;
		$_SESSION["scw_targetgroup"]=$value->article_target_group;
		$_SESSION["scw_artlang"]=$value->article_lang;

		if ($value->article_active==1)
		{
			$_SESSION["scw_home"]="checked";
		}
		else
		{
			$_SESSION["scw_home"]="";
		}

		if ($value->article_ready==1)
		{
			$_SESSION["scw_artready"]="checked";
		}
		else
		{
			$_SESSION["scw_artready"]="";
		}

	}
}
if ($a_new == 1)
{
	$_SESSION["article_id"]= GUID();
	$_SESSION["scw_arttitle"]="";
	$_SESSION["scw_artdate"]="";
	$_SESSION["scw_artauthor"]=$_SESSION['user_mname'];
	$_SESSION["newarticledata"]=dp($info_holder,"Your article content go here");
	$_SESSION["scw_targetemail"]="";
	$_SESSION["scw_targetgroup"]="";
	$_SESSION["scw_artlang"]=$ussersessionlang;
	$_SESSION["scw_home"]="";
	$_SESSION["scw_artready"]="";

}

?>

<script src="<?php echo  base_url();?>tinymce/tinymce.min.js"> </script>
<style type="text/css" media="all">
	@import url("<?php echo  base_url();?>tinymce/datepicker.css");

</style>


<script src="<?php echo  base_url();?>tinymce/bootstrap-datepicker.js"> </script>
<?php
$e=1;
$ed="";
$ev=$arteldata[0]['eday'];
if ($arteldata[0]['eday'] == "")
{
	$e=1;
}
else if ($arteldata[0]['eday'] > 7)
{
	$e=1;
}
else if ($arteldata[0]['eday'] <= 7)
{
	$e=0;
	$ed=$ev-7;
}
else
{
	$e=1;
}
?>
<script>

	var ev="<?php echo $ev;?>";
	var ed="<?php echo $ed;?>";

	var isr=<?php echo $e;?>;
	isr=1;
</script>
<style>
	.tooltipc {
		display:none;
		position:absolute;
		border:1px solid #333;
		background-color:#161616;
		border-radius:5px;
		padding:10px;
		color:#fff;
		font-size:12px Arial;
	}
</style>
<script>
	var isadmin=0;
	<?php
	if ($user_id_info == 1)
	{
		echo "isadmin=1;";
	}
	?>

	var is_loaded_a=0;
	$( document ).ready(function() {
		$('#scw_artdate').datepicker();
		new_article(0);
	});
	function article_manage(i)
	{
		switch (i)
		{
			case 1:
			$("#managemyarticle").hide();
			subs_show();
			new_article_empty();
			break;
			case 2:
			article_management();
			break;
		}
	}

	function new_article(cld)
	{
		$("#managemyarticle").hide();
		tinymce.init({
			selector: "textarea",
			theme: "modern",
			relative_urls:false,
			remove_script_host : false,
	//document_base_url : 'http://abrasivesworld.com/alpha/',
	plugins: [
	"advlist autolink lists link preview hr anchor pagebreak<?php if (module_split($umedata[0]->subs_module,"sub_imageupload")==true){echo " image";}?>",
	"fullscreen",
	"nonbreaking save table contextmenu <?php if (module_split($umedata[0]->subs_module,"sub_videoupload")==true){echo " media";}?>",
	"paste textcolor moxiemanager"
	],
	toolbar1: "insertfile fontsizeselect undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	toolbar2: "print preview media | forecolor backcolor"

});
		if (cld == 1)
		{
			new_article_empty();
		}
		subs_show();
	}

	function article_management()
	{
		$("#dycupdatearticle").show();
		$("#managemyarticle").show();
		$("#newarticle").hide();
		$("#articletable").find("tr:gt(0)").remove();
		var table = $("#articletable tbody");
		var edita='<span style="padding-right:10px" onclick="partdata(this,0)">';
		var editad='<span style="padding-right:10px;opacity:0.2">';

		var dela='<span style="padding-right:10px" onclick="partdata(this,1)"><i style="color:red" class="glyphicon glyphicon-remove-circle"></i></span>';
		var delad='<span style="padding-right:10px;opacity:0.2"><i style="red" class="glyphicon glyphicon-remove-circle"></i></span>';

		$.getJSON('my_article/json_article', function(data) {
			$.each(data, function(index) {
				var tr = $("<tr></tr>");
				table.append(tr);

				var td = $("<td>" + data[index].article_title + "</td>");
				tr.append(td);

				var td = $("<td>" + data[index].article_date + "</td>");
				tr.append(td);

				if (data[index].article_active == "1" && isadmin==1 && data[index].article_ready == "1")
				{
					var td = $("<td>" + edita +"</i><a href='my_article?article_id="+data[index].article_id+"&article_new=false'><i class='glyphicon glyphicon-edit' style='color:gray' ></i></a></span>"+ "</td>");
					tr.append(td);

					var td = $("<td>" + dela + "</td>");
					tr.append(td);
					var aa='<input type="checkbox" name="artactive" value="artactive" checked="checked" onclick="articleactive(this);"/>';
					var td = $("<td>" + aa + "</td>");
					tr.append(td);
				}
				else if (data[index].article_active == "0" && isadmin==1 && data[index].article_ready == "1")
				{
					var td = $("<td>" + edita +"</i><a href='my_article?article_id="+data[index].article_id+"&article_new=false'><i class='glyphicon glyphicon-edit' style='color:gray' ></i></a></span>"+ "</td>");
					tr.append(td);

					var td = $("<td>" + dela + "</td>");
					tr.append(td);
					var aa='<input type="checkbox" name="artactive" value="artactive" onclick="articleactive(this);"/>';
					var td = $("<td>" + aa + "</td>");
					tr.append(td);
				}

				else if (isadmin==1 && data[index].article_ready == "0")
				{
					var td = $("<td>" + edita +"</i><a href='my_article?article_id="+data[index].article_id+"&article_new=false'><i class='glyphicon glyphicon-edit' style='color:gray' ></i></a></span>"+ "</td>");
					tr.append(td);

					var td = $("<td>" + dela + "</td>");
					tr.append(td);
					var aa='<input type="checkbox" name="artactive" value="artactive"  onclick="articleactive(this);"/>';
					var td = $("<td>" + aa + "</td>");
					tr.append(td);
				}
				else if (data[index].article_ready == "0" && data[index].article_active == "1")
				{
					var td = $("<td>" + edita +"</i><a href='my_article?article_id="+data[index].article_id+"&article_new=false'><i class='glyphicon glyphicon-edit' style='color:gray' ></i></a></span>"+ "</td>");
					tr.append(td);

					var td = $("<td>" + dela + "</td>");
					tr.append(td);

					var aa='No';
					var td = $("<td>" + aa + "</td>");
					tr.append(td);
				}
				else if (data[index].article_active == "1" && isadmin==0 && data[index].article_ready == "1")
				{

					var td = $("<td>" + editad +"</i><i class='glyphicon glyphicon-edit' style='color:gray' ></i></span>"+ "</td>");
					tr.append(td);

					var td = $("<td>" + delad + "</td>");
					tr.append(td);

					var aa='yes';
					var td = $("<td>" + aa + "</td>");
					tr.append(td);
				}
				else
				{
					var td = $("<td>" + edita +"</i><a href='my_article?article_id="+data[index].article_id+"&article_new=false'><i class='glyphicon glyphicon-edit' style='color:gray' ></i></a></span>"+ "</td>");
					tr.append(td);

					var td = $("<td>" + dela + "</td>");
					tr.append(td);

					var ana='No';
					var td = $("<td>" + ana + "</td>");
					tr.append(td);
				}

				var td = $("<td>" + data[index].article_id + "</td>");
				tr.append(td);

			});
$("#dycupdatearticle").hide();
});

is_loaded_a =1;
}
var etrace;
function partdata(ite,whattodo)
{
	if ( whattodo == 1 )
	{
		var r=confirm(<?php echo json_encode(dp($info_holder,"Do you really want to delete the article ?"));?>);
		if (!r==true)
		{
			return;
		}
var formData = {id:ite.parentNode.parentNode.childNodes[5].innerText}; //Array
$.ajax({
	url : "my_article/delete_article",
	type: "POST",
	data : formData,
	success: function(data, textStatus, jqXHR)
	{
		var um=<?php echo json_encode(dp($info_holder,"Article"));?>+ " "+ite.parentNode.parentNode.childNodes[0].innerText+<?php echo json_encode(dp($info_holder," was successfully deleted"));?>;
		update_function_confirmation(jqXHR,um);
		if (jqXHR.responseText == "1")
		{

			ite.parentNode.parentNode.remove();

		}
	},
	error: function (jqXHR, textStatus, errorThrown)
	{

	}
});
}
etrace=ite;

}

setTimeout(function() {
      // Do something after 5 seconds
  }, 5000);

function update_function_confirmation(sv,message)
{
	etrace =sv;
	if ( sv.responseText == "1")
	{
		$("#upcm").text(message);
		$("#upch").text(<?php echo json_encode(dp($info_holder,"Successful"));?>);
		$("#upcmc").show();
		var bc= $( "#upcmc" ).css( "background-color");
		$( "#upcmc" ).css( "background-color",'#F3F781');
		setTimeout(function(){ $( "#upcmc" ).css( "background-color",bc); }, 3000);
	}

}
function articleactive(ac)
{
	var actives=0;
	if (ac.checked== true)
	{
		actives=1;
	}
var formData = {id:ac.parentNode.parentNode.childNodes[5].innerText,activestatus:actives}; //Array
$.ajax({
	url : "my_article/update_article_status",
	type: "POST",
	data : formData,
	success: function(data, textStatus, jqXHR)
	{
		var um=<?php echo json_encode(dp($info_holder,"Article"));?> + " "+ ac.parentNode.parentNode.childNodes[0].innerText+<?php echo json_encode(dp($info_holder," was successfully updated"));?>;
		update_function_confirmation(jqXHR,um);
	},
	error: function (jqXHR, textStatus, errorThrown)
	{

	}
});

}
</script>
<style>
	.btext
	{
		font-weight:bold;
	}
</style>

<div class="container" style="background:whitesmoke">
	<div style="margin-top:10px" id="topMenu">
		<div>
			<div class="row nav-row">
				<div class="col-md-3">

					<div><span class="glyphicon glyphicon-user"></span> <a style="color:#3A3434;padding-left:5px" href="<?php echo base_url();?>account/my_profile"><?php echo dp($info_holder,"Edit my profile");?></a></div>
				</div>
				<div class="col-md-3">

					<div><span class="glyphicon glyphicon-lock"></span> <a style="color:#3A3434;padding-left:5px" href="<?php echo base_url();?>account/change_password"><?php echo dp($info_holder,"Change password");?></a></div>
				</div>
				<div class="col-md-3 active">

					<div><span class="glyphicon glyphicon-folder-close"></span> <a style="color:#3A3434;padding-left:5px" href="<?php echo base_url();?>my_article"><?php echo dp($info_holder,"Article Management System");?></a></div>
				</div>
				<div class="col-md-3">

					<div><span class="glyphicon glyphicon-folder-close"></span> <a style="color:#3A3434;padding-left:5px" href="<?php echo base_url();?>rfq"><?php echo dp($info_holder,"Request for quotation");?></a></div>
				</div>
			</div>
		</div>
	</div>

	<div  style="margin-top:10px;">	
		<div class="row nav-row" style="text-align:center">
			<div class="col-md-3 col-centered">
				<div style="padding-top:5px;padding-bottom:5px;" style="text-align:center">
					<span class="glyphicon glyphicon-folder-close" style="padding-right:5px"></span> <span style="padding-left:5px;cursor:pointer;font-weight:100" onclick="article_manage(1)" ><?php echo dp($info_holder,"Create a new article");?></span>
				</div>
			</div>
			<div class="col-md-3 col-centered">
				<div style="padding-top:5px;padding-bottom:5px;" style="text-align:center">
					<span class="glyphicon glyphicon-calendar" style="padding-right:5px"></span> <span style="padding-left:5px;cursor:pointer;font-weight:100" onclick="article_manage(2)" ><?php echo dp($info_holder,"Manage my article");?></span>
				</div>
			</div>		

			<div class="col-md-3 col-centered">
				<div style="padding-top:5px;padding-bottom:5px;" style="text-align:center">
				<span class="glyphicon glyphicon-info-sign"></span>
				<span style="padding-left:5px;cursor:pointer;font-weight:100">	<a href="<?php echo  base_url();?>help" target="_"><?php echo dp($info_holder,"Help");?></a></span>
				</div>
			</div>

		</div>
	</div>

	<?php
	if (module_split($umedata[0]->subs_module,"sub_onceweekly")==true)
	{
		?>

		<div id="dycupdatearticle" style="display:none;background:#FFFFFF">
			<div style="padding-left:50px;padding-top:20px">
				<img src="http://abrasivesworld.com/application/css/images/load.GIF"/>
				<?php echo dp($info_holder,"Please wait while we process the information.");?>
			</div>
		</div>

		<div  style="text-align:center;margin-top:10px">
			<div class="row">
				<div class="col-xs-12 col-md-12" id="updu">
					<div class="alert alert-success" id="upcmc">
						<strong id="upcmh"><?php echo json_encode(dp($info_holder,"Message"));?></strong>
						<span id="upcc" style="color:red"> &nbsp; &nbsp; <i class="glyphicon glyphicon-minus-sign"></i> </span>
						<div id="upcm"><?php echo json_encode(dp($info_holder,"Please, do not use any offensive words in your article"));?></div>
					</div>
				</div>
			</div>
		</div>

		<div id="newarticle">
			<div  id="viewIcon" style="background:whitesmoke;margin-top:10px">
				<div class="row" style="margin-top:10px">
					<!-- Boxes de Acoes -->
					<div class="col-xs-12 col-sm-12">
						<div class="box">
							<div class="icon">
								<div class="image"><i class="glyphicon glyphicon-book"></i></div>
								<div class="info">
									<h3 class="title"><?php echo dp($info_holder,"New Article");?> </h3>
									<div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

			<div style="background:whitesmoke">
				<form action="my_article/save_article" method="post" id="newarticleform">
					<div style="display:none">
						<input type="text" name="scw_articleid" id="scw_articleid" value="<?php echo strtolower($_SESSION["article_id"]); ?>"/>
					</div>

					<div>
						<span style="display:none" id="scw_arttitlei">
							<b style="color:red">
								<?php echo dp($info_holder,"Please fill up this information");?>
							</b>
						</span>
					</div>
					<div class="form-group">
						<label for="scw_arttitle"><?php echo dp($info_holder,"Article Title");?></label>
						<input type="text" name="scw_arttitle" id="scw_arttitle" class="form-control" value="<?php echo htmlspecialchars($_SESSION["scw_arttitle"]);?>" required="required"/>
					</div>
					<div>
						<span style="display:none" id="scw_arttitlei">
							<b style="color:orange">
								<?php echo dp($info_holder,"Please fill up this information");?>
							</b>
						</span>
					</div>
					<div class="form-group">
						<label for="scw_artauthor"><?php echo dp($info_holder,"Article Author");?></label>
						<input type="text" name="scw_artauthor" class="form-control" id="scw_artauthor" value="<?php echo htmlspecialchars($_SESSION["scw_artauthor"]);?>" required="required"/>
					</div>
					<div class="form-group">
						<label for="scw_artregcompany"><?php echo dp($info_holder,"Registered Company Name");?></label>
						<input type="text" name="scw_artregcompany" class="form-control" id="scw_artregcompany" value="<?php echo htmlspecialchars($_SESSION["user_morgname"]);?>" readonly />
					</div>
					<div>
						<span style="display:none" id="scw_arttitlei">
							<b style="color:orange">
								<?php echo dp($info_holder,"Please fill up this information");?>
							</b>
						</span>
					</div>
					<div class="form-group">
						<label for="scw_artdate"><?php echo dp($info_holder,"Article Date");?></label>
						<input type="text" name="scw_artdate" class="form-control" id="scw_artdate" value="<?php echo htmlspecialchars($_SESSION["scw_artdate"]);?>" required="required" >
					</div>

					<div class="form-group">
						<label for="scw_artlang"><?php echo dp($info_holder,"Article Language");?></label>
						<select  name="scw_artlang" class="form-control">
							<option value="en" <?php if ($_SESSION["scw_artlang"]=="en"){echo "selected";}?>>English</option>
							<option value="zh-cn" <?php if ($_SESSION["scw_artlang"]=="zh-cn"){echo "selected";}?>>中文</option>
							<option value="th" <?php if ($_SESSION["scw_artlang"]=="th"){echo "selected";}?>><?php echo dp($info_holder,"Thai");?></option>
							<option value="hi" <?php if ($_SESSION["scw_artlang"]=="hi"){echo "selected";}?>><?php echo dp($info_holder,"Hindi");?></option>
							<option value="de" <?php if ($_SESSION["scw_artlang"]=="de"){echo "selected";}?>><?php echo dp($info_holder,"German");?></option>
							<option value="id" <?php if ($_SESSION["scw_artlang"]=="id"){echo "selected";}?>><?php echo dp($info_holder,"Bahasa");?></option>
						</select>
					</div>
					<div>
						<label><?php echo dp($info_holder,"Post this article on home page");?>
						</label>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" value="posthome" name="posthome" id="posthome" <?php echo $_SESSION["scw_home"];?> >
							<?php echo dp($info_holder,"show on home page");?>
						</label>
					</div>
					<div class="checkbox">
						<label  title='By using “By member’s group”, your Article shall be proof read by Abrasivesworld before sending to your selected member group. It is to ensure no irresponsible article is sent out. It may take 2-3 days before reaching the members in the group selected' >
							<input type="checkbox" id="jshowbygroupc"> <?php echo dp($info_holder,"By member group");?>
						</label>
					</div>

					<div id="jshowbygroup" style="display:none;margin-left:10px">

						<?php echo build_group_selection($usergroupinfo,$info_holder,$_SESSION["scw_targetgroup"]);?>

					</div>
					<div class="checkbox">
						<label title='“Sent article via email” enable  your article to  be viewed by the email receiver with you in copy. Other email receiver will not be able to see other email addresses that you may have added'>
							<input type="checkbox" id="jshowbyemailc">
							<?php echo dp($info_holder,"Send article via email");?>
						</label>
					</div>
					<div id="jshowbyemail" style="display:none;margin-left:10px">
						<div class="row">
							<div class="col-xs-12 col-md-3">
								<input type="text" name="newarticleemail" class="typeahead form-control" id="newarticleemail"  value="<?php echo htmlspecialchars($_SESSION["scw_targetemail"]);?>"/>
							</div>
							<div class="col-xs-12 col-md-3">
								<input type="button" class="btn btn-u form-control" value="<?php echo dp($info_holder,"select from your previous entry");?>" onclick='show_previous_entry();'/>
							</div>
						</div>
						<div style="margin-top:10px">
							<label> <?php echo dp($info_holder,"You can enter more than one email separted by , for example email1@domain.com,email2@domain.com");?></label>
						</div>
					</div>
					<div>
						<label for="scw_artcontent"><?php echo dp($info_holder,"Article Content");?></label>
					</div>
					<div class="form-group">
						<textarea id="newarticledata" class="form-control" name="newarticledata">
							<?php echo $_SESSION["newarticledata"];?>
						</textarea>
					</div>
					<div  style="display:none">
						<input type="checkbox"  value="activateart" name="activateart" id="activateart" <?php echo $_SESSION["scw_artready"];?> >
					</div>
					<div>
						<a href="" id="transok"> <?php echo dp($info_holder,"would you like to view the translated version?");?></a>
					</div>
					<div>
						<label><?php echo dp($info_holder,"Select the destination language");?></label>
					</div>
					<div class="form-group">
						<select id="dlanguage" name="dlanguage" class="form-control">
							<option value="en"><?php echo dp($info_holder,"English");?></option>
							<option value="zh-cn" selected><?php echo dp($info_holder,"Chinese");?></option>
							<option value="th"><?php echo dp($info_holder,"Thai");?></option>
							<option value="hi"><?php echo dp($info_holder,"Hindi");?></option>
							<option value="de"><?php echo dp($info_holder,"German");?></option>
							<option value="id"><?php echo dp($info_holder,"Bahasa");?></option>
						</select>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-2" style="margin-top:10px">
							<button  id="saveasdraft" type="button" class="btn btn-u form-control"><?php echo dp($info_holder,"save as draft");?></button>
						</div>
						<div class="col-xs-12 col-md-2" style="margin-top:10px">
							<button  id="newarticleformsubmit" type="button"  class="btn btn-u form-control"><?php echo dp($info_holder,"save and post article");?></button>
						</div>
					</div>
					<div style="margin-top:10px">
						<a href="<?php echo base_url();?>my_article/download_article?article_id=<?php echo strtolower($_SESSION["article_id"]); ?>" target="_blank"><?php echo dp($info_holder,"Download this article as Word file.");?></a>
					</div>
				</form>
			</div>
		</div>

		<div id="managemyarticle">
			<div  id="viewIcon" style="background:whitesmoke;margin-top:10px">
				<div class="row" style="margin-top:10px">
					<!-- Boxes de Acoes -->
					<div class="col-xs-12 col-sm-12">
						<div class="box">
							<div class="icon">
								<div class="image"><i class="glyphicon glyphicon-book"></i></div>
								<div class="info">
									<h3 class="title"><?php echo dp($info_holder,"Article Management");?> </h3>
									<div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div>
				<div style="border:3px solid whitesmoke" class="table-responsive">
					<table id="articletable" class="table">
						<thead>
							<tr>
								<th>
									<?php echo dp($info_holder,"Article Title");?>
								</th>
								<th>
									<?php echo dp($info_holder,"Article Created Date");?>
								</th>
								<th>
									<?php echo dp($info_holder,"Edit");?>
								</th>
								<th>
									<?php echo dp($info_holder,"Delete");?>
								</th>
								<th>
									<?php echo dp($info_holder,"Active");?>
								</th>
								<th>
									<?php echo dp($info_holder,"Article Id");?>
								</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div id="editmyarticle">
		</div>

		<?php
	}
	else
	{
		?>
		<div class="alert alert-warning" style="margin-top:10px;text-align:center">
			<h1 style="font-weight:100"><?php echo dp($info_holder,"Hi, You are not subscribed to Article module.");?></h1>
			<p><a class="btn btn-primary btn-lg" role="button" href="account/my_profile#subscr_req"><?php echo dp($info_holder,"Click here to subscribe");?></a></p>
		</div>

		<?php
	}
	?>
</div>
<!-- Modal -->
<div style="display:none" class="modal fade" id="myModal" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?php echo dp($info_holder,"Please wait while we save the article data.");?></h4>
			</div>
			<div class="modal-body" id="svauth">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo dp($info_holder,"Cancel");?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal -->
<div style="display:none" class="modal fade" id="TransModal" tabindex="-3" role="dialog" aria-labelledby="TransModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="transtitle">
				</h4>
			</div>
			<div class="modal-body" id="transpview">
				<div style="padding-left:50px;padding-top:20px">
					<img src="http://abrasivesworld.com/application/css/images/load.GIF"/>
					<?php echo dp($info_holder,"lease wait while we translate the article.");?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal -->
<div style="display:none" class="modal fade" id="ArticleSaveModal" tabindex="-3" role="dialog" aria-labelledby="ArticleSaveModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="transtitle"><?php echo dp($info_holder,"Article Activation Confirmation.");?></h4>
			</div>
			<div class="modal-body" id="savearticleconfirm">
				<?php echo dp($info_holder,"Are you sure that you want activate the article?");?>

			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-xs-12 col-md-2" style="margin-top:10px">
						<button type="button" id="savearticle" class="btn btn-default form-control" data-dismiss="modal"><?php echo dp($info_holder,"OK");?></button>
					</div>
					<div class="col-xs-12 col-md-2" style="margin-top:10px">
						<button type="button" id="cancelarticle" class="btn btn-default form-control" data-dismiss="modal"><?php echo dp($info_holder,"Close");?></button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div style="display:none" class="modal fade" id="myemailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body" id="svauth">
				<div>
					<strong>
						<?php echo dp($info_holder,"Previously added email entries");?>
					</strong>

				</div>
				<?php
				$va=useremaildata($uemaildata);
				if ($va == "") { echo dp($info_holder,"No email entries are found.");}else{ echo $va;};
				?>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-xs-12 col-md-3" style="margin-top:10px">
						<button type='button' class='btn btn-u form-control' onclick='select_all_ue();'><?php echo dp($info_holder,"Select All");?></button>
					</div>
					<div class="col-xs-12 col-md-3" style="margin-top:10px">
						<button type='button' class='btn btn-u form-control' onclick='deselect_all_ue();'><?php echo dp($info_holder,"Deselect All");?></button>
					</div>
					<div class="col-xs-12 col-md-3" style="margin-top:10px">
						<button type='button'  onclick='selected_ue();' class='btn btn-u form-control'><?php echo dp($info_holder,"OK");?></button>
					</div>
					<div class="col-xs-12 col-md-3" style="margin-top:10px">
						<button type="button" class="btn btn-default form-control" data-dismiss="modal"><?php echo dp($info_holder,"Close");?></button>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript" language="javascript" src="<?php echo base_url();?>application/js/bootstrap3-typeahead.min.js"></script>

<script>
	var is_save=0;
	var is_proceed=0;
	$('#upcc').click(function(){
		$(this).parent().hide();
	});


	$("#savearticle" ).click(function() {
		is_save=1;
		$("#ArticleSaveModal").modal('hide');

		$('#activateart').attr('checked', true);
		$('#activateart').val("activateart");
		save_article(10);
	});
	$( "#cancelarticle" ).click(function() {
		is_save=0;
		$('#activateart').attr('checked', false);
		$('#activateart').val("activateartno");
		$("#ArticleSaveModal").modal('hide');
	});


	$("#newarticleformsubmit").click(function(){
		if ( $('#activateart').is(':checked') == true)
		{
			$("#ArticleSaveModal").modal();
		}
	});




	$("#newarticleformsubmit").click(function(){

		$('#activateart').val("activateart");
		$("#ArticleSaveModal").modal();

	});

	$("#saveasdraft").click(function(){
		$('#activateart').val("activateartno");
		save_article(11);
	});


	function save_article(redp)
	{
		if (validate_data() != true)
		{
			return false;
		}

		jQuery('#newarticle').fadeTo(500,0.2);
		$("#myModal").modal();
		tinyMCE.triggerSave(true,true);
		$.ajax({url:"my_article/save_article",type:"POST",data:$("#newarticleform").serialize(),success:function(response) {
			etrace=response;
			if ( response == "1")
			{

				initiate_sendemails();

			}

			else if ( response == "2")
			{


				alert(<?php echo json_encode(dp($info_holder,"Your article has been saved successfully"));?>);
				$("#myModal").modal('hide');
				jQuery('#newarticle').fadeTo(500,1);
				article_manage(2);

			}
		},error:function(){
			$("#myModal").modal('hide');
			alert("OOPS, something went wrong");
			jQuery('#newarticle').fadeTo(500,1);
		}});

		return false;
	}
	$("#transok").click(function(){
		jQuery('#newarticle').fadeTo(500,0.2);
		$("#transtitle").html("<?php echo dp($info_holder,"Please wait while we translate the article.");?>");
		$("#TransModal").modal('show');
		tinyMCE.triggerSave(true,true);
		$.ajax({url:"my_article/trans_data",type:"POST",data:$("#newarticleform").serialize(),success:function(response) {
			$("#transtitle").html("<?php echo dp($info_holder,"Translated Version.");?>");
			$("#transpview").html(response);
			jQuery('#newarticle').fadeTo(500,1);

		},error:function(){
			$("#TransModal").modal('hide');
			alert("OOPS, something went wrong");
			jQuery('#newarticle').fadeTo(500,1);
		}});

		return false;

	});
	function s4() {
		return Math.floor((1 + Math.random()) * 0x10000)
		.toString(16)
		.substring(1);
	};

	function guid() {
		return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
		s4() + '-' + s4() + s4() + s4();
	}
	function new_article_empty()
	{
		$("#scw_articleid").val(guid());
		$("#scw_arttitle").val("");
		$("#scw_artauthor").val("");
		$("#scw_artdate").val("");
		$("#newarticledata").val("");
		tinyMCE.activeEditor.setContent('');
	}

	function initiate_sendemails()
	{
		$.ajax({url:"my_article/process_emails",type:"POST",data:$("#newarticleform").serialize(),success:function(response) {
			alert(<?php echo json_encode(dp($info_holder,"Your article has been saved successfully"));?>);
			$("#myModal").modal('hide');
			jQuery('#newarticle').fadeTo(500,1);
			location="<?php echo base_url();?>";

		},error:function(){
			alert(<?php echo json_encode(dp($info_holder,"Your article has been saved successfully"));?>);
			$("#myModal").modal('hide');
			jQuery('#newarticle').fadeTo(500,1);
		}});
	}
	function select_all_ue()
	{
		$('.alreadylisted').prop('checked', true);
	}
	function deselect_all_ue()
	{
		$('.alreadylisted').prop('checked', false);
	}
	function selected_ue()
	{
		$("#myemailModal").modal('hide');
		var values = $('input:checkbox:checked.alreadylisted').map(function () {
			return this.value;
}).get(); // ["18", "55", "10"]
		var myJoinedString = values.join(',')+",";
		if (myJoinedString != ",")
		{
			$("#newarticleemail").val(myJoinedString);
		}
	}
	function validate_data()
	{
		var art_title="";
		var art_date="";
		var art_author="";
		art_title=$("#scw_arttitle").val();
		art_date=$("#scw_artdate").val();
		art_author=$("#scw_artauthor").val();

		if (art_title== "")
		{
			$("#scw_arttitle").focus();
			$("#scw_arttitlei").show();
			return false;
		}
		else if (art_date== "")
		{
			$("#scw_artdatei").show();
			$("#scw_artdate").focus();
			return false;
		}
		else if (art_author== "")
		{
			$("#scw_artauthori").show();
			$("#scw_artauthor").focus();
			return false;
		}
		else
		{
			return true;
		}

	}
	function show_previous_entry()
	{

		$("#myemailModal").modal();

	}

	$('#jshowbygroupc').change(function() {
		if($("#jshowbygroupc").is(":checked"))
		{
			$('#jshowbygroup').show();
		}
		else
		{
			$('#jshowbygroup').hide();
		}
	});

	$('#jshowbyemailc').change(function() {
		if($("#jshowbyemailc").is(":checked"))
		{
			$('#jshowbyemail').show();
		}
		else
		{
			$('#jshowbyemail').hide();
		}
	});

	<?php
	echo useremaildata_popup($uemaildata);

	?>
</script>
<script>
	function subs_show()
	{
		if (isadmin == 1)
		{
			$("#newarticle").show();
			return true;
		}
		if (isr==1)
		{
			$("#newarticle").show();
		}
		else
		{
			$("#newarticle").hide();
		}
	}
	if (isr==1)
	{
	}
	else
	{
		$( document ).ready(function() {
			$("#newarticle").hide();
		});
		alert("<?php echo dp($info_holder,"You can only post one article per week, you still have ").$ed.dp($info_holder," days left");?>");
	}

	$(document).ready(function() {
		$(document).ready(function(){
			$("[rel=tooltip]").tooltip({ placement: 'left'});
		});
	});
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
</style>
<style>

	.nav-row {
		text-align: left;
	}
	.nav-row .col-md-3 {
		background-color: #fff;
		border: 1px solid #e0e1db;
		border-right: none;
		padding-bottom: 7px;
	}
	.nav-row .col-md-3:last-child {
		border: 1px solid #e0e1db;
	}
	.nav-row .col-md-3:first-child {
		border-radius: 5px 0 0 5px;
	}
	.nav-row .col-md-3:last-child {
		border-radius: 0 5px 5px 0;
	}
	.nav-row .col-md-3:hover {
		color: #687074;
		cursor: pointer;
	}
	.nav-row .active {
		color: #1ABB9C;
		margin-top: -2px;
		border-top: 3px solid #1ABB9C;
		border-bottom: 3px solid #1ABB9C;
	}
	.nav-row .active:before {
		content: '';
		position: absolute;
		border-style: solid;
		border-width: 6px 6px 0;
		border-color: #1ABB9C transparent;
		display: block;
		width: 0;
		z-index: 1;
		margin-left: -6px;
		top: 0;
		left: 50%;
	}
	.nav-row .glyphicon {
		padding-top: 8px;
		font-size: 15px;
	}
	.nav-row .col-md-6 {
		background-color: #fff;
		border: 1px solid #e0e1db;
		border-right: none;
	}
	.nav-row .col-md-6:last-child {
		border: 1px solid #e0e1db;
	}
	.nav-row .col-md-6:first-child {
		border-radius: 5px 0 0 5px;
	}
	.nav-row .col-md-6:last-child {
		border-radius: 0 5px 5px 0;
	}
	.nav-row .col-md-6:hover {
		color: #687074;
		cursor: pointer;
	}

	.glyphicon-refresh-animate
	{
		-animation: spin .7s infinite linear;
		-webkit-animation: spin2 .7s infinite linear;
	}

	@-webkit-keyframes spin2
	{
		from { -webkit-transform: rotate(0deg);}
		to { -webkit-transform: rotate(360deg);}
	}

	@keyframes spin
	{
		from { transform: scale(1) rotate(0deg);}
		to { transform: scale(1) rotate(360deg);}
	}
</style>

<style>
	#viewIcon .box > .icon { text-align:center; position: relative; }
	#viewIcon .box > .icon > .image { position: relative; z-index: 2; margin: auto; width: 50px; height: 50px; border: 8px solid white; line-height: 40px; border-radius: 50%; background: #63B76C; vertical-align: middle; }
	#viewIcon .box > .icon > .image > i { font-size: 20px !important; color: #fff !important; }
	#viewIcon .box .space { height: 30px; }
</style>
