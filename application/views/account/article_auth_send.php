<?php

function list_gmem(& $ai)
{

if ($ai=="")
{
return "No member list is found";
}
$h='<div> <b> Member List </b> </div><table class="table"><tr><th>Member Email</th><th>Member Company Name</th></tr>';

foreach($ai as &$v)
{
$h .="<tr><td>".$v['user_email']."</td><td>".$v['user_orgname']."</td></tr>";
}

return $h."</table>";
}

function module_split(& $mdata,$mname)
{
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
function useremaildata(& $audata)
{
$dyd="<div class='checkbox'>
";
$v=0;
foreach($audata as &$value)
{
$v=1;
if ($value->user_email != "")
{
$dyd .='<label><input type="checkbox" class="alreadylisted" value="'.htmlspecialchars($value->user_email).'" >'.htmlspecialchars($value->user_email).'</label>';
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
function useremaildata_popup(& $audata)
{
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
function is_selected($arrd,$fdat)
{
$pieces = explode(",", $arrd);
foreach($pieces as &$value)
{

if (strtolower($value) == strtolower($fdat))
{
return "checked";
}
}
}
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

var dela='<span style="padding-right:10px" onclick="partdata(this,1)"><i class="icon-remove"></i></span>';
var delad='<span style="padding-right:10px;opacity:0.2"><i class="icon-remove"></i></span>';

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
		var td = $("<td>" + edita +"</i><a href='my_article?article_id="+data[index].article_id+"&article_new=false'><i class='icon-edit'></i></a></span>"+ "</td>");
        tr.append(td);
		
		var td = $("<td>" + dela + "</td>");
        tr.append(td);		
		var aa='<input type="checkbox" name="artactive" value="artactive" checked="checked" onclick="articleactive(this);"/>';
		var td = $("<td>" + aa + "</td>");
        tr.append(td);
		}
		else if (data[index].article_active == "0" && isadmin==1 && data[index].article_ready == "1")
		{
		var td = $("<td>" + edita +"</i><a href='my_article?article_id="+data[index].article_id+"&article_new=false'><i class='icon-edit'></i></a></span>"+ "</td>");
        tr.append(td);
		
		var td = $("<td>" + dela + "</td>");
        tr.append(td);		
		var aa='<input type="checkbox" name="artactive" value="artactive" onclick="articleactive(this);"/>';
		var td = $("<td>" + aa + "</td>");
        tr.append(td);
		}
		
		else if (isadmin==1 && data[index].article_ready == "0")
		{
		var td = $("<td>" + edita +"</i><a href='my_article?article_id="+data[index].article_id+"&article_new=false'><i class='icon-edit'></i></a></span>"+ "</td>");
        tr.append(td);
		
		var td = $("<td>" + dela + "</td>");
        tr.append(td);		
		var aa='<input type="checkbox" name="artactive" value="artactive"  onclick="articleactive(this);"/>';
		var td = $("<td>" + aa + "</td>");
        tr.append(td);
		}		
		else if (data[index].article_ready == "0" && data[index].article_active == "1")
		{
		var td = $("<td>" + edita +"</i><a href='my_article?article_id="+data[index].article_id+"&article_new=false'><i class='icon-edit'></i></a></span>"+ "</td>");
        tr.append(td);
		
		var td = $("<td>" + dela + "</td>");
        tr.append(td);		
		
		var aa='No';
		var td = $("<td>" + aa + "</td>");
        tr.append(td);
		}
		else if (data[index].article_active == "1" && isadmin==0 && data[index].article_ready == "1")
		{
		
		var td = $("<td>" + editad +"</i><i class='icon-edit'></i></span>"+ "</td>");
        tr.append(td);
		
		var td = $("<td>" + delad + "</td>");
        tr.append(td);	
		
		var aa='yes';
		var td = $("<td>" + aa + "</td>");
        tr.append(td);
		}		
		else
		{
		var td = $("<td>" + edita +"</i><a href='my_article?article_id="+data[index].article_id+"&article_new=false'><i class='icon-edit'></i></a></span>"+ "</td>");
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

<div id="main_container" class="main_container" style="min-height:700px">
<span>
</span>
<div>    
<div class="header_text">
<span>
<span style="padding-right:20px">
<i class="icon-user"></i><span style="padding-left:5px"><a style="color:white" href="<?php echo base_url();?>account/my_profile"><?php echo dp($info_holder,"Edit my profile");?></a></span></span>
<span style="padding-right:20px"><i class="icon-lock"></i><span style="padding-left:5px"><a  style="color:white"  href="<?php echo base_url();?>account/change_password"><?php echo dp($info_holder,"Change password");?></a></span></span>
<span style="padding-right:20px"><i class="icon-edit"></i><span style="padding-left:5px"><a style="color:orange" href="<?php echo base_url();?>my_article"><b><?php echo dp($info_holder,"Article Management System");?></b></a></span>
</span>
<span style="padding-right:20px"><i class="icon-edit"></i><span style="padding-left:5px"><a style="color:white" href="<?php echo base_url();?>rfq"><?php echo dp($info_holder,"Request for quotation");?></a></span>
</span>

</span> 
<hr/>
</div> 

<div id="maincon">

<div style="margin-top:20px;margin-left:50px">
<?php echo list_gmem($rgp);?>

</div>

<div class="container" style="width:80%;margin-left:80px">
		<div class="row" >
			<div class="col-xs-3">
				<div class="offer offer-default">
					<div class="shape">
						<div class="shape-text">
							<?php echo dp($info_holder,"AMS");?>							
						</div>
					</div>
					<div class="offer-content">
					<div style="padding-top:10px">
					<a href="<?php echo base_url();?>my_article/approve_artemail/?artid=<?php echo strtolower($aeholder[0]->article_id);?>"> <button class="btn btn-info">Approve</button> </a>
					<a href="<?php echo base_url();?>my_article/disapprove_artemail/?artid=<?php echo strtolower($aeholder[0]->article_id);?>"> <button class="btn btn-warning">Revoke</button> </a>					
					</div>
					</div>
				</div>
			</div>
		</div>
</div>


<div id="dycupdatearticle" style="display:none">
	<div style="padding-left:50px;padding-top:20px">
	<img src="http://abrasivesworld.com/application/css/images/load.GIF"/>	
	<?php echo dp($info_holder,"Please wait while we process the information.");?>	
	</div>
</div>


<?php
if (module_split($umedata[0]->subs_module,"sub_onceweekly")==true)
{

?>
			<div id="newarticle" style="margin-top:20px;margin-left:20px; width:90%;min-width:500px">
			<form action="my_article/save_article" method="post" id="newarticleform" >
			<div>

			<div style="display:none">
			<input type="text" name="scw_articleid" id="scw_articleid" value="<?php echo strtolower($aeholder[0]->article_id); ?>"/>
			</div>

			<div class="padme">
			<label for="scw_arttitle" class="description btext"><?php echo dp($info_holder,"Article Title");?></label>
			<input type="text" name="scw_arttitle" id="scw_arttitle" value="<?php echo htmlspecialchars($aeholder[0]->article_title);?>" required="required" disabled/>
			<span style="display:none" id="scw_arttitlei">
			<b style="color:orange">
			<?php echo dp($info_holder,"Please fill up this information");?>
			</b>
			</span>
			</div>

			<div class="padme">
			<label for="scw_artauthor" class="description btext"><?php echo dp($info_holder,"Article Author");?></label>
			<input type="text" name="scw_artauthor" id="scw_artauthor" value="<?php echo htmlspecialchars($aeholder[0]->article_author);?>" required="required" disabled/>
			<span style="display:none" id="scw_arttitlei">
			<b style="color:orange">
			<?php echo dp($info_holder,"Please fill up this information");?>
			</b>
			</span>
			</div>

			<div class="padme">
			<label for="scw_artregcompany" class="description btext"><?php echo dp($info_holder,"Registered Company Name");?></label>
			<input type="text" name="scw_artregcompany" id="scw_artregcompany" value="<?php echo htmlspecialchars($aeholder[0]->article_org);?>" disabled />
			</div>

			<div class="padme">
			<label for="scw_artdate" class="description btext"><?php echo dp($info_holder,"Article Date");?></label>
			<input type="text" name="scw_artdate" id="scw_artdate" value="<?php echo htmlspecialchars($aeholder[0]->article_date);?>" disabled />
			<span style="display:none" id="scw_arttitlei">
			<b style="color:orange">
			<?php echo dp($info_holder,"Please fill up this information");?>
			</b>
			</span>
			</div>

			<div class="padme">
			<label for="scw_artlang" class="description btext"><?php echo dp($info_holder,"Article Language");?></label>

			<select  name="scw_artlang">
					  <option value="en" <?php if ($aeholder[0]->article_lang=="en"){echo "selected";}?>>English</option>
					  <option value="zh-cn" <?php if ($aeholder[0]->article_lang=="zh-cn"){echo "selected";}?>>中文</option>
					  <option value="th" <?php if ($aeholder[0]->article_lang=="th"){echo "selected";}?>><?php echo dp($info_holder,"Thai");?></option>
					  <option value="hi" <?php if ($aeholder[0]->article_lang=="hi"){echo "selected";}?>><?php echo dp($info_holder,"Hindi");?></option>
					  <option value="de" <?php if ($aeholder[0]->article_lang=="de"){echo "selected";}?>><?php echo dp($info_holder,"German");?></option>
					  <option value="id" <?php if ($aeholder[0]->article_lang=="id"){echo "selected";}?>><?php echo dp($info_holder,"Bahasa");?></option>	
			</select>
			</div>

			<div class="padme">
			<div style="margin-top:10px;margin-bottom:15px">
			<label for="" class="description btext"><?php echo dp($info_holder,"Post this article on home page");?>
			</label>

			<span>
			<input style="margin:0px 0px 0px 0px" type="checkbox"  value="posthome" name="posthome" id="posthome" <?php if ( $aeholder[0]->article_active == "1") {echo "checked";}?>/> 
			<span>
			<?php echo dp($info_holder,"show on home page");?>
			</span>
			</span>
			<div style="margin-left:230px;">
			<div>
			<span style="font-style:italic;" >
				<a href="#"  class="masterTooltip" style="color:black" title="By using “By member’s group”, your Article shall be proof read by Abrasivesworld before sending to your selected member group. It is to ensure no irresponsible article is sent out. It may take 2-3 days before reaching the members in the group selected">
			<input type="checkbox" id="jshowbygroupc" style="margin:0px 0px 0px 0px"/> <?php echo dp($info_holder,"By member group");?></span>
			</a>
			</div>
			<div id="jshowbygroup">
			<br/>
			<?php echo build_group_selection($usergroupinfo,$info_holder,$aeholder[0]->article_target_group);?>
			</div>
			</div>
			<br/>
			<div style="margin-left:230px">
			<span ><a href="#" class="masterTooltip"  style="color:black" title='“Sent article via email” enable  your article to  be viewed by the email receiver with you in copy. Other email receiver will not be able to see other email addresses that you may have added'>
			<input type="checkbox" id="jshowbyemailc" style="margin:0px 0px 0px 0px"/>
			<m class="font-style:italic"><?php echo dp($info_holder,"Send article via email");?>
			</m>
			</a>
			</span>
			<div id="jshowbyemail">
			<br/>
			<br/>
			<span>
			<input type="text" name="newarticleemail" class="typeahead" id="newarticleemail" style="width:200px;" value="<?php echo htmlspecialchars($aeholder[0]->article_target_email);?>"/>
			</span>
			</div>
			</div>

			</div>
			</div>
			<div class="padme" style="display:none">
			<span>
			<input type="checkbox"  value="activateart" name="activateart" id="activateart"/>
			</span>
			</div>
			

			<br/>
			<div class="padme">
			<label for="scw_artcontent" class="description btext"><?php echo dp($info_holder,"Article Content");?></label>
			</div>
			<br/>
			<br/>
			<textarea id="newarticledata" style="width:600px;height:500px" name="newarticledata">
			<?php echo $aeholder[0]->article_details;?>
			</textarea>

			</div>
			<br/>
			


			<br/>
			<div class="padme">
			<p><a href="" id="transok"> <?php echo dp($info_holder,"would you like to view the translated version?");?></a></p>
			<p style="font-size:12px;color:gray;font-style:italic"><?php echo dp($info_holder,"Select the destination language");?></p>
			<select id="dlanguage" name="dlanguage">
			  <option value="en"><?php echo dp($info_holder,"English");?></option>
			  <option value="zh-cn" selected><?php echo dp($info_holder,"Chinese");?></option>
			  <option value="th"><?php echo dp($info_holder,"Thai");?></option>
			  <option value="hi"><?php echo dp($info_holder,"Hindi");?></option>
			  <option value="de"><?php echo dp($info_holder,"German");?></option>
			  <option value="id"><?php echo dp($info_holder,"Bahasa");?></option>
			</select>

			<br/>

			
			</form>
		
			</div>
			</div>
<?php
}
else
{
echo "<p style='text-align:left;margin-left:20px;color:orange'><b>".dp($info_holder,"Article module is not activated.")."</b></p>";
}
?>

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
  


  
<div id="editmyarticle">

</div>

</div>

<script>
var is_save=0;
var is_proceed=0;

$("#transok").click(function(){
jQuery('#newarticle').fadeTo(500,0.2);
$("#transtitle").html("<?php echo dp($info_holder,"Please wait while we translate the article.");?>");
$("#TransModal").modal('show');
tinyMCE.triggerSave(true,true);
$.ajax({url:"<?php echo base_url();?>my_article/trans_data",type:"POST",data:$("#newarticleform").serialize(),success:function(response) {
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
        // Tooltip only Text
        $('.masterTooltip').hover(function(){
                // Hover over code
                var title = $(this).attr('title');
                $(this).data('tipText', title).removeAttr('title');
                $('<p class="tooltipc"></p>')
                .text(title)
                .appendTo('body')
                .fadeIn('slow');
        }, function() {
                // Hover out code
                $(this).attr('title', $(this).data('tipText'));
                $('.tooltipc').remove();
        }).mousemove(function(e) {
                var mousex = e.pageX + 20; //Get X coordinates
                var mousey = e.pageY + 10; //Get Y coordinates
                $('.tooltipc')
                .css({ top: mousey, left: mousex })
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
</style>
