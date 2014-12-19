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
return $rt;
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
?>

<?php
$tn=explode("-",$adu[0]->user_contactno);
?>
<div id="main_container" class="main_container" style="min-height:700px">
<div>    

<div class="header_text">
<b style="color:orange"><?php echo dp($info_holder,"Abraisvesworld Public Profile Of The Organazation Name :");?> <?php echo htmlentities($adu[0]->user_orgname);?>
</b>		
</div>
</div>

<div id="maincon">
<!--Content Start -->
<div>
    <div id="pane1">
      <div>	
		<div class="controls span2" style="width:300px">
        <label class="checkbox description_check">
            <input type="checkbox" value="A" id="A" name="AU[]" <?php echo uodd_process($uodd,'A',0);?> disabled="disabled"> <?php echo dp($info_holder,"Machine / Equipment  Supplier");?>
        </label>
        <label class="checkbox description_check">
            <input type="checkbox" value="B" id="B" name="AU[]" <?php echo uodd_process($uodd,'B',0);?> disabled="disabled"> <?php echo dp($info_holder,"Raw Material Supplier");?>
        </label>
        <label class="checkbox description_check">
            <input type="checkbox" value="C" id="C" name="AU[]" <?php echo uodd_process($uodd,'C',0);?> disabled="disabled"> <?php echo dp($info_holder,"Abrasive Producer (Bonded,Coated)");?>
        </label>
        <label class="checkbox description_check">
            <input type="checkbox" value="D" id="D" name="AU[]" <?php echo uodd_process($uodd,'D',0);?> disabled="disabled"> <?php echo dp($info_holder,"Coated Abrasive Converter");?>
        </label>
		
		<label class="checkbox description_check">
            <input type="checkbox" value="E" id="E" name="AU[]" <?php echo uodd_process($uodd,'E',0);?> disabled="disabled"> <?php echo dp($info_holder,"Distributor( Bonded or Coated Abrasive)");?>
        </label>
        <label class="checkbox description_check">
            <input type="checkbox" value="F" id="F" name="AU[]" <?php echo uodd_process($uodd,'F',0);?> disabled="disabled"> <?php echo dp($info_holder,"Abrasive Users");?>
			
        </label>
		<div style="margin-left:40px">
		<div style="display:none" id="auep">
		<?php echo ab_users($abuser,$info_holder);?> 
		</div>
		</div>
		
		 <label class="checkbox description_check">
            <input type="checkbox" value="G" id="G" name="AU[]" <?php echo uodd_process($uodd,'G',0);?> disabled="disabled"> <?php echo dp($info_holder,"Others, please specify");?>
        </label>
		 <span style="padding-left:20px;display:none"  id="OV"/><input type="text" value="<?php echo htmlentities(uoda_process($uodd));?>" name="OVV" id="OVV" disabled="disabled"/></span>
  		</div>
		<div style="clear:both">
		</div>
			
		</div>		
	      </div>

    <div id="pane2">
  
	<div style="padding-top:10px;margin-left:30px">    		  
	<div class="padme">	
		<div><img style="width:100px;height:100px"src="<?php if ($adu[0]->user_comppic !="") {echo $adu[0]->user_comppic;}else{ echo "http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image";}?>" /></div>
    </div>
	<div class="padme">
          <label for="scw_orgname" class="description boldme"><?php echo dp($info_holder,"Organization Name");?></label>
          <input type="text" name="scw_orgname" id="scw_orgname" value="<?php echo htmlentities($adu[0]->user_orgname);?>" readonly>
   </div>
   <div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Address Of Registration");?></label>
          <input type="text" name="scw_orgaddress"  id="scw_orgaddress" value="<?php echo htmlentities($adu[0]->user_orgaddress);?>" disabled="disabled"/>
        </div>
	<div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Country");?></label>
        <input data-items="4" data-provide="typeahead"  type="text" name="scw_orgcountry"  id="scw_orgcountry" value="<?php echo htmlentities($adu[0]->user_country);?>" disabled="disabled"/>
     </div>
	<div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Preferred Language");?></label>
          <select name="scwlanguage" disabled="disabled">
		  <option value="en" selected="selected"><?php echo dp($info_holder,"English");?></option>
		  <option value="zh-cn"><?php echo dp($info_holder,"Chinese");?></option>
		  </select>
      
    </div>
	
	<div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Email");?><span class="required"></span></label>
          <input type="text" name="scw_orgemail"  id="scw_orgemail" value="<?php echo htmlentities($adu[0]->user_email);?>" readonly disabled="disabled">   
    </div>
	
	<div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Company Website");?></label>
         <input type="text" name="scw_orgweb"  id="scw_orgweb" value="<?php echo htmlentities($adu[0]->user_webaddress);?>" disabled="disabled"/>
     </div>
	<div class="padme">
          <label class="description boldme"><?php echo dp($info_holder,"Contact Number");?> *</label>
          <span>
		  <?php echo dp($info_holder,"Country Code");?>
		  </span>
		  <input type="text" name="scw_telconcode"  id="scw_telconcode" value="<?php echo htmlentities($tn[0]);?>" style="width:40px" disabled="disabled"/>
		  <span>
		  <?php echo dp($info_holder,"Area Code");?>
		   </span>
		  <input type="text" name="scw_telareacode"  id="scw_telareacode" value="<?php echo htmlentities($tn[1]);?>" style="width:40px" disabled="disabled"/>
		  <span>
		  <?php echo dp($info_holder,"Telephone Number");?>
		   </span>
		  
		  <input type="text" name="scw_orgcontact"  id="scw_orgcontact" value="<?php echo htmlentities($tn[2]);?>" style="width:120px" disabled="disabled"/>
    </div>
	
 
	<div class="padme">
    <label class="description boldme"><?php echo dp($info_holder,"Location");?><span class="required"></span></label>
	</div>
		 
   <div class="padme">
		<input id="targetsearch" type="text" placeholder="Search Box" value="<?php echo htmlentities( $adu[0]->user_orgaddress).", ".$adu[0]->user_country; ?>" disabled="disabled">
		 
    <div>
		 <p><?php echo dp($info_holder,"map below uses this address");?></p>
		 </div>
		 
		 <div id="gmap" style="width:500px;height:200px">
		  
		  </div>
	</div>
		
		
		 
		
    </div>
	  
    </div> 

 </div>
 

<!--Content End-->
</div>

</div>
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
	map.setZoom(14);
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });

}

function initialize(lat,lng) {

 markers = [];

  map = new google.maps.Map(document.getElementById('gmap'), {
    mapTypeId: google.maps.MapTypeId.ROADMAP,
	zoom:14
	
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
  map.fitBounds(defaultBounds);
map.setZoom(14);		

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
	  	map.setZoom(14);
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
