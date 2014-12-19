<?php
function get_rfq_table()
{


}
function rfq_dashboard(& $rfqlist,& $rfqsummary)
{
  $rc=0;
  $r ="";
  foreach($rfqlist as &$v)
  {
    $rc=$rc+1;
    if ($rc==1)
    {
      $r .="<tr><td style='width:200px'><div style='text-align:left'>
      <span style=''><b>".$v->rfq_title." - Responses</b></span></div><div>
      ".'<input type="text" data-linecap=round class="knob-dyn" data-angleOffset=90 data-width="150" data-thickness=".4" value="'.rfq_bid_summary($rfqsummary,$v->rfq_id).'" readonly>'."</div></td>";
    }
    else if ($rc==2)
    {
      $r .="<td style='width:200px'><div>
      <span style='margin-left:20px'><b>".$v->rfq_title." - Responses</b></span></div>
      <div>
        ".'<input type="text" data-linecap=round class="knob-dyn" data-angleOffset=90 data-width="150" data-thickness=".4" value="'.rfq_bid_summary($rfqsummary,$v->rfq_id).'" readonly>'."</div></td></tr>";
        $rc=0;
      }

    }
    return $r;
  }
  function rfq_bid_summary(& $rfqbidsummary,$rfqid)
  {
    $r=0;
    foreach ($rfqbidsummary->result() as $row)
    {
     if ( $row->rfq_id==$rfqid)
     {
       return $row->bid_count;
     }

   }
   return $r;
 }
 function list_rfqmain(& $rfqlist,& $rfqsummary)
 {
  $r="";
  $rc=0;
  foreach($rfqlist as &$v)
  {
    $ac="";
    if ($v->rfq_active==1)
    {
      $ac="checked disabled";
    }

    $rc=$rc+1;
    $r .="<tr>";
    $r .="<td style='display:none'><span>".$v->rfq_id."</span></td>";
    $r .="<td><span>".$v->rfq_no."</span></td>";
    $r .="<td><span>".$v->rfq_title."</span></td>";
    $r .="<td><span>".$v->rfq_issue_date."</span></td>";
    $r .="<td><span>".$v->rfq_close_date."</span></td>";
    $r .="<td><span>".$v->rfq_pref_currency."</span></td>";
    $r .="<td><span><input type='checkbox'".$ac." disabled></span></td>";
    if ($v->rfq_active==1)
    {
      $r .="<td><span>".'<a href="rfq_summary_view/?rfq_id='.$v->rfq_id.'"><span class="badge">'.rfq_bid_summary($rfqsummary,$v->rfq_id).'</span></a> </td><td><a href="rfq_modify/?rfqid='.$v->rfq_id.'"><i class="fa fa-pencil fa-fw"></i></a></td><td></td>';
    }
    else
    {
      $r .="<td><span>".'<a href="rfq_summary_view/?rfq_id='.$v->rfq_id.'"><span class="badge">'.rfq_bid_summary($rfqsummary,$v->rfq_id).'</span></a> </td><td><a href="rfq_modify/?rfqid='.$v->rfq_id.'"><i class="fa fa-pencil fa-fw"></i></a></td><td> &nbsp;&nbsp;<i style="cursor:pointer" class="fa fa-trash-o fa-fw" onclick="remove_rfq(\''.$v->rfq_id.'\');"> </i>'."</span></td>";
    }

    $r .="</tr>";
  }
  return $r;
}
function list_bidmain(& $bidlist)
{
  $r="";
  $rc=0;

  foreach($bidlist as &$v)
  {
    $rc=$rc+1;
    $r .="<tr>";
    $r .="<td style='display:none'><span>".$v->rfq_id."</span></td>";
    $r .="<td><span>".$v->rfq_no."</span></td>";
    $r .="<td><span>".$v->rfq_title."</span></td>";
    $r .="<td><span>".$v->rfq_issue_date."</span></td>";
    $r .="<td><span>".$v->rfq_close_date."</span></td>";
    $r .="<td><span>".$v->rfq_pref_currency."</span></td>";

    $r .='<td><span><a href="'.base_url().'rfq/rfq_bid_details/?rfqid='.$v->rfq_id.'"><i class="fa fa-info-circle" style="font-size:30px;color:purple"></i></a></span></td>';
    $r .="</tr>";
  }
  return $r;
}

function list_rfqresponse(& $bidlist)
{
  $r="";
  $rc=0;

  foreach($bidlist as &$v)
  {
    $rc=$rc+1;
    $r .="<tr>";
    $r .="<td style='display:none'><span>".$v->rfq_id."</span></td>";
    $r .="<td><span>".$v->rfq_no."</span></td>";
    $r .="<td><span>".$v->rfq_title."</span></td>";
    $r .="<td><span>".$v->rfq_incoterm."</span></td>";
    $r .="<td><span>".$v->rfq_pref_cn_export."</span></td>";
    $r .="<td><span>".$v->rfq_partial."</span></td>";

    $r .="<td><span>".'<a href="rfq_bid_info/?rfqid='.$v->rfq_id.'&user_bid_id='.$v->user_bid_id.'"><i class="fa fa-info-circle" style="font-size:30px;color:purple" alt="More Information"> </i></a>'."</span></td>";
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
    <div class="row nav-row" style="text-align:center">
      <div class="col-md-3 col-centered" style="text-align:center">
        <div style="padding-top:5px;padding-bottom:5px;">          
          <a style="font-weight:100" href="<?php echo base_url();?>rfq"><i class="fa fa-pencil fa-fw"></i><?php echo dp($info_holder,"Create a new RFQ");?></a>
        </div>
      </div>
      <div class="col-md-3 col-centered">
        <div style="padding-top:5px;padding-bottom:5px;text-align:center;">
          <a style="font-weight:100" href="<?php echo base_url();?>rfq/rfq_manage"><i class="fa fa-book fa-fw"></i><?php echo dp($info_holder,"Manage my RFQ");?></a>
        </div>
      </div>
      
      <div class="col-md-3 col-centered">
        <div style="padding-top:5px;padding-bottom:5px;" style="text-align:center">
        <span class="fa fa-info-circle"></span>  
          <a style="font-weight:100" href="<?php echo  base_url();?>help" target="_"><?php echo dp($info_holder,"Help");?></a>
        </div>
      </div>

    </div>
</div>

  <ul class="nav nav-tabs" id="vtabs" style="margin-top:10px">
    <li class="active"><a href="#sent_rfq" data-toggle="tab"><?php echo dp($info_holder,"Sent RFQ");?></a></li>
    <li><a href="#active_bid" data-toggle="tab"><?php echo dp($info_holder,"Bid View");?></a></li>
    <li><a href="#dview" data-toggle="tab"><?php echo dp($info_holder,"RFQ Dashboard");?></a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div class="tab-pane active" id="sent_rfq">

      <div style="border:3px solid whitesmoke">
      <h3 style="font-weight:100;"><?php echo dp($info_holder,"RFQ List");?></h3>
        <table class="table" id="rfqtable" >
          <thead>
            <tr>
              <th style='display:none'><?php echo dp($info_holder,"RFQ ID");?></th>
              <th><?php echo dp($info_holder,"RFQ No");?></th>
              <th><?php echo dp($info_holder,"RFQ Title");?></th>
              <th><?php echo dp($info_holder,"RFQ Issue Date");?></th>
              <th><?php echo dp($info_holder,"RFQ Close Date");?></th>
              <th><?php echo dp($info_holder,"Prefered Currency");?></th>
              <th><?php echo dp($info_holder,"Active");?></th>
              <th><?php echo dp($info_holder,"Response");?></th>
              <th><?php echo dp($info_holder,"Edit");?></th>
              <th><?php echo dp($info_holder,"Delete");?></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php echo list_rfqmain($lrfq,$rfqbidsummary);?>
          </tbody>
        </table>
        <div style="margin-top:10px">
          <hr>
        </div>
        <div style="clear:both">
        </div>
      </div>  
    </div>
    <div class="tab-pane" id="active_bid">
      <div style="border:3px solid whitesmoke">
        <p style="font-weight:bold;font-size:15px;padding-left:30px;height:20px;background-color:whitesmoke"><?php echo dp($info_holder,"RFQ List");?></p>
        <table class="table" style="width:100%" id="rfqtable" >
          <thead>
            <tr>
              <th style='display:none'><?php echo dp($info_holder,"RFQ ID");?></th>
              <th><?php echo dp($info_holder,"RFQ No");?></th>
              <th><?php echo dp($info_holder,"RFQ Title");?></th>
              <th><?php echo dp($info_holder,"RFQ Issue Date");?></th>
              <th><?php echo dp($info_holder,"RFQ Close Date");?></th>
              <th><?php echo dp($info_holder,"Preferred Currency");?></th>
              <th><?php echo dp($info_holder,"More Information");?></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php echo list_bidmain($lrfqb);?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="tab-pane" id="dview">
      <div>
        <table>
          <tbody>
            <?php echo rfq_dashboard($lrfq,$rfqbidsummary);?>
          </tbody>
        </table>
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
          <p><?php echo dp($info_holder,"Please wait, while we update your password.");?></p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo dp($info_holder,"Close");?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
      rew.parentElement.parentElement.parentElement.remove();
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

.collapsibleContainer
{
  border: solid 1px #9BB5C1;

}

.collapsibleContainerTitle
{
  cursor:pointer;
}

.collapsibleContainerTitle div
{
  padding-top:5px;
  padding-left:10px;
  background-color:#9BB5C1;
  color:#607882;
}

.collapsibleContainerContent
{
  padding: 10px;
}
.hero-widget { text-align: center; padding-top: 20px; padding-bottom: 20px; }
.hero-widget .icon { display: block; font-size: 96px; line-height: 96px; margin-bottom: 10px; text-align: center; }
.hero-widget var { display: block; height: 64px; font-size: 64px; line-height: 64px; font-style: normal; }
.hero-widget label { font-size: 17px; }
.hero-widget .options { margin-top: 10px; }

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
<script>
  (function($) {
    $.fn.extend({
      collapsiblePanel: function() {
        // Call the ConfigureCollapsiblePanel function for the selected element
        return $(this).each(ConfigureCollapsiblePanel);
      }
    });
  })(jQuery);


  function ConfigureCollapsiblePanel() {
    $(this).addClass("ui-widget");
    
    // Check if there are any child elements, if not then wrap the inner text within a new div.
    if ($(this).children().length == 0) {
      $(this).wrapInner("<div></div>");
    }    
    
    // Wrap the contents of the container within a new div.
    $(this).children().wrapAll("<div class='collapsibleContainerContent ui-widget-content'></div>");
    
    // Create a new div as the first item within the container.  Put the title of the panel in here.
    $("<div class='collapsibleContainerTitle ui-widget-header'><div>" + $(this).attr("title") + "</div></div>").prependTo($(this));

    
    // Assign a call to CollapsibleContainerTitleOnClick for the click event of the new title div.
    $(".collapsibleContainerTitle", this).click(CollapsibleContainerTitleOnClick);
  }
  
  
  function CollapsibleContainerTitleOnClick() {
    // The item clicked is the title div... get this parent (the overall container) and toggle the content within it.
    $(".collapsibleContainerContent", $(this).parent()).slideToggle();
  }
  var rgid="";

  function command_remove_rfq(rid)
  {
    var formData={"rfqid":rid};
    $.ajax({
      url : "remove_rfq_entry",
      type: "POST",
      data : formData,
      success: function(data, textStatus, jqXHR)
      {
       location.reload();
     },
     error: function (jqXHR, textStatus, errorThrown)
     {
       location.reload();
     }
   });

  }
  function auth_remove(e)
  {
    if(e==true)
    {
      command_remove_rfq(rgid);
    }
  }
  function remove_rfq(ri)
  {
    rgid=ri;
    bootbox.confirm("Are you sure?", auth_remove);
  }

</script>
<script language="javascript" type="text/javascript">
  $(document).ready(function() {
    <?php
    if ($aview=="bidder")
    {
      echo "$('#vtabs li:eq(1) a').tab('show');";
    }
    ?>
    $(".knob-dyn").knob();		


    $(".collapsibleContainer").collapsiblePanel();
    $(".collapsibleContainerContent", $('.collapsibleContainerContent').parent()).slideToggle();
  });

</script>                
