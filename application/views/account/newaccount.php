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
function ab_users(& $abuserl, & $hc)
{
  $divg="";
  foreach ($abuserl as &$value) 
  {

   $divg .='<div class="checkbox"><label>
   <input type="checkbox" value="'.$value->au_id.'" id="ABL" name="ABL[]"> '.dp($hc,$value->au_category).'
 </label></div>'
 ;
}
$divg .= "";
return $divg;
}
?>
<div class="container" style="margin-top:10px">
<div  class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo dp($info_holder,"Abrasives World Account");?></h3>
  </div> 
  <div class="panel-body">
    <h5><?php echo dp($info_holder,"Welcome to Abrasives World");?></h5>
    <div class="container">
      <h4><?php echo dp($info_holder,"Are you a");?></h4>
      <form method="post" id="customForm" action="<?php echo base_url();?>/account/my_profile" role="form">
        <div class="checkbox">
          <label>
            <input type="checkbox" value="A" id="A" name="AU[]"> <?php echo dp($info_holder,"Machine / Equipment  Supplier");?>
            <?php echo dp($info_holder,"Machine / Equipment  Supplier");?>
          </label>
        </div>
        <div class="checkbox">
         <label>
          <input type="checkbox" value="B" id="B" name="AU[]"> <?php echo dp($info_holder,"Raw Material Supplier");?>
        </label>
      </div>
      <div class="checkbox">
        <label>
          <input type="checkbox" value="C" id="C" name="AU[]"> <?php echo dp($info_holder,"Abrasive Producer (Bonded)");?>
        </label>
      </div>
      <div class="checkbox">
        <label>
          <input type="checkbox" value="Z" id="Z" name="AU[]"> <?php echo dp($info_holder,"Abrasive Producer (Coated)");?>
        </label>
      </div>
      <div class="checkbox">
        <label>
          <input type="checkbox" value="D" id="D" name="AU[]"> <?php echo dp($info_holder,"Coated Abrasive Converter");?>
        </label>
      </div>
      <div class="checkbox">
        <label>
          <input type="checkbox" value="E" id="E" name="AU[]"> <?php echo dp($info_holder,"Distributor( Bonded or Coated Abrasive)");?>
        </label>
      </div>
      <div class="checkbox">
        <label>
          <input type="checkbox" value="F" id="F" name="AU[]"> <?php echo dp($info_holder,"Abrasive Users)");?>    
        </label>
      </div>
      <div>
        <fieldset>
          <div style="display:none;margin-left:20px" id="auep">
            <?php echo ab_users($abuser,$info_holder);?> 
          </div>
        </fieldset>
      </div>
      <div class="checkbox">
        <label>
         <input type="checkbox" value="G" id="G" name="AU[]"> <?php echo dp($info_holder,"Others, please specify");?> 
       </label>
     </div>
     <div class="form-group">
       <span style="padding-left:10px;display:none"  id="OV"><input type="text" value="" name="OVV" id="OVV" class="form-control"/>
       </span>
     </div>
     <div>
      <h4><?php echo dp($info_holder,"Provide details about yourself");?></h4>
    </div>
    <div class="form-group">
      <label><?php echo dp($info_holder,"Organization Name");?> *</label>
      <div>
        <input type="text" name="scw_orgname" id="scw_orgname" class="form-control" value="" placeholder="<?php echo dp($info_holder,"What is your organization name");?>?" required="required"/>
      </div>
    </div>
    <div class="form-group">
      <label ><?php echo dp($info_holder,"Address Of Registration");?> *</label>
      <div >
        <input type="text" name="scw_orgaddress"  id="scw_orgaddress" class="form-control" value="" placeholder="<?php echo dp($info_holder,"What is your organization address");?>?" required="required"/>
      </div>
    </div>
    <div class="form-group">
      <label><?php echo dp($info_holder,"Country");?> *</label>
      <div>
        <input data-items="4" data-provide="typeahead"  type="text" name="scw_orgcountry"  id="scw_orgcountry" class="form-control" value="" placeholder="<?php echo dp($info_holder,"From which country you are from");?>?" required="required"/>
      </div>
    </div>
    <div class="form-group">
      <label><?php echo dp($info_holder,"Preferred Language");?> </label>
      <div>
       <select name="scwlanguage" class="form-control">
        <option value="en" selected="selected"><?php echo dp($info_holder,"English");?></option>
        <option value="zh-cn"><?php echo dp($info_holder,"Chinese");?></option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label><?php echo dp($info_holder,"Name");?> *</label>
    <div>
      <input type="text" id="scw_orgepname" name="scw_orgepname" class="form-control" value="" placeholder="<?php echo dp($info_holder,"What is your name");?>?" required="required"/>
    </div>
  </div>
  <div class="form-group">
    <label><?php echo dp($info_holder,"Position");?> </label>
    <div>
      <input type="text" id="scw_orgempposition"  name="scw_orgempposition" class="form-control" value="" placeholder="<?php echo dp($info_holder,"What is your position");?>?" />
    </div>
  </div>
  <div class="form-group">
    <label><?php echo dp($info_holder,"Email");?> *</label>
    <div>
      <input type="email" type="text" name="scw_orgemail"  id="scw_orgemail" class="form-control" value="" placeholder="<?php echo dp($info_holder,"What is your email address");?>?" required="required"/>
    </div>
  </div>
  <div class="form-group">
    <label><?php echo dp($info_holder,"Company Website");?></label>
    <div>
      <input type="text" name="scw_orgweb"  id="scw_orgweb" class="form-control" value="" placeholder="<?php echo dp($info_holder,"What is your ccompany website address");?>?" />
    </div>
  </div>
  <div class="form-group">
    <label>
      <?php echo dp($info_holder,"Contact Number");?> *
    </label>
    <div>
      <input type="text" name="scw_telconcode"  id="scw_telconcode" class="form-control" placeholder="<?php echo dp($info_holder,"Country Code");?>">
    </div>
    <div >
      <input type="text" name="scw_telareacode"  id="scw_telareacode" class="form-control" placeholder="<?php echo dp($info_holder,"Area Code");?>">
    </div>
    <div>
      <input type="text" name="scw_orgcontact"  id="scw_orgcontact" class="form-control" placeholder="<?php echo dp($info_holder,"Telephone Number");?>">
    </div>
  </div>
  <div class="form-group">
    <label ><?php echo dp($info_holder,"Password");?> *</label>
    <div>
      <input type="password" name="scw_orgpass" id="scw_orgpass" class="form-control" value="" placeholder="<?php echo dp($info_holder,"Enter the password");?>?" required="required"/>
    </div>
  </div>
  <div class="form-group">
    <label ><?php echo dp($info_holder,"Confirm Password");?> *</label>
    <div>
      <input type="password" name="scw_orgconfpass" id="scw_orgconfpass" class="form-control" value="" placeholder="<?php echo dp($info_holder,"Confirm the password");?>?" required="required"/>
    </div>
  </div>
  <div class="form-group">
    <label ><?php echo dp($info_holder,"Notification Email");?> </label>
    <div>
      <input  type="text" type="email" name="scw_orgnotemail" id="scw_orgnotemail" class="form-control" value="" placeholder="<?php echo dp($info_holder,"Notification email will be sent to this email");?>?"/>
    </div>
  </div>
  <div class="checkbox">
    <label>
     <input type="checkbox" name="agreetermsandcond" value="agree" id="inlineCheckbox1"  required="required"> <?php echo dp($info_holder,"I agree to the Abrasives World terms and conditions");?>
   </label>
 </div>
 <div>
  <a href="<?php echo base_url();?>account/termsandconditions" ><?php echo dp($info_holder,"Terms and Conditions");?></a>
