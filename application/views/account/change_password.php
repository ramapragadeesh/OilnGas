<?php
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
  <div  style="margin-top:10px" id="topMenu">
    <div>
      <div class="row nav-row">
        <div class="col-md-3">

          <div><span class="glyphicon glyphicon-user"></span> <a style="color:#3A3434;padding-left:5px" href="<?php echo base_url();?>account/my_profile"><?php echo dp($info_holder,"Edit my profile");?></a></div>
        </div>
        <div class="col-md-3 active">

          <div><span class="glyphicon glyphicon-lock"></span> <a style="color:#3A3434;padding-left:5px" href="<?php echo base_url();?>account/change_password"><?php echo dp($info_holder,"Change password");?></a></div>
        </div>
        <div class="col-md-3">

          <div><span class="glyphicon glyphicon-folder-close"></span> <a style="color:#3A3434;padding-left:5px" href="<?php echo base_url();?>my_article"><?php echo dp($info_holder,"Article Management System");?></a></div>
        </div>
        <div class="col-md-3">

          <div><span class="glyphicon glyphicon-folder-close"></span> <a style="color:#3A3434;padding-left:5px" href="<?php echo base_url();?>rfq"><?php echo dp($info_holder,"Request for quotation");?></a></div>
        </div>
      </div>
    </div>
  </div>


  <div id="viewPasswordChange" style="background:whitesmoke;margin-top:10px">
    <div class="row" style="margin-top:10px">
      <!-- Boxes de Acoes -->
      <div class="col-xs-12 col-sm-12">
        <div class="box">             
          <div class="icon">
            <div class="image"><i class="glyphicon glyphicon-lock"></i></div>
            <div class="info">
              <h3 class="title"><?php echo dp($info_holder,"Change your password");?> </h3>
              <div id="changemypassworddiv">
                <form id="changemypassword">
                  <div style="margin-top:10px">
                    <div><label for="scw_oldpass"><?php echo dp($info_holder,"What is your current password?");?> *</label></div>
                    <input type="password" name="oldpass" id="oldpass"  class="form-control"  style="display:inline-block" value="" required="required"/>
                  </div>

                  <div style="margin-top:10px">
                    <div><label><?php echo dp($info_holder,"Enter new password")?>*</label></div>
                    <input type="password" class="form-control" name="newpass"  id="newpass" style="display:inline-block" value="" required="required"/>
                  </div>

                  <div style="margin-top:10px">
                    <div><label><?php echo dp($info_holder,"Confirm new password")?>*
                    </label></div>
                    <input type="password" class="form-control" name="newpassconfirm"  style="display:inline-block" id="confirmnewpass" value="" required="required"/>
                  </div>

                  <div class="form-group" style="margin-top:10px">
                    <input type="submit" class="btn btn-u" value="<?php echo dp($info_holder,"Change");?>">
                  </div>
                </form>
              </div>

            </div>
          </div>
          <div class="space"></div>
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
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body" id="svauth">
        <div id="dyen">
          <div>
            <span class="glyphicon-refresh-animate" style="padding-right:5px"></span><?php echo dp($info_holder,"Please wait, while we update your password.");?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo dp($info_holder,"Close")?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script>
  $("#changemypassword").submit(function(){
    jQuery('#changemypassworddiv').fadeTo(500,0.2);
    $("#dyen").html("<p style='color:gray'><?php echo htmlentities(dp($info_holder,"Please wait, while we update your password."));?></p>");
    $("#myModal").modal();
    $.ajax({url:"confirm_change_password",type:"POST",data:$("#changemypassword").serialize(),success:function(response) {

     $("#dyen").html(response);
     jQuery('#changemypassworddiv').fadeTo(500,1);

   },error:function(){

    $("#dyen").html(response);
    jQuery('#changemypassworddiv').fadeTo(500,1);
  }});

    return false;

  });
</script>
<style>

  #topMenu .nav-row {
    text-align: left;
  }
  #topMenu .nav-row .col-md-3 {
    background-color: #fff;
    border: 1px solid #e0e1db;
    border-right: none;
    padding-bottom: 7px;
  }
  #topMenu .nav-row .col-md-3:last-child {
    border: 1px solid #e0e1db;
  }
  #topMenu .nav-row .col-md-3:first-child {
    border-radius: 5px 0 0 5px;
  }
  #topMenu .nav-row .col-md-3:last-child {
    border-radius: 0 5px 5px 0;
  }
  #topMenu .nav-row .col-md-3:hover {
    color: #687074;
    cursor: pointer;
  }
  #topMenu .nav-row .active {
    color: #1ABB9C;
    margin-top: -2px;
    border-top: 3px solid #1ABB9C;
    border-bottom: 3px solid #1ABB9C;
  }
  #topMenu .nav-row .active:before {
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
  #topMenu .nav-row .glyphicon {
    padding-top: 8px;
    font-size: 15px;
  }
  #topMenu .nav-row .col-md-6 {
    background-color: #fff;
    border: 1px solid #e0e1db;
    border-right: none;
  }
  #topMenu .nav-row .col-md-6:last-child {
    border: 1px solid #e0e1db;
  }
  #topMenu .nav-row .col-md-6:first-child {
    border-radius: 5px 0 0 5px;
  }
  #topMenu .nav-row .col-md-6:last-child {
    border-radius: 0 5px 5px 0;
  }
  #topMenu .nav-row .col-md-6:hover {
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
  #viewPasswordChange .box > .icon { text-align:center; position: relative; }
  #viewPasswordChange .box > .icon > .image { position: relative; z-index: 2; margin: auto; width: 88px; height: 88px; border: 8px solid white; line-height: 88px; border-radius: 50%; background: #63B76C; vertical-align: middle; }
  #viewPasswordChange .box > .icon > .image > i { font-size: 36px !important; color: #fff !important; }
  #viewPasswordChange .box .space { height: 30px; }
</style>