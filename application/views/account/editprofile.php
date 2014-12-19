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
function initialize() {

 markers = [];
  map = new google.maps.Map(document.getElementById('gmap'), {
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });

 defaultBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(-33.8902, 151.1759));
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
    }

    map.fitBounds(bounds);
	map.setZoom(14);
  });

  // Bias the SearchBox results towards places that are within the bounds of the
  // current map's viewport.
  google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();
    searchBox.setBounds(bounds);
  });
  map.setZoom(14);
}
      google.maps.event.addDomListener(window, 'load', initialize);
	 
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
<div id="main_container" class="main_container">
<div>    
<div class="header_text">
<div style="margin-left:30px;">
<span style="padding-right:20px">
<i class="icon-user"></i><span style="padding-left:5px"><a style="color:orange" href="<?php echo base_url();?>account/edit_profile"><b><?php echo dp($info_holder,"Edit my profile");?></b></a></span></span>
<span style="padding-right:20px"><i class="icon-lock"></i><span style="padding-left:5px"><a  style="color:white" href="<?php echo base_url();?>account/change_password"><?php echo dp($info_holder,"Change password");?></a></span></span>
<span style="padding-right:20px"><i class="icon-edit"></i><span style="padding-left:5px"><a style="color:white" href="<?php echo base_url();?>account/download_factsheet"><?php echo dp($info_holder,"Download factsheet");?></a></span></span>
<span style="padding-right:20px"><i class="icon-edit"></i><span style="padding-left:5px"><a style="color:white" href="<?php echo base_url();?>my_article"><?php echo dp($info_holder,"Article Management");?></a></span>
</span>
</div>
</div> 

<hr/>


<div id="maincon">
<div class="tab-content">
<form method="post" id="customForm">
    <div id="pane1" class="tab-pane active">
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
            <input type="checkbox" value="C" id="C" name="AU[]" <?php echo uodd_process($uodd,'C',0);?>> <?php echo dp($info_holder,"Abrasive Producer (Bonded,Coated)");?>
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
		<div style="display:none" id="auep">
		<?php echo ab_users($abuser,$info_holder);?> 
		</div>
		</div>
		
		 <label class="checkbox description_check">
            <input type="checkbox" value="G" id="G" name="AU[]" <?php echo uodd_process($uodd,'G',0);?>> <?php echo dp($info_holder,"Others, please specify");?>
        </label>
		 <span style="padding-left:20px;display:none"  id="OV"/><input type="text" value="<?php echo htmlentities(uoda_process($uodd));?>" name="OVV" id="OVV"/></span>
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
        
          <input type="text" name="scw_orgname" id="scw_orgname" value="<?php echo htmlentities($adu[0]->user_orgname);?>" readonly>

          </div>

          <div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Address Of Registration");?>*</label>
       
          <input type="text" name="scw_orgaddress"  id="scw_orgaddress" value="<?php echo htmlentities($adu[0]->user_orgaddress);?>"/>
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
       
          <input type="text" id="scw_orgepname" name="scw_orgepname" value="<?php echo htmlentities($adu[0]->user_name);?>"/>     
          <span id="scw_orgepnameinfo" class="infostyle"><?php echo dp($info_holder,"What is your name");?>?</span>

          </span>     
        </div>
		
         <div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Position");?><span class="required"></span></label>
       
          <input type="text" id="scw_orgempposition"  name="scw_orgempposition" value="<?php echo htmlentities($adu[0]->user_position);?>"/>  

          <span id="scw_orgemppositioninfo" class="infostyle"><?php echo dp($info_holder,"What is your position");?>?</span>
                  
        </div>

         <div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Email");?><span class="required"></span></label>
       
          <input type="text" name="scw_orgemail"  id="scw_orgemail" value="<?php echo htmlentities($adu[0]->user_email);?>" readonly>   

               </div>

		<div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Company Website");?></label>
       
          <input type="text" name="scw_orgweb"  id="scw_orgweb" value="<?php echo htmlentities($adu[0]->user_webaddress);?>"/>
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
		  <input type="text" name="scw_orgnotemail" id="scw_orgnotemail" value="<?php echo htmlentities($adu[0]->user_notemail);?>"/>  

          <span id="scw_orgconfpassinfo" class="infostyle"><?php echo dp($info_holder,"Notification email will be sent to this email");?></span>         
              <input type="text" style="display:none" name="glocation" id="glocation" value="g"/>
        </div>  
		<div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Your Location");?><span class="required"></span></label>
		 </div>
		 
		<div class="padme">
		
		<input id="targetsearch" type="text" placeholder="Search Box" value="<?php echo htmlentities( $adu[0]->user_orgaddress).", ".$adu[0]->user_country; ?>">
		 
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
  
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><?php echo dp($info_holder,"Profile Update");?></h4>
        </div>
        <div class="modal-body" id="svauth">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo dp($info_holder,"Close");?></button>
         </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  
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
		<input type="button" onclick="file_upload()" class="btn" id="signupcomplete" value="<?php echo dp($info_holder,"Update");?>" /></span>
		</div>
		  
		<!--Buttons End-->
		
		<div style="clear:both">
		</div>
    </div> 
</form>	
  </div><!-- /.tab-content -->
  

</div>  

</div>
</div>

<script>
 var country_list = ['Others']; 
$('#scw_orgcountry').typeahead({source: country_list})
$.getJSON('<?php echo base_url();?>general/country_list', function(data) {
   $.each(data, function(key, val) {
   country_list.push(val.country_name);
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
function file_upload()
{
get_location();
$("#glocation").val(lati+","+longi);
$('#svauth').html("<?php echo "Please wait while we update your data."; ?>");
$('#myModal').modal();
$('#usercompanypic').upload('save_edited_profile',$('#customForm').serialize(), function(res) 
{

$('#svauth').html(res);

});
}
</script> 