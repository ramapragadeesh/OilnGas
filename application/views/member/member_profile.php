<?php

function localeConversion(& $info_holderdy,$f,$fsl="") {
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


function UserOptionSelected(& $uod,$vdp,$rt) {
  $f="";
  foreach($uod as &$value) {
    if ($rt==1 and $value->selection == $vdp) {
      $f= $value->selection_text;
      break;
    } elseif ($value->selection == $vdp) {
      $f=true;
      break;
    }
  }
  if ($f==true) {
    return "checked";
  } else {
    return $f;
  }

}

function UserOptionsOthersText(& $uod) {
  foreach($uod as &$value) {
    if ($value->selection == 'G') {
      return $value->selection_text;
    }
  }
}


function listABUsersOptions(& $abuserl, & $hc,$us="",$oto="")
{
  $divg="";
  foreach ($abuserl as &$value) {
    if ($value->au_category=="Others, please specify") {
      $divg .= '<span class="label label-info tags">'.$oto.'</span>';
    } else {
      if (abusers_match($us,$value->au_id)=="checked") {
        $divg .='<span class="label label-info tags">'.localeConversion($hc,$value->au_category).'</span>';
      }
    }
  }
  return $divg;
}

?>
<div class="container" style="margin-top:10px">
  <div class="row">
    <div class="col-md-12 col-xs-12">
      <div class="well panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-xs-12 col-sm-4 text-center">
              <img src="<?php if ( $accountDetails[0]->user_comppic !="") { echo $accountDetails[0]->user_comppic; } else { echo 'http://placehold.it/300x250'; } ?>" alt="" class="center-block img-circle img-thumbnail img-responsive">
            </div>
            <!--/col-->
            <div class="col-xs-12 col-sm-8">
              <h2><?php echo $accountDetails[0]->user_orgname; ?></h2>
              <p><strong><?php echo localeConversion($memberLanguageInfo,"Address");?> </strong> <?php if ( $accountDetails[0]->user_orgaddress !="") { echo $accountDetails[0]->user_orgaddress; } else { echo $accountDetails[0]->user_country; } ?>  </p>
              <p><strong> <?php echo localeConversion($memberLanguageInfo,"Website");?> </strong> <?php if ( $accountDetails[0]->user_webaddress !="") { echo "<a href='".$accountDetails[0]->user_webaddress."' target='_blank'>".$accountDetails[0]->user_webaddress."</a>"; } else { echo $accountDetails[0]->user_webaddress; } ?>  </p>
              <p><strong><?php echo localeConversion($memberLanguageInfo,"Email");?> </strong> <span id="userEmail"><?php if ( $accountDetails[0]->user_email !="") { echo $accountDetails[0]->user_email; } else { echo $accountDetails[0]->user_email; } ?> </span> </p>

              <p>
                <strong>
                  <?php echo localeConversion($memberLanguageInfo,$userDesc);?>
                </strong>
              </p>
              <p>

                <?php
                if ($isOrg == true) {
                  if (UserOptionSelected($accountOptions,'A',0)=="checked") { echo '<span class="label label-info tags">'.localeConversion($memberLanguageInfo,"Machine / Equipment  Supplier").'</span><br>'; }
                  if (UserOptionSelected($accountOptions,'B',0)=="checked") { echo '<span class="label label-info tags">'.localeConversion($memberLanguageInfo,"Raw Material Supplier").'</span><br>'; }
                  if (UserOptionSelected($accountOptions,'C',0)=="checked") { echo '<span class="label label-info tags">'.localeConversion($memberLanguageInfo,"Abrasive Producer (Bonded,Coated)").'</span><br>'; }
                  if (UserOptionSelected($accountOptions,'Z',0)=="checked") { echo '<span class="label label-info tags">'.localeConversion($memberLanguageInfo,"Coated abrasives producer").'</span><br>'; }
                  if (UserOptionSelected($accountOptions,'D',0)=="checked") { echo '<span class="label label-info tags">'.localeConversion($memberLanguageInfo,"Coated Abrasive Converter").'</span><br>'; }
                  if (UserOptionSelected($accountOptions,'E',0)=="checked") { echo '<span class="label label-info tags">'.localeConversion($memberLanguageInfo,"Distributor( Bonded or Coated Abrasive)").'</span><br>'; }
                  if (UserOptionSelected($accountOptions,'G',0)=="checked") { echo '<span class="label label-info tags">'.UserOptionsOthersText($accountOptions).'</span><br>'; }
                } else {
                  echo listABUsersOptions($abUsers,$memberLanguageInfo,$accountDetails->absm,$accountDetails->absmo);
                }
                ?>
              </p>
              </div>
            </div>
            <!--/col-->
            <div class="clearfix"></div>
            <div class="col-xs-12 col-sm-4">
              <h2><strong> 20,7K </strong></h2>
              <p><small>Followers</small></p>
              <button class="btn btn-success btn-block"><span class="fa fa-plus-circle"></span> Follow </button>
            </div>
            <!--/col-->
            <div class="col-xs-12 col-sm-4">
              <h2><strong>245</strong></h2>
              <p><small>Following</small></p>
              <button class="btn btn-info btn-block"><span class="fa fa-user"></span> View Profile </button>
            </div>
            <!--/col-->
            <div class="col-xs-12 col-sm-4">
              <h2><strong>43</strong></h2>
              <p><small>Snippets</small></p>
              <button type="button" class="btn btn-primary btn-block"><span class="fa fa-gear"></span> Options </button>
            </div>
            <!--/col-->
          </div>
          <!--/row-->
        </div>
        <!--/panel-body-->
      </div>
      <!--/panel-->
    </div>
    <!--/col-->
  </div>
  <!--/row-->
</div>
<!--/container-->