<?php
?>
<div class="container">

  <div id="mc">
    <div class="well well-large" style="background-color:rgb(158, 31, 99)">
      <h1 style='font-weight:100'> ABRASIVES WORLD </h1>
      <div class="alert alert-info">
        <b>Please wait while we process your payment information ...</b>
      </div>
    </div>
    <div class="progress">
      <div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 1%">
      <span class="sr-only">Payment progessbar</span>
      </div>
    </div>
  </div>

  <div style="display:none" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Payment Verification</h4>
        </div>
        <div class="modal-body" id="svauth">
         <b style="color:green">Your payment is successfully verified. You can click the below link to Abrasivesworld account page</b>
         <div style="margin-top:15px">
           <a href="<?php echo base_url();?>/account/my_profile">My Abrasivesworld Account</a>
         </div>
       </div>
       <div class="modal-footer">
        <a class="btn btn-u" href="<?php echo base_url();?>/account/my_profile">OK</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div style="display:none" class="modal fade" id="fModal" tabindex="-1" role="dialog" aria-labelledby="fModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Payment Verification </h4>
      </div>
      <div class="modal-body" id="svauthf">
       <b style="color:red">We are not able to verify your payment,you can contact us by clicking the below link and we will get back to you as soon as possible</b>
       <div style="mragin-top:15px">
         <a href="<?php echo base_url();?>/account/my_profile">My Abrasivesworld Account</a>
       </div>
     </div>
     <div class="modal-footer">
      <a class="btn btn-u" href="<?php echo base_url();?>/account/my_profile">close</a>
    </div>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>
<script>
  var gdata;
  var runCount = 0;
  var isPaymentverified = false;
  var addProgress = 0;
  gdata="txn_id=<?php echo $txn_id;?>";

  function paymentVerify() {
    $.ajax({
      url : "payment_verify",
      type: "POST",
      data : gdata,
      success: function(data, textStatus, jqXHR) {
       if ( data == "1" ) {
         isPaymentverified = true;
         $("#myModal").modal();
       } else {
         payment_check();
       }
     },
     error: function (xhr, ajaxOptions, thrownError) {

     }
   });

  }

  $( "#payok" ).click(function() {
    location="<?php echo base_url();?>/account/my_profile";
  });

  function payment_check() {
    runCount = runCount+1;
    addProgress = runCount + runCount;
    var progessbarWidth = "width: "+ addProgress.toString() +"%";

    if (addProgress >= 100 ) {
      $('.progress-bar').attr("style","width: 100%");
    } else {
    $('.progress-bar').attr("style",progessbarWidth);
    }

    if ( runCount >= 50 ) {
      $("#fModal").modal();
      return;
    } else {
      paymentVerify();
    }

  }

  $(document).ready(function() {

    payment_check();

  });
</script>