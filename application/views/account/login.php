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
?>
<div class="container" style="background:whitesmoke">
  <div style="margin-top:60px" id="loginForm">
    <div>
      <div class="panel member_signin">
        <div class="panel-body">
          <div class="fa_user">
            <i class="fa fa-user"></i>
          </div>
          <p class="member"><?php echo dp($info_holder,"Abrasive World Account Login");?></p>
          <form id="lform">
            <div style="margin-top:10px">
            <label for="remailid" class="sr-only"><?php echo dp($info_holder,"Email id");?></label>
            <input class="form-control" style="display:inline" type="email" placeholder="<?php echo dp($info_holder,"Email id");?>" name="scw_orgemail" id="scw_orgemail" />
            </div>
            <div style="margin-top:10px;margin-bottom:10px">
            <label for="remailid" class="sr-only"><?php echo dp($info_holder,"Password");?></label>
              <input name="scw_orgpass" style="display:inline" id="scw_orgpass" class="form-control password" type="password" placeholder="<?php echo dp($info_holder,"Password");?>" />
            </div>
            <button type="button" class="btn btn-u" id="login_link"> <?php echo dp($info_holder,"Login");?> </button>
          </form>
          <p class="forgotpass"><a href="#forgetPasswordForm" class="small">Forgot Password?</a></p>
        </div>
      </div>
    </div>
  </div>


  <div class="container" style="text-align:center">
    <div id="dycupdate" style="display:none">
     <div style="padding-left:20px;padding-top:5px">
       <i class="fa fa-circle-o-notch fa-spin"></i>
       <?php echo dp($info_holder,"Please wait while we check your credentials.");?>
     </div>
   </div>
 </div>



 <div>
  <div style="margin-top:100px" id="forgetPasswordForm">
    <div>
      <div class="panel member_signin">
        <div class="panel-body">
          <div class="fa_user">
            <i class="fa fa-user" style="background-color:rgb(240, 56, 56);"></i>
          </div>
          <p class="member"><?php echo dp($info_holder,"Lost password?");?></p>
          <form role="form" id="rform">
            <div style="margin-bottom:10px">
              <label for="remailid" class="sr-only"><?php echo dp($info_holder,"Email id");?></label>
              <div>
                <input  class="form-control" style="display:inline" type="email" name="remailid" id="remailid" placeholder="<?php echo dp($info_holder,"Email id");?>" />
              </div>
            </div>
            <button type="button" id="rp_link"  class="btn btn-u"> <?php echo dp($info_holder,"Send me");?></button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div style="display:none" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo dp($info_holder,"Abrasivesworld Account");?></h4>
      </div>
      <div class="modal-body" id="svauth">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo dp($info_holder,"Close");?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>
<style>
  /* Snippet One */

  div.member_signin {
    text-align: center;
  }

  div.member_signin  i.fa.fa-user {
    color: #FFF;
    background-color: #FFD202;
    border-radius: 500px;
    font-size: 36px;
    padding: 15px 20px 15px 20px;
  }

  div.fa_user {
    margin-top: -47px;
    margin-bottom: 15px;
  }

  p.member {
    font-size: 19px;
    color: #888888;
    margin-bottom: 20px;
  }

  button.login {
    width: 100%;
    text-transform: uppercase;
  }

  form.loginform div.input-group {
    width: 100%;
  }

  form.loginform input[type="email"], form.loginform input[type="password"] {
    color: #6C6C6C;
    text-align: center;
  }

  p.forgotpass {
    margin-top: 10px;
  }

  p.forgotpass a {
    color: #F5683D;
  }
</style>

<script>
  <?php
  if($vplink== true)
  {
    echo "var uredirect='".str_replace("'","",$vlink)."';";
  }
  else
  {
    echo "var uredirect='my_profile';";
  }
  ?>

  $("#login_link").click(function(){
    $("#dycupdate").show();
    $.ajax({url:"signin_check",type:"POST",data:$("#lform").serialize(),success:function(response) {
      etrace=response;

      $("#dycupdate").hide();
      if (response == "1")
      {
       $("#svauth").html("<p><?php echo dp($info_holder,"You are successfully authenticated.");?></p>");

       $('#myModal').modal();
       window.location=uredirect;
     }
     else
     {
       $("#svauth").html("<p><?php echo dp($info_holder,"invalid credentials, please check your password or email id");?></p>");
       $('#myModal').modal();

     }
   },error:function(){

    alert("OOPS, something went wrong");
    $("#dycupdate").hide();
  }});

    return false;

  });

  $("#rp_link").click(function(){
    $("#dycupdate").show();
    $.ajax({url:"recover_password",type:"POST",data:$("#rform").serialize(),success:function(response) {
      etrace=response;
      $('#myModal').modal();
      $("#dycupdate").hide();
      $("#svauth").html("<p><b>"+response+"</b></p>");

    },error:function(){

      alert("OOPS, something went wrong");
      $("#dycupdate").hide();
    }});

    return false;

  });
</script>