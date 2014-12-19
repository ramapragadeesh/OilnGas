<?php
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

$st='<div style="padding-left:20px">
		<div  style="padding-bottom:10px">
		<label><h4>'.dp($inh,"Your product:").'</h4></label>
		</div>';
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
		$stt .='<div class="odivid"><label class="checkbox description_check">
			  <input name="pol" type="checkbox"  value="" name="'.$utype.'" '.is_ch($ot).'>
			 '.$optext.'</label>
			 <input type="text" value="'.$ot.'" style="margin-left:15px;" name="'.$utypeo.'"/></div>
			 ';
		}

$stt .= '<h5>'.dp($inh,$value->description).'</h5><br/>';
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
$optext=dp($inh,$value->show_dropdown);
}
else
{
$stt .='<label class="checkbox description_check">
      <input  type="checkbox" id="'.$value->id_text.'" value="'.$value->recordno.'" name="'.$utype.'" '.is_sel_user($mms,$sms,$value->recordno).' >
	 '.dp($inh,$value->show_dropdown).'</label>';
}
}
		if ($op==true)
		{
		$stt .='<div class="odivid"><label class="checkbox description_check">
			  <input name="pol" type="checkbox" value="" name="'.$utype.'" '.is_ch($ot).'>
			 '.$optext.'</label>
			 <input type="text" value="'.$ot.'" name="'.$utypeo.'" style="margin-left:15px;"/></div>
			 ';
		}

if ($stt=="")
{
return "";
}		
return $st.$stt."</div>";		 
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
return "selected";
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
$stt="";
$i=0;
foreach ($inf as &$value) 
{
$i=$i+1;
$na=$tv.$i;
$sa=$sv.$i;
$stt .='
<div> <label class="checkbox description_check">
         <input type="checkbox" value="'.dp($inh,$value->id_text).'" id="'.$value->id_text.'" '.getabf_isvalue($i,$daf).'>
		 '.dp($inh,$value->show_dropdown).'
		 </label>
		  <span style="padding-left:30px">
		 '.dp($inh,"Annual Output",$fs).'        
          <input type="text" name="'.$na.'" id="" value="'.getabf_text($i,$daf).'" style="width:100px"/>
		  <select style="width:80px" name="'.$sa.'">
		  <option value="m2" '.getabf_selection($i,$daf,"m2").'>M2</option>
		  <option value="pcs" '.getabf_selection($i,$daf,"pcs").'>PCS</option>
		  <option value="ltr" '.getabf_selection($i,$daf,"ltr").'>LTR</option>
		<option value="kg" '.getabf_selection($i,$daf,"kg").'>KG</option>	
		  </select>		  
		 </span>
		 </div>
		 <hr style="width:500px">
';
}
if ($stt == "")
{
return "";
}		
return $stt;

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
foreach ($inf as &$value) 
{

if (strtolower($value->show_dropdown) == "others, please specify")
{
$op=true;
$optext=dp($inh,$value->show_dropdown);
}
else
{
$stt .='
<div>
<label class="checkbox description_check">
<input type="checkbox" name="'.$nv.'" value="'.$value->id_text.'" id="'.$value->id_text.'" '.secondaryprim_match($psv,$value->id_text).'>'.dp($inh,$value->show_dropdown).'
</label>
</div>
';
}

}		if ($op==true)
		{
		$stt .='<div class="odivid"><label class="checkbox description_check">
			  <input name="pol" type="checkbox" class="oplse" value="" name="proselect[]" '.is_ch($otv).'>
			 '.$optext.'</label>
			 <input type="text" style="margin-left:15px" value="'.$otv.'" name="'.$ovo.'" /></div>
			 ';
		}

if ($stt == "")
{
return "";
}
return $stt;
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
if ($eie[$i]==$ci)
{
$r="checked";
}
}
return $r;
}
function abcoated_users(& $abuserl, & $hc,$si,$otn="",$otv="")
{
$divg="<div>";
foreach ($abuserl as &$value) 
{

 if ($value->au_category=="Others, please specify")
 {
  $divg .='<label class="checkbox description_check">
            <input type="checkbox" value="'.$value->au_id.'" id="CUIND" name="CUIND[]" '.ab_si($si,$value->au_id).'> '.dp($hc,$value->au_category).'
        </label>
		<input type="text" name="'.$otn.'" value="'.$otv.'" style="margin-left:20px"/>
		'
		;
 }
 else
 {
 $divg .='<label class="checkbox description_check">
            <input type="checkbox" value="'.$value->au_id.'" id="CUIND" name="CUIND[]" '.ab_si($si,$value->au_id).'> '.dp($hc,$value->au_category).'
        </label>'
		;
}
}
$divg .= "</div>";
return $divg;
}


function abbonded_users(& $abuserl, & $hc,$si,$otn="",$otv="")
{
$divg="<div>";
foreach ($abuserl as &$value) 
{
 
  if ($value->au_category=="Others, please specify")
 {
  $divg .='<label class="checkbox description_check">
            <input type="checkbox" value="'.$value->au_id.'" id="BUIND" name="BUIND[]" '.ab_si($si,$value->au_id).'> '.dp($hc,$value->au_category).'
        </label>
		<input type="text" name="'.$otn.'" value="'.$otv.'" style="margin-left:20px"/>
		'
		;
 }
 else
 {

 $divg .='<label class="checkbox description_check">
            <input type="checkbox" value="'.$value->au_id.'" id="BUIND" name="BUIND[]" '.ab_si($si,$value->au_id).'> '.dp($hc,$value->au_category).'
        </label>'
		;
}
}
$divg .= "</div>";
return $divg;
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
$divg="<div>";
foreach ($abuserl as &$value) 
{
 if ($value->au_category=="Others, please specify")
 {
 $divg .='<label class="checkbox description_check">
            <input type="checkbox" value="'.$value->au_id.'" id="ABL" name="ABL[]" '.abusers_match($us,$value->au_id).'> '.dp($hc,$value->au_category).'
        </label>
		<input type="text" value="'.$oto.'" name="ABSMO" style="margin-left:20px"/>
		'
		;

 }
 else
 {
 $divg .='<label class="checkbox description_check">
            <input type="checkbox" value="'.$value->au_id.'" id="ABL" name="ABL[]" '.abusers_match($us,$value->au_id).'> '.dp($hc,$value->au_category).'
        </label>'
		;
}
}
$divg .= "</div>";
return $divg;
}
?>
<?php
$tn=explode("-",$adu[0]->user_contactno);
?>
<style>
.boldme
{
font-weight:bold;
}
</style>
<script type="text/javascript">
var map;
var markers;
var myLatlng;
var defaultBounds;
var lati="";
var longi="";
var geocoder;
var places;
var bounds;
var glog;
var geocoder;
function initialize_gmap()
{
var g;
 var oad = {
            sensor: true,
            address:$("#targetsearch").val()
            
        }
geocoder = new google.maps.Geocoder();
geocoder.geocode( { 'address': $("#targetsearch").val()}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
	g=results[0].geometry.location;
	initialize(g.lat(),g.lng());
	//map.setZoom(18);
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });

}
function initialize(lat,lng) {

 markers = [];

  map = new google.maps.Map(document.getElementById('gmap'), {
    mapTypeId: google.maps.MapTypeId.ROADMAP,
	zoom:16
	
  });
  var myLatlng = new google.maps.LatLng(lat,lng);
  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'My Map!'
  });
  
  
var defaultBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(lat, lng)
      );
map.setZoom(16);
map.fitBounds(defaultBounds);
	

  // Create the search box and link it to the UI element.
  var input = document.getElementById('targetsearch');
  var searchBox = new google.maps.places.SearchBox(input);

  // Listen for the event fired when the user selects an item from the
  // pick list. Retrieve the matching places for that item.
  google.maps.event.addListener(searchBox, 'places_changed', function() {
  places = searchBox.getPlaces();

    for (var i = 0, marker; marker = markers[i]; i++) {
      marker.setMap(null);
    }

    // For each place, get the icon, place name, and location.
    markers = [];
    bounds = new google.maps.LatLngBounds();
	
    for (var i = 0, place; place = places[i]; i++) {
      var image = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      
	  var marker = new google.maps.Marker({
        map: map,
        icon: image,
        title: place.name,
        position: place.geometry.location
      });
		
      markers.push(marker);
      bounds.extend(place.geometry.location);
	  	map.setZoom(18);
    }

    map.fitBounds(bounds);
	map.setZoom(18);
  });

  // Bias the SearchBox results towards places that are within the bounds of the
  // current map's viewport.
  google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();
    searchBox.setBounds(bounds);
  });
  map.setZoom(16);  
}
function goo_zoom() {
try
{
if (map.getZoom() != "16")
{
map.setZoom(16);
}
else
{
return;
}
setTimeout(goo_zoom, 3000);
}
catch(err)
{
setTimeout(goo_zoom, 3000);
}
}

goo_zoom();
      google.maps.event.addDomListener(window, 'load', initialize_gmap);
	 
	  function set_current_location()
	  {
	  
	  try
	  {
	  if (navigator.geolocation)
	  {
     navigator.geolocation.getCurrentPosition(function (position) {
     initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
     map.setCenter(initialLocation);
     });
		}
	  }
	  catch(err)
	  {
	  }
	  }
	  function get_location()
	  {
	  
	  try
	  {
	  var m= map.getBounds();
	  lati=m.ea.b;
	  longi=m.fa.b;
	  }
	  catch(err)
	  {
	  
	  }
	  }
	  
	  
</script>		
<link href="<?php echo base_url();?>application/css/bootstrap-fileupload.min.css" rel="stylesheet">
<script src="<?php echo base_url();?>application/js/bootstrap-fileupload.min.js"> </script>
<script src="<?php echo base_url();?>application/js/jquery.upload-1.0.2.min.js"> </script>

<div id="main_container" class="main_container" style="min-height:700px">
<div>    

<div class="header_text">

<div style="margin-left:30px;">
<!--
<span style="padding-right:20px">
<i class="icon-user"></i><span style="padding-left:5px"><a style="color:orange;" href="<?php echo base_url();?>account/my_profile"><b><?php echo dp($info_holder,"Edit my profile");?></b></a></span></span>
<span style="padding-right:20px"><i class="icon-lock"></i><span style="padding-left:5px"><a style="color:white" href="<?php echo base_url();?>account/change_password"><?php echo dp($info_holder,"Change password");?></a></span></span>
<span style="padding-right:20px"><i class="icon-edit"></i><span style="padding-left:5px"><a style="color:white" href="<?php echo base_url();?>account/download_factsheet"><?php echo dp($info_holder,"Download factsheet");?></a></span></span>
<span style="padding-right:20px"><i class="icon-edit"></i><span style="padding-left:5px"><a style="color:white" href="<?php echo base_url();?>my_article"><?php echo dp($info_holder,"Article Management");?></a></span>
</span>
--> 
<span style="padding-right:20px">
<i class="icon-user"></i><span style="padding-left:5px"><a style="color:orange" href="<?php echo base_url();?>account/my_profile"><b><?php echo dp($info_holder,"Edit my profile");?></b></a></span></span>
<span style="padding-right:20px"><i class="icon-lock"></i><span style="padding-left:5px"><a  style="color:white"  href="<?php echo base_url();?>account/change_password"><?php echo dp($info_holder,"Change password");?></a></span></span>
<span style="padding-right:20px"><i class="icon-edit"></i><span style="padding-left:5px"><a style="color:white" href="<?php echo base_url();?>my_article"><?php echo dp($info_holder,"Article Management System");?></a></span>
</span>
<span style="padding-right:20px"><i class="icon-edit"></i><span style="padding-left:5px"><a style="color:white" href="<?php echo base_url();?>rfq"><?php echo dp($info_holder,"Request for quotation");?></a></span>
</span>
</div>
</div>

<div id="maincon">

<!-- Profile Tab Start-->
<div style="margin-left:30px;width:90%;margin-top:30px">
<p></p>
<ul class="nav nav-tabs" id="myTab" style="padding-top:20px;padding-left:20px">
 <li class="active">
 <a href="#iprofile_settings"><b><?php echo dp($info_holder,"About Me");?></b>
 </a>
  </li>
  

  <li><a href="#bonded_settings"><b><?php echo dp($info_holder,"Bonded");?></b>
  </a></li>
  <li><a href="#coated_settings"><b><?php echo dp($info_holder,"Coated");?></b></a></li>
  <li><a href="#subscr_req"><b><?php echo dp($info_holder,"Subscription Settings");?></b></a></li>
 </ul>
 
 
</div>
<!-- Profile Tab End-->

<!-- Profile Tab Content Start-->
<div class="tab-content" id="profilecontent">

<!-- iprofile start-->
<div class="tab-pane active" id="iprofile_settings">

<div>
<form method="post" id="customForm">
    <div id="pane1" class="tab-pane active">
	<div style="text-align:center">
	<!-- <a href="<?php echo  base_url()?>abprofile/vprofile_download?profile_id=<?php echo $adu[0]->recordno;?>" target="_blank"><?php echo dp($info_holder,"Click here to download your profile as Word file");?></a>-->
     </div> 
	  <h4 style="padding-left:40px"><?php echo dp($info_holder,"Are you a");?></h4>  
		<div>	
		<div class="controls span2" style="width:300px">
        <label class="checkbox description_check">
            <input type="checkbox" value="A" id="A" name="AU[]" <?php echo uodd_process($uodd,'A',0);?>> <?php echo dp($info_holder,"Machine / Equipment  Supplier");?>
        </label>
        <label class="checkbox description_check">
            <input type="checkbox" value="B" id="B" name="AU[]" <?php echo uodd_process($uodd,'B',0);?>> <?php echo dp($info_holder,"Raw Material Supplier");?>
        </label>
        <label class="checkbox description_check">
            <input type="checkbox" value="C" id="C" name="AU[]" <?php echo uodd_process($uodd,'C',0);?>> <?php echo dp($info_holder,"Abrasive Producer (Bonded)");?>
        </label>
		 <label class="checkbox description_check">
            <input type="checkbox" value="Z" id="Z" name="AU[]" <?php echo uodd_process($uodd,'Z',0);?>> <?php echo dp($info_holder,"Abrasive Producer (Coated)");?>
        </label>
        <label class="checkbox description_check">
            <input type="checkbox" value="D" id="D" name="AU[]" <?php echo uodd_process($uodd,'D',0);?>> <?php echo dp($info_holder,"Coated Abrasive Converter");?>
        </label>
		
		<label class="checkbox description_check">
            <input type="checkbox" value="E" id="E" name="AU[]" <?php echo uodd_process($uodd,'E',0);?>> <?php echo dp($info_holder,"Distributor( Bonded or Coated Abrasive)");?>
        </label>
        <label class="checkbox description_check">
            <input type="checkbox" value="F" id="F" name="AU[]" <?php echo uodd_process($uodd,'F',0);?>> <?php echo dp($info_holder,"Abrasive Users");?>
			
        </label>
		<div style="margin-left:40px">
		<div  id="auep">
		<?php 
		if (uodd_process($uodd,'F',0)=="checked")
		{
		echo ab_users($abuser,$info_holder,$adu[0]->absm,$adu[0]->absmo);		
		}
		else
		{
		echo ab_users($abuser,$info_holder,"","");
		}
		?>
		</div>
		</div>
		
		 <label class="checkbox description_check">
            <input type="checkbox" value="G" id="G" name="AU[]" <?php echo uodd_process($uodd,'G',0);?>> <?php echo dp($info_holder,"Others, please specify");?>
        </label>
		 <span style="<?php if (uodd_process($uodd,'G',0)=="checked"){ echo "padding-left:20px;";}else{echo "padding-left:20px;display:none";}?>"  id="OV"/><input type="text" value="<?php echo htmlentities(uoda_process($uodd));?>" name="OVV" id="OVV"/></span>
  		</div>
		
		<div style="clear:both">
		</div>
			
		</div>		
	      </div>

    <div id="pane2">
    <h4 style="padding-left:40px"><?php echo dp($info_holder,"Change the details about yourself");?></h4>
	
	<div style="padding-top:10px;margin-left:30px">       
    
          <div class="padme">
		  
	<div class="fileupload fileupload-new" data-provides="fileupload" >
	  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php if ($adu[0]->user_comppic !="") {echo $adu[0]->user_comppic;}else{ echo "http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image";}?>" /></div>
	  <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
	  <div>
		<span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="usercompanypic" id="usercompanypic"/></span>
		<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
			</div>
		</div>
          
		  </div>
		  
		 
          <div class="padme">
          <label for="scw_orgname" class="description boldme"><?php echo dp($info_holder,"Organization Name");?></label>
        
          <input type="text" name="scw_orgname" id="scw_orgname" value="<?php echo htmlentities($adu[0]->user_orgname,ENT_COMPAT, 'UTF-8');?>" readonly>

          </div>

          <div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Address Of Registration");?>*</label>
       
          <input type="text" name="scw_orgaddress"  id="scw_orgaddress" value="<?php echo htmlentities($adu[0]->user_orgaddress,ENT_COMPAT, 'UTF-8');?>"/>
          <span id="scw_orgaddressinfo" class="infostyle"><?php echo dp($info_holder,"What is your organization address");?>?</span>

         </div>


         <div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Country");?>*</label>
       
          <input data-items="4" data-provide="typeahead"  type="text" name="scw_orgcountry"  id="scw_orgcountry" value="<?php echo htmlentities($adu[0]->user_country);?>"/>
          <span id="scw_orgcountryinfo" class="infostyle"><?php echo dp($info_holder,"From which country you are from");?>?</span>

         </div>
		 
		  <div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Preferred Language");?></label>
       
          <select name="scwlanguage">
		  <option value="en" selected="selected"><?php echo dp($info_holder,"English");?></option>
		  <option value="zh-cn"><?php echo dp($info_holder,"Chinese");?></option>
		  </select>
          <span id="scw_languageinfo" class="infostyle"><?php echo dp($info_holder,"What is your preferred language");?>?</span>

         </div>

      <div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Name");?><span class="required">*</span></label>
       
          <input type="text" id="scw_orgepname" name="scw_orgepname" value="<?php echo htmlentities($adu[0]->user_name,ENT_COMPAT, 'UTF-8');?>"/>     
          <span id="scw_orgepnameinfo" class="infostyle"><?php echo dp($info_holder,"What is your name");?>?</span>

          </span>     
        </div>
		
         <div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Position");?><span class="required"></span></label>
       
          <input type="text" id="scw_orgempposition"  name="scw_orgempposition" value="<?php echo htmlentities($adu[0]->user_position,ENT_COMPAT, 'UTF-8');?>"/>  

          <span id="scw_orgemppositioninfo" class="infostyle"><?php echo dp($info_holder,"What is your position");?>?</span>
                  
        </div>

         <div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Email");?><span class="required"></span></label>
       
          <input type="text" name="scw_orgemail"  id="scw_orgemail" value="<?php echo htmlentities($adu[0]->user_email);?>" readonly>   

               </div>

		<div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Company Website");?></label>
       
          <input type="text" name="scw_orgweb"  id="scw_orgweb" value="<?php echo htmlentities($adu[0]->user_webaddress,ENT_COMPAT, 'UTF-8');?>"/>
          <span id="scw_orgwebinfo" class="infostyle"><?php echo dp($info_holder,"What is your ccompany website address");?>?</span>

         </div>
		 
        <div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Contact Number");?> *</label>
       
          <span>
		  <?php echo dp($info_holder,"Country Code");?>
		  </span>
		  <input type="text" name="scw_telconcode"  id="scw_telconcode" value="<?php echo htmlentities($tn[0]);?>" style="width:40px"/>
		  <span>
		  <?php echo dp($info_holder,"Area Code");?>
		   </span>
		  <input type="text" name="scw_telareacode"  id="scw_telareacode" value="<?php echo htmlentities($tn[1]);?>" style="width:40px"/>
		  <span>
		  <?php echo dp($info_holder,"Telephone Number");?>
		   </span>
		  
		  <input type="text" name="scw_orgcontact"  id="scw_orgcontact" value="<?php echo htmlentities($tn[2]);?>" style="width:120px"/>
          <span id="scw_orgcontactinfo" class="infostyle"><?php echo dp($info_holder,"What is your contact number");?>?</span>

         </div>
		 
		<div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Notification Email");?><span class="required"></span></label>
		  <input type="text" name="scw_orgnotemail" id="scw_orgnotemail" value="<?php echo htmlentities($adu[0]->user_notemail,ENT_COMPAT, 'UTF-8');?>"/>  

          <span id="scw_orgconfpassinfo" class="infostyle"><?php echo dp($info_holder,"Notification email will be sent to this email");?></span>         
              <input type="text" style="display:none" name="glocation" id="glocation" value="g"/>
        </div>  
		<div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Your Location");?><span class="required"></span></label>
		 </div>
		 
		<div class="padme">
		
		<input id="targetsearch" name="targetsearch" type="text" placeholder="Search Box" value="<?php if ($adu[0]->user_location_gmap == ""){ echo htmlentities( $adu[0]->user_orgaddress,ENT_COMPAT, 'UTF-8').", ".$adu[0]->user_country;} else{ echo htmlentities( $adu[0]->user_location_gmap,ENT_COMPAT, 'UTF-8');} ?>">
		 <input type="button" name="uploadmapinfo" id="uploadmapinfo" onclick="file_upload('#iprofile_settings')" style="margin-top:-7px" value="<?php echo dp($info_holder," Update");?>" class="btn"/>
		 <div>
		 <p><?php echo dp($info_holder,"map below uses this address");?></p>
		 </div>
		 
		 <div id="gmap" style="width:500px;height:200px">
		  
		  </div>
		 </div>
		
		
		 
		
    </div>
	
	<div id="dycupdate" style="display:none">
	<div style="padding-left:20px;padding-top:5px">
	<img src="<?php echo base_url();?>application/css/images/load.GIF"/>
	
	<?php echo dp($info_holder,"Please wait while we update your account profile.");?>
	</div>
	</div>
	<!-- Button trigger modal -->
  
  
		<script>
$('#G').change(function() {
if($("#F").is(":checked")) {
$('#G').prop('checked', false);
show_message_au(); 
}
        if($(this).is(":checked")) {
            $('#OV').show();
        }
		else
		{
		   $('#OV').hide();
		}
		});
$('#A').change(function() {
if($("#F").is(":checked")) {
$('#A').prop('checked', false); 
show_message_au(); 
}
});
$('#B').change(function() {
if($("#F").is(":checked")) {
$('#B').prop('checked', false); 
show_message_au(); 
}

});
$('#C').change(function() {
if($("#F").is(":checked")) {
$('#C').prop('checked', false); 
show_message_au(); 
}
});
$('#D').change(function() {
if($("#F").is(":checked")) {
$('#D').prop('checked', false); 
show_message_au(); 
}
});
$('#E').change(function() {
if($("#F").is(":checked")) {
$('#E').prop('checked', false); 
show_message_au(); 
}
});
$('#F').change(function() {
if($(this).is(":checked")) {
$('#auep').show();
$('#A').prop('checked', false); 
$('#B').prop('checked', false); 
$('#C').prop('checked', false); 
$('#D').prop('checked', false); 
$('#E').prop('checked', false); 
$('#G').prop('checked', false); 
}
else
{
$('#auep').hide();

}
});
function show_message_au()
{
alert("<?php echo dp($info_holder,"You have selected Abrasive users as your choice, please deselect if you want to change");?>");
}
</script>

	  
	  <!-- Buttons-->
		<div style="clear:both">
		</div>
		
		<div style="text-align:left;padding-top:40px">
		<span style="padding-left:40px">
		<input type="button" onclick="file_upload('#bonded_settings')" class="btn btn-inverse" id="signupcomplete" value="<?php echo dp($info_holder,"Save & Continue");?>" /></span>
		</div>
		  
		<!--Buttons End-->
		
		<div style="clear:both">
		</div>
    </div> 

  </div><!-- /.tab-content -->
  



</div>

<!-- iprofile end --->
<div class="tab-pane" id="bonded_settings">

<?php echo getuinfo($user_selection,$info_holder,"BMMS",$adu[0]->bmms,$adu[0]->brms,$adu[0]->bmmso,$adu[0]->brmso);?>

	<div style="padding-left:20px;padding-top:10px">
	<div>
	<p> <h4><?php echo dp($info_holder,"Type of abrasive focus");?></h4></p>
	</div>
	<?php echo getabf($user_abfb,$info_holder,$fs,"BUDT","BUDS",$adu[0]->baf);?>
	</div>
		
		<div class="padme" style="padding-left:20px">
          <label  class="description"><b><?php echo dp($info_holder,"Country of production");?></b></label>
          <input type="text" name="bonded_cprod" id="bonded_cprod" value="<?php echo $adu[0]->bcp;?>" class="typeahead" />
         </div>
		 
		  <div class="padme" style="padding-left:20px">
          <label for="bbrprod" class="description"><b><?php echo dp($info_holder,"Brand of product");?></b></label>
        
          <input type="text" name="bbrprod" id="bbrprod" value="<?php echo $adu[0]->bbp;?>"/>
		  
		  </div>	
				 
		

		 <div class="padme" style="padding-left:20px">
         <label  class="description"><b><?php if ($fs=="F"){echo dp($info_holder,"The country that you wish to buy from");}else{echo dp($info_holder,"Market of interest by country");}?></b></label>
         
         <input type="text" name="bonded_cpwish" id="bonded_cpwish" value="<?php echo $adu[0]->bmc;?>" class="typeahead" />
        
		</div>	
		 <div class="padme" style="<?php if ($fs=="F"){echo "padding-left:20px;display:none";}?>">
         <label  class="description"><b><?php if ($fs=="F"){echo dp($info_holder,"What are the industries you are interested?");}else{echo dp($info_holder,"Market of interest by industry");}?></b></label>
         
		 <div>
		<div id="indcoated">
		<br/>
		<br/>
		<br/>
		<?php echo abbonded_users($abuser,$info_holder,$adu[0]->bmi,"BSELI",$adu[0]->bseli);?>
		
		</div>
		</div>
		
		</div>	
	
	
	<div style="text-align:left;padding-top:40px">
		
		<span style="padding-left:40px">
		<input type="button" onclick="file_upload('#iprofile_settings',1)" class="btn btn-inverse" id="bondedcompleteback" value="<?php echo dp($info_holder,"<< Back");?>" />
		</span>
		
		<span style="padding-left:40px">
		<input type="button" onclick="file_upload('#coated_settings')" class="btn btn-inverse" id="bondedcomplete" value="<?php echo dp($info_holder,"Save & Continue");?>" /></span>
		</div>
		<br/>
		<br/>
		<br/>


	
	</div>

<div class="tab-pane" id="coated_settings">

	
<?php echo getuinfo($user_selectionc,$info_holder,"CMMS",$adu[0]->cmms,$adu[0]->crms,$adu[0]->cmmso,$adu[0]->crmso);?>	

	<div style="padding-left:20px">
		<div>
		<p> <h4><?php echo dp($info_holder,"Type of abrasive focus");?></h4></p>
		<!-- START TEMP-->		 
		</div>
		<?php echo getabf($user_abfc,$info_holder,$fs,"CUDT","CUDS",$adu[0]->caf);?>
	</div>
	
	<div style="padding-left:20px">
	<label><h4><?php echo dp($info_holder,"Forms of abrasives");?></h4></label>
	</div>
	
	<div style="padding-left:25px">
		<div>
		<p> <b><?php echo dp($info_holder,"Level 1 (Primary Value)");?></b></p>			 
		</div>		
		<?php echo getsecondaryprim($user_udhapri,$info_holder,$fs,"CPLA",$adu[0]->pla,$adu[0]->plat);?>			
	</div>
	
	<div style="padding-left:25px">
		<div>
		<p> <b><?php echo dp($info_holder,"Secondary Level");?></b></p>
		<?php echo getsecondaryprim($user_udhasec,$info_holder,$fs,"CSLA",$adu[0]->sla,$adu[0]->slat);?>		
		 </div>			
	</div>
	
		<div class="padme" style="padding-left:20px">
          <label  class="description"><b><?php echo dp($info_holder,"Country of production");?></b></label>
        
          <input  type="text" name="bond_prod_country" id="bond_prod_country" class="typeahead" value="<?php echo $adu[0]->ccp;?>"/>
         
		 </div>
		 
		  <div class="padme" style="padding-left:20px">
          <label for="cbrprod" class="description"><b><?php echo dp($info_holder,"Brand of product");?></b></label>
        
          <input type="text" name="cbrprod" id="cbrprod" value="<?php echo $adu[0]->cbp;?>"/>		  
		</div>
		
			
		 <div class="padme" style="padding-left:20px">
          <label  class="description"><b><?php if ($fs=="F"){echo dp($info_holder,"The country that you wish to buy from");}else{echo dp($info_holder,"Market of interest by country");}?></b></label>
        
          <input type="text" name="coated_cpwish" id="coated_cpwish" value="<?php echo $adu[0]->cmc;?>" class="typeahead" />
        
		
		</div>	
		
		<div class="padme" style="<?php if ($fs=="F"){echo "padding-left:20px;display:none";}?>">
         <label class="description"><b><?php if ($fs=="F"){echo dp($info_holder,"What are the industries you are interested?");}else{echo dp($info_holder,"Market of interest by industry");}?></b></label>
         
         <div style="">
		<div  id="indcoated">
		<br/>
		<br/>
		<br/>
		
		<?php echo abcoated_users($abuser,$info_holder,$adu[0]->cmi,"CSELI",$adu[0]->cseli);?>
		
		</div>
		</div>
		</div>	
		<div style="text-align:left;padding-top:40px">
		
		<span style="padding-left:40px">
		<input type="button" onclick="file_upload('#bonded_settings',1)" class="btn btn-inverse" id="coatedcompleteback" value="<?php echo dp($info_holder,"<< Back");?>" />
		</span>
		
		<span style="padding-left:40px">
		<input type="button" onclick="file_upload('#subscr_req')" class="btn btn-inverse" id="coatedcomplete" value="<?php echo dp($info_holder,"Save & Continue");?>" /></span>
		</div>
		<br/>
		<br/>
		<br/>
		
		 
		
	</form>	
	
</div>	
<style>
.centerme
{
text-align:center;
}
</style>
<div class="tab-pane" id="subscr_req">

<hr>
<div style="padding-left:20px">
<p><b style="color:orange"><?php echo dp($info_holder,"if you have coupon, enter the code and click submit.");?></b></p>
<div>
<?php echo dp($info_holder,"Coupon Code");?> : <input id="couponcode" type="text" name="ccode" style="width:120px"/>
<span>
<input type="button" id="couponvalidate" value="<?php echo dp($info_holder,"Submit");?>" class="btn" style="margin-top:-8px"/>
</span>

<span id="couponverify" style="display:none">
<b style="color:gray"><?php echo dp($info_holder,"Please wait while we validate your coupon data ...");?>
</b>
</span>

</div>
</div>

</hr>
	<div style="padding-left:20px">
	<div>
	<table>
	<tr>
	<th colspan="2">
	<hr>
	</th>
	</tr>
	<tr>
	<th style="text-align:left">
	<b><?php echo dp($info_holder,"Feature");?></b>
	</th>
	<th style="text-align:left;margin-left:25px">
	<b><?php echo dp($info_holder,"Membership Signup");?></b>
	</th>
	</tr>
	<tr>
	<td colspan="2">
	
	</td>
	</tr>
	<tr>
	<td>
	<label class="checkbox description_check">
         <input type="checkbox" value="option3" id="inlineCheckbox3" disabled><?php echo dp($info_holder,"allow members to find my fact sheets");?>
    </label>
	</td>
	<td class="centerme">
	<?php echo dp($info_holder,"No Cost");?>
	</td>
	
	</tr>
	<tr>
	<td>
	<label class="checkbox description_check">
         <input type="checkbox" value="option3" id="sub_allowemails" <?php echo free_modules($freemodules,"sub_allowemails",0);?>><?php echo dp($info_holder,"allow both advertised article and editorial message to my email");?> <?php echo free_modules($freemodules,"sub_allowemails",1);?>
    </label>
	</td>
	<td  class="centerme">
	<?php echo dp($info_holder,"No Cost");?>
	</td>
	
	</tr>
	
	<tr>
	<td>
	<label class="checkbox description_check">
         <input type="checkbox" value="option3" id="sub_searchprefer" <?php echo free_modules($freemodules,"sub_searchprefer",0);?>><?php echo dp($info_holder,"allow me to search members to my specified role");?> <?php echo free_modules($freemodules,"sub_searchprefer",1);?>
    </label>
	</td>
	<td  class="centerme">
	<?php echo dp($info_holder,"USD 88 per year");?>
	</td>
	
	</tr>

	<tr>
	<td style="text-align:left">
	<b>
    <?php echo dp($info_holder,"I want to post article");?>
    </b>
	</td>
	<td  class="centerme">
	
	</td>
	</tr>
	
	<tr>
	<td>
	<label class="checkbox description_check" >
         <input type="checkbox" class="rfqarticlesubsa" value="option3" id="sub_onceweekly" <?php echo subs_check($subsd,$issubs,"sub_onceweekly");?>><?php echo dp($info_holder,"once weekly- will include RFQ feature");?> <?php echo subs_check($subsd,$issubs,"sub_onceweekly",1);?>
    </label>
	</td>
	<td  class="centerme">
	<?php echo dp($info_holder,"USD 1288 per year");?>
	</td>
	</tr>
	<tr>
	<td>
	<label class="checkbox description_check" >
         <input type="checkbox" class="marticleuploadp" value="option3" id="sub_imageupload" <?php echo subs_check($subsd,$issubs,"sub_imageupload");?>><?php echo dp($info_holder,"image upload");?> <?php echo subs_check($subsd,$issubs,"sub_imageupload",1);?>
    </label>
	</td>
	<td  class="centerme">
	<?php echo dp($info_holder,"USD 288 per year");?>
	</td>
	</tr>
	
	<tr>
	<td>
	<label class="checkbox description_check" >
    <input type="checkbox" class="marticleuploadp" value="option3" id="sub_videoupload" <?php echo subs_check($subsd,$issubs,"sub_videoupload");?>><?php echo dp($info_holder,"video upload");?> <?php echo subs_check($subsd,$issubs,"sub_videoupload",1);?>
    </label>
	</td>
	<td  class="centerme">
	<?php echo dp($info_holder,"USD 388 per year");?>
	</td>
	</tr>
	<tr>
	<td>
	<label class="checkbox description_check" >
         <input type="checkbox" class="marticleuploadp" value="option3" id="inlineCheckbox3" disabled><?php echo dp($info_holder,"allow article to reach out to specific members");?>
    </label>
	</td>
	<td  class="centerme">
	<?php echo dp($info_holder,"USD 488 per year");?>
	</td>
	</tr>
	
	
	<tr>
	<td style="text-align:left">
	<b>
    <?php echo dp($info_holder,"I want to participate in RFQ");?>
    </b>
	</td>
	<td  class="centerme">
	
	</td>
	</tr>
	
	<tr>
	<td>
	<label class="checkbox description_check" >
         <input type="checkbox" class="rfqarticlesubs" value="option3" id="sub_rfqsender" <?php echo subs_check($subsd,$issubs,"sub_onceweekly");?>><?php echo dp($info_holder,"RFQ Sender- will include Article Feature(once weekly)");?> <?php echo subs_check($subsd,$issubs,"sub_onceweekly",1);?>
    </label>
	</td>
	<td  class="centerme">
	<?php echo dp($info_holder,"Only available with posting of article(once weekly)");?>
	</td>
	</tr>

	
	<tr>
	<td>
	<label class="checkbox description_check" >
         <input type="checkbox" value="option3" id="sub_rfqbidder" <?php echo subs_check($subsd,$issubs,"sub_onceweekly");?>><?php echo dp($info_holder,"RFQ Bidder");?> <?php echo subs_check($subsd,$issubs,"sub_onceweekly",1);?>
    </label>
	</td>
	<td  class="centerme">
	<?php echo dp($info_holder,"No Cost");?>
	</td>
	</tr>
	<tr>
	<td colspan="2">
	<hr>
	</td>
	</tr>
	<tr>
	<td>
	
    <b><?php echo dp($info_holder,"Advertisements");?></b>
    
	</td>
	<td  class="centerme">
	</td>
	</tr>
	<tr>
	<td colspan="2">
	<label class="checkbox description_check">
	<input type="checkbox" value="advertisercheck" id="advertisercheck"><?php echo dp($info_holder,"For platinum and gold advertiser, please contact our sales");?>
	</label>
	</td>
	</tr>
	<tr style="display:none">
	<td>
	<label class="checkbox description_check" style="padding-left:60px">
         <input type="checkbox" value="platadvertid" id="platadvertid"><?php echo dp($info_holder,"platinum advertiser");?>
    </label>
	</td>
	
	<td  class="centerme">
	<?php echo dp($info_holder,"USD 1888 per year");?><br/>
	
	 <div style="padding-top:10px"> <b><?php echo dp($info_holder,"months");?></b> <input type="text" id="platadvertv" name="platadvertv" value="12" style="width:40px"/></div>
	</td>
	
	</tr>
	<tr style="display:none">
	<td>
	<label class="checkbox description_check" style="padding-left:60px">
         <input type="checkbox" value="goldadvertid" id="goldadvertid"><?php echo dp($info_holder,"gold advertiser");?>
    </label>
	</td>
	<td  class="centerme">
	<?php echo dp($info_holder,"USD 888 per year");?><br/>
	
	 <div style="padding-top:10px"> <b><?php echo dp($info_holder,"months");?></b> <input type="text" name="goldadvertv" id="goldadvertv" value="12" style="width:40px"/></div>
	</td>
	</tr>
	<tr>
	<td colspan="2">
	<hr>
	</td>
	</tr>
	
	<tr>
	<td colspan="2">
	<b><?php echo dp($info_holder,"Endorser");?></b>
	</td>
	</tr>
	
	<tr>
	<td colspan="2">
	<label class="checkbox description_check">
         <input type="checkbox" value="endorsercheck" id="endorsercheck" <?php if ($adu[0]->is_endorser==1){echo "disabled";}?>>
	<?php if ($adu[0]->is_endorser==1){ echo "<i class='icon-ok'></i>";}?>
	<?php echo dp($info_holder,"corporate endorser");?>
    </label>
	<div>
	<p>
	<?php echo dp($info_holder,"Companies or individuals who are recognized in the abrasive industry and it has significant contribution to the communities. we will come backto you to validate your crediblity.");?>
	</p>
	</div>
	<div style="margin-bottom:14px">
	<span style="padding-left:40px">
		<input type="button" onclick="file_upload('#coated_settings',1)" class="btn btn-inverse" id="subscompleteback" value="<?php echo dp($info_holder,"<< Back");?>" />
	</span>
		
	<input type="button" class="btn btn-info" onclick="payment_process();" value="<?php echo dp($info_holder,"Proceed to checkout");?>"/>
	</div>
	</td>
	</tr>
	
	
	
	</table>
	
	</div>
	</div>
</div>


</div>

  <!-- Modal -->
  <div style="display:none" class="modal fade" id="paymentModal" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><?php echo dp($info_holder,"Subscription Summary Information");?></h4>
        </div>
        <div class="modal-body" id="subsinfoupdate">    
    
        </div>
        <div class="modal-footer">
			<div style="text-align:left">
			<span>
			 <button type="button" class="btn btn-default" onclick="pp();"><b><?php echo dp($info_holder,"Proceed to payment");?>
			 </b>
			 </button>         
			</span>
			<span>
		 <button type="button" class="btn btn-default" data-dismiss="modal">
		 <b>
		 <?php echo dp($info_holder,"Close");?>
		 </b>
		 </button>
			</span>
		 </div>
		 <div>
		<img src="<?php echo base_url();?>application/img/allcards.png" alt="Payment"/>
		</div>
		
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  </div>

<!-- Coupon Modal -->
  <div style="display:none" class="modal fade" id="couponModal" tabindex="-2" role="dialog" aria-labelledby="couponLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><?php echo dp($info_holder,"Coupon Validation");?></h4>
        </div>
        <div class="modal-body" id="cousinfoupdate">    
		<b><?php echo dp($info_holder,"You coupon is successfully validated.");?></b>
        </div>
        <div class="modal-footer">
			<div style="text-align:left">
			
		 <button id="couponreload" type="button" class="btn btn-default">
		 <b>
		 <?php echo dp($info_holder,"OK");?>
		 </b>
		 </button>			
		 </div>
		 
		
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>
  </div><!-- /.modal -->
  
  
  <!-- Endorser Modal -->
  <div style="display:none" class="modal fade" id="endorserModal" tabindex="-2" role="dialog" aria-labelledby="endorserLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><?php echo dp($info_holder,"Endorser Form");?></h4>
        </div>
        <div class="modal-body" id="endinfoupdate">    	
			<div style="padding-left:30px;padding-right:30px;padding-top:20px;font-size:14px;line-height:20px">
				<form id="fcontact">
				  <div>
						<div>
							<label><?php echo dp($info_holder,"First Name");?></label>
							<input type="text" name="fname" value="<?php echo htmlentities($adu[0]->user_name);?>" class="span3" placeholder="<?php echo dp($info_holder,"Your First Name");?>">
							<label><?php echo dp($info_holder,"Last Name")?></label>
							<input type="text" name="lname" class="span3" placeholder="<?php echo dp($info_holder,"Your Last Name");?>">
							<label><?php echo dp($info_holder,"Email Address");?></label>
							<input type="text" value="<?php echo htmlentities($adu[0]->user_email);?>" name="emailaddress" class="span3" placeholder="<?php echo dp($info_holder,"Your email address");?>">
							<label><?php echo dp($info_holder,"Subject");?></label>
							<select id="subject" name="subject" class="span3">
								<option value="endorser" selected=""><?php echo dp($info_holder,"Endorser");?></option>
							
						</select>
						</div>
						<div>
							<label><?php echo dp($info_holder,"Message");?></label>
							<textarea name="message" id="message" class="input-xlarge span5" rows="4"></textarea>
						</div>
					
						
					</div>
					
					
					
				</form>
			</div>
		
        </div>
        <div class="modal-footer">
			<div style="text-align:left">
			
		
		 <button onclick="endorser_submit();" id="endorsersubmit" class="btn btn-primary"><?php echo dp($info_holder,"Submit");?></button>
	
		 </button>			
		 </div>
		 
		
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>
  </div><!-- /.modal -->
  
  
  
  
  <!-- Advertiser Modal -->
  <div style="display:none" class="modal fade" id="advertiserModal" tabindex="-2" role="dialog" aria-labelledby="advertLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><?php echo dp($info_holder,"Advertiser Form");?></h4>
        </div>
        <div class="modal-body" id="endinfoupdate">    	
			<div style="padding-left:30px;padding-right:30px;padding-top:20px;font-size:14px;line-height:20px">
				<form id="acontact">
				  <div>
						<div>
							<label><?php echo dp($info_holder,"First Name");?></label>
							<input type="text" name="fname" value="<?php echo htmlentities($adu[0]->user_name);?>" class="span3" placeholder="<?php echo dp($info_holder,"Your First Name");?>">
							<label><?php echo dp($info_holder,"Last Name")?></label>
							<input type="text" name="lname" class="span3" placeholder="<?php echo dp($info_holder,"Your Last Name");?>">
							<label><?php echo dp($info_holder,"Email Address");?></label>
							<input type="text" value="<?php echo htmlentities($adu[0]->user_email);?>" name="emailaddress" class="span3" placeholder="<?php echo dp($info_holder,"Your email address");?>">
							<label><?php echo dp($info_holder,"Subject");?></label>
							<select id="subject" name="subject" class="span3">
								<option value="advertiser" selected=""><?php echo dp($info_holder,"Advertiser");?></option>
							
						</select>
						</div>
						<div>
							<label><?php echo dp($info_holder,"Message");?></label>
							<textarea name="message" id="message" class="input-xlarge span5" rows="4"></textarea>
						</div>
					
						
					</div>
					
					
					
				</form>
			</div>
		
        </div>
        <div class="modal-footer">
			<div style="text-align:left">
			
		
		 <button onclick="advertiser_submit();" id="advertisersubmit" class="btn btn-primary"><?php echo dp($info_holder,"Submit");?></button>
	
		 </button>			
		 </div>
		 
		
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>
  </div><!-- /.modal -->
  
  
  
  
  <!-- Modal -->
  <div style="display:none" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><?php echo dp($info_holder,"Profile Update");?></h4>
        </div>
        <div class="modal-body" id="svauth">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"  style="display:none"><?php echo dp($info_holder,"Close");?></button>
         </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  
<script>

var gtr;
$( ".oplse" ).click(function() {
 gtr=this;
 if ($(gtr).is(':checked')==true)
 {
 gtr.parentElement.nextElementSibling.style.display="inherit";
 }
 else
 {
 gtr.parentElement.nextElementSibling.style.display="none";
 
 }
});


  $('.nav-tabs a').click(function (e) {
  e.preventDefault()
   $(this).tab('show');
   var scrollmem = $('body').scrollTop();
  window.location.hash = this.hash;
  $('body').scrollTop(0);
  });

function get_subs()
{
var bua = {
    subs: []
}; 
var bu="";
	if ($('#sub_searchprefer').is(':checked'))
	{
	bu += "sub_searchprefer=yes&";
	}
	else
	{
	bu += "sub_searchprefer=no&";
	}
	
	if ($('#sub_allowemails').is(':checked'))
	{
	bu += "sub_allowemails=yes&";
	}
	else
	{
	bu += "sub_allowemails=no&";
	}
	
	if ($('#sub_onceweekly').is(':checked'))
	{
	bu += "sub_onceweekly=yes&";
	}
	else
	{
	bu += "sub_onceweekly=no&";
	}
	
	if ($('#sub_imageupload').is(':checked'))
	{
	bu += "sub_imageupload=yes&";
	}
	else
	{
	bu += "sub_imageupload=no&";
	}
	
	if ($('#sub_videoupload').is(':checked'))
	{
	bu += "sub_videoupload=yes&";
	}
	else
	{
	bu += "sub_videoupload=no&";
	}
return bu;	
}
function payment_process()
{
var subsd= get_subs();
$.ajax({
    url : "../payment/summary_show",
	data:subsd,
	type:'POST',
    success: function(data, textStatus, jqXHR)
    {	
	$("#subsinfoupdate").html(data);	
	$("#paymentModal").modal();
	},
    error: function (jqXHR, textStatus, errorThrown)
    {
	
    }
});
}
</script>
<script>
function pp()
{
if ($("#pamount").val()== "0")
{
alert("Selected modules are actiavted");
free_modules();
}
else
{
$("#paypalsubmit").click();
}

}

$('#couponvalidate').click(function (e) {
   $("#couponverify").show();
   validate_coupon();
 });

$('#endorsercheck').click(function (e) {
if ($('#endorsercheck').is(':checked') && $("#endorsercheck").attr("disabled") != "disabled")
{
$("#endorserModal").modal();
} 
});
 
$('#advertisercheck').click(function (e) {
if ($('#advertisercheck').is(':checked') && $("#advertisercheck").attr("disabled") != "disabled")
{
$("#advertiserModal").modal();
} 
}); 
$('#couponreload').click(function (e) {
  location.reload();
 });
 function validate_coupon()
 {
 var subsd="coupon_id="+$("#couponcode").val();
 $.ajax({
    url : "../payment/coupon_verify",
	data:subsd,
	type:'POST',
    success: function(data, textStatus, jqXHR)
    {
	if (data == "1")
	{
	$("#couponModal").modal();
	$("#couponverify").hide();
	}
	else if(data=="100")
	{
	alert(" <?php echo dp($info_holder,"This coupon had been used already");?>");
	$("#couponverify").hide();
	}
	else
	{
	alert(" <?php echo dp($info_holder,"Not a valid coupon, please retry");?>");
	$("#couponverify").hide();
	}
	},
    error: function (jqXHR, textStatus, errorThrown)
    {
	alert("<?php echo dp($info_holder,"OOPS, something went wrong");?>");
    }
});
 }
 
function advertiser_submit()
{
alert("<?php echo dp($info_holder,"Thanks for your interest for supporting us, we will contact you as soon as possible");?>");
$("#advertiserModal").modal('hide');
var etrace;
$.ajax({url:"../abrasivesworld/contact_us_save",type:"POST",data:$("#acontact").serialize(),success:function(response) {
etrace=response;	
  },error:function(){
 alert("OOPS, something went wrong");
 }});
}

function endorser_submit()
{
alert("<?php echo dp($info_holder,"Thanks for your interest for supporting us, we will contact you as soon as possible");?>");
$("#endorsercheck").attr("disabled","disabled");
$("#endorserModal").modal('hide');
var etrace;
$.ajax({url:"../abrasivesworld/contact_us_save",type:"POST",data:$("#fcontact").serialize(),success:function(response) {
etrace=response;	
  },error:function(){
 alert("OOPS, something went wrong");
 }});
}
function free_modules()
{
var subsd= get_subs();
$.ajax({
    url : "../payment/free_modules",
	data:subsd,
	type:'POST',
    success: function(data, textStatus, jqXHR)
    {	
	 location.reload(); 
	},
    error: function (jqXHR, textStatus, errorThrown)
    {
	
    }
});

} 

</script>
<!-- Profile Tab Content End-->
</div>
</div> 
</div>
<style>
::-webkit-scrollbar {
	width: 8px;
}
::-webkit-scrollbar-button {
	width: 8px;
	height:5px;
}
::-webkit-scrollbar-track {
	background:whitesmoke;
	border: skinny plain lightgray;
	box-shadow: 0px 0px 3px #dfdfdf inset;
	
}
::-webkit-scrollbar-thumb {
	background:gray;
	border: skinny plain gray;
	
}
::-webkit-scrollbar-thumb:hover {
	background:gray;
</style>
<script>
$('.nav-tabs a[href="' + window.location.hash + '"]').tab('show');

//var scrollmem = $('body').scrollTop();
$('body').scrollTop(0);
   
</script>

<script>
var country_list = ['Others'];
var country1_list = ['Others'];
var country2_list = ['Others'];
 
$('#scw_orgcountry').typeahead({source: country_list});
//$('#bond_prod_country').typeahead({source: country1_list});
//$('#bonded_cprod').typeahead({source: country2_list});

$.getJSON('<?php echo base_url();?>general/country_list', function(data) {
   $.each(data, function(key, val) {
   country_list.push(val.country_name);
   country1_list.push(val.country_name);
   country2_list.push(val.country_name);
  });
});
/*
$("#glocation").val(lati+","+longi);
$("#dycupdate").show();
$.ajax({
url:"save_edited_profile",type:"POST",
enctype: 'multipart/form-data',
data:$("#customForm").serialize(),success:function(response) {
etrace=response;
	$('#svauth').html(response);
	$('#myModal').modal();
	$("#dycupdate").hide();
  },error:function(){
 
  alert("OOPS, something went wrong");
 $("#dycupdate").hide();
 }});
 
return false;

});
*/
function file_upload($wherets,$r)
{
get_location();
$("#glocation").val(lati+","+longi);
$('#svauth').html("<?php echo "Please wait while we update your data."; ?>");
$('#myModal').modal();
$('#usercompanypic').upload('save_edited_profile',$('#customForm').serialize(), function(res) 
{
$('#svauth').html(res);
window.location.hash=$wherets;
location.reload();
$('body').scrollTop(0);
});
}
function extractor(query) {
    var result = /([^,]+)$/.exec(query);
    if(result && result[1])
        return result[1].trim();
    return '';
}

$('.typeahead').typeahead({
    source: country_list,
    updater: function(item) {
        return this.$element.val().replace(/[^,]*$/,'')+item+',';
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


$( ".marticleuploadp" ).change(function() {
if ($('.rfqarticlesubsa').is(":checked")==true)
{
//$( this).prop("checked",true);
}
else
{
$( ".marticleuploadp").prop("checked",false);
}
}); 

$( ".rfqarticlesubsa" ).change(function() {
if ($(this).is(":checked")==true)
{
$( ".rfqarticlesubs").prop("checked",true);
}
else
{
$( ".rfqarticlesubs").prop("checked",false);
$( ".marticleuploadp").prop("checked",false);

}
}); 

$( ".rfqarticlesubs" ).change(function() {
if ($(this).is(":checked")==true)
{
$( ".rfqarticlesubsa").prop("checked",true);
}
else
{
$( ".rfqarticlesubsa").prop("checked",false);
}
}); 
</script> 