</div>
<div class="row">
  <div class="col-xs-12">
   <div id="dycupdate" style="display:none">
     <div style="padding-left:20px;padding-top:20px;padding-down:20px;">
       <img src="<?php echo base_url();?>application/css/images/load.GIF"/>
       <?php echo dp($info_holder,"Please wait while account creation is in progress.");?>
     </div>
   </div>
 </div>
</div>
<div class="form-group">
 <input type="submit" class="btn btn-u form-control" id="signupcomplete" value="Sign up"> 
</div>
</form>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo dp($info_holder,"Account Creation");?></h4>
      </div>
      <div class="modal-body" id="svauth">

      </div>
      <div class="modal-footer">

       <button type="button" class="btn btn-default" onclick="l_l();"><?php echo dp($info_holder,"OK");?></button>

       <button type="button" class="btn btn-default" onclick="l_l();"><?php echo dp($info_holder,"Close");?></button>
     </div>
   </div><!-- /.modal-content -->
 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>
</div>
</div>
</div>


<script type="text/javascript" language="javascript" src="<?php echo base_url();?>application/js/bootstrap3-typeahead.min.js"></script>

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

  $('#Z').change(function() {
    if($("#F").is(":checked")) {
      $('#Z').prop('checked', false); 
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
      $('#Z').prop('checked', false); 

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

<script>
 var country_list = ['Others']; 
 $('#scw_orgcountry').typeahead({source: country_list})
 $.getJSON('<?php echo base_url();?>general/country_list', function(data) {
   $.each(data, function(key, val) {
     country_list.push(val.country_name);
   });

 });

 $( "#scw_orgemail" ).change(function() {

  $("#scw_orgnotemail").val($( "#scw_orgemail" ).val());
  
});




 $("#customForm").submit(function(){
  $("#dycupdate").show();
  $.ajax({url:"create_account",type:"POST",data:$("#customForm").serialize(),success:function(response) {
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

 function l_l()
 {
  if ($("#dynca").val() == "")
  {
    location.href="http://www.abrasivesworld.com";
  }
  else
  {
    $('#myModal').modal('hide');

  }
}
</script> 