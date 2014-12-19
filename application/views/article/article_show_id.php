<?php
function dp($info_holderdy, $f, $fsl = "") {
	$rt = $f;

	foreach ($info_holderdy as &$value) {
		if (strtolower($value->default_text) == strtolower($f)) {
			$rt = $value->dp;
			break;
		}
	}
	return $rt;
}
?>
<div class="container" id="parentContainer" style="background:whitesmoke">  <!-- Parent Container Starts Here-->
<div id="searchHeader" style="background:rgb(197, 197, 197);padding-top:10px;padding-bottom:10px;padding-left:20px">
	<h1 style="color:purple;font-weight:100"><?php echo dp($articleLanguageInfo, "Article View");?></h1>
		<hr style="margin-top:0px!important;margin-bottom:0;px!important">

		<div>
			<div class="row" style="margin-top:10px;margin-bottom:5px">
				<div class="col-xs-12 col-md-3" style="margin-top:5px;">
					<label>
						<?php echo dp($articleLanguageInfo, "Article Display Language");?>
					</label>
				</div>
				<div class="col-xs-12 col-md-3" style="margin-top:5px;">
					<select class="form-control" id="displayLanguage">
						<option value="default"><?php echo dp($articleLanguageInfo, "Posted in original language");?></option>
						<option value="id">Bahasa</option>
						<option value="zh-cn">Chinese</option>
						<option value="en">English</option>
						<option value="de">German</option>
						<option value="hi">Hindi</option>
						<option value="th">Thai</option>
					</select>
				</div>
				<div class="col-xs-12 col-md-2" style="margin-top:5px;">
					<button class="btn btn-u form-control" onclick="searchSubmit(1,true);"><?php echo dp($articleLanguageInfo, "Update");?></button>
				</div>
			</div>
			<div style="margin-top:10px;text-align:center">
				<h4><a href="<?php echo base_url();?>article/advanced_view?articleId=<?php echo $articleId;?>"><?php echo dp($articleLanguageInfo, "Click here for more advanced article search");?></a></h4>
			</div>

		</div>
		</div>
		<div id="showArticle">
		</div>

		<h1 style="color:#4d4582;;font-weight:100"><?php echo dp($articleLanguageInfo, "Article Information");?></h1>
		<hr style="margin-top:0;margin-bottom:0;">
		<div>
			<div id="article-data">
			</div>
		</div>
		<div>
		<button class="btn btn-u sendEmail"><?php echo dp($articleLanguageInfo, "Share with others");?></button>
		</div>
	</div> <!-- Parent Container Ends Here-->

	<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="container" style="background:whitesmoke">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3 text-center">
					Please wait while we loading the search content
				</div>
			</div>
		</div>
	</div>


<div id="sendEmailModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h5 style="font-weight:100">
					<?php echo dp($articleLanguageInfo,"Article Share"); ?>
					<span id="contactName">
					</span>
				</h5>
			</div>
			<div class="modal-body">
				<form method="post" class="form-horizontal" role="form" id="articleShareForm" action="<?php echo  base_url();?>abrasivesworld/article_sharing">
				<div class="form-group">
   				<label for="senderName" class="col-sm-3 control-label"><?php echo dp($articleLanguageInfo,"Name");?></label>
   				<div class="col-sm-9">
    			<input type="text" class="form-control" id="senderName" name ="senderName" placeholder="<?php echo dp($articleLanguageInfo,"Enter Name");?>" required>
  				</div>
  				</div>

  				<div class="form-group">
   				<label for="senderEmail" class="col-sm-3 control-label"><?php echo dp($articleLanguageInfo,"Sender Email Address");?></label>
   				<div class="col-sm-9">
    			<input type="email" class="form-control" id="senderEmail" name ="senderEmail" placeholder="<?php echo dp($articleLanguageInfo,"Enter Email");?>" required>
  				</div>
  				</div>

  				<div class="form-group">
   				<label for="senderEmailConfirm" class="col-sm-3 control-label"><?php echo dp($articleLanguageInfo,"Confirm Sender Email Address");?></label>
    			<div class="col-sm-9">
    			<input type="email" class="form-control" id="senderEmailConfirm" name ="senderEmailConfirm" placeholder="<?php echo dp($articleLanguageInfo,"Enter Confirmation Email");?>" required>
  				</div>
  				</div>

  				<p><input type="hidden" name="articleID" id="articleID" value=""></p>
				<p><button type="submit" class="btn btn-u"><?php echo dp($articleLanguageInfo,"Send");?></button></p>
				</form>

			</div>
			<div class="modal-footer">
				<p><button type="button" class="btn btn-default" data-dismiss="modal"><?php echo dp($articleLanguageInfo,"Close");?></button></p>
				<p><a href="<?php echo base_url();?>account/newaccount"><?php echo dp($articleLanguageInfo,"Do you want to register with abrasivesworld?");?></a>
				</p>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


	<script>
		var searchForm =
		{
			"paidArticle":true,
			"editorialArticle":true,
			"displayLanguage": "default",
			"searchTextTitle": "",
			"searchTextContent": "",
			"startDate":"",
			"endDate":"",
			"articleId":"",
			"start":1,
			"end":0
		};
		function getArticleSearchData()
		{
			searchForm.displayLanguage = $("#displayLanguage").val();
		}

		function searchSubmit(page,showUrlArticleId,getLanguage) {			

			baseUrl ="<?php echo base_url().'article/article_search_advanced'?>";
			$("#loadingModal").modal();
			if (typeof page === "undefined")
			{
				searchForm.start=0;
			} else {
				searchForm.start=page;
			}
			if (typeof showUrlArticleId === "undefined") {
				searchForm.articleId = "";
				console.log("No Article Id is requested on load")
			}
			if (typeof getLanguage === "undefined") {
			getArticleSearchData();
			}

			$.ajax({
				url: baseUrl,
				type: 'POST',
				data: {searchForm : JSON.stringify(searchForm)},
				success: function(msg) {
					$("#article-data").html(msg)
					$("#loadingModal").modal("hide");
				}
			});
		}
		$(document ).ready(function() {

			try
			{
				var queries = {};
				$.each(document.location.search.substr(1).split('&'),function(c,q){
					var i = q.split('=');
					queries[i[0].toString()] = i[1].toString();
				});
				searchForm.articleId = queries.articleId;
				$("#articleID").val(searchForm.articleId);
				searchForm.displayLanguage = queries.locale;
				searchSubmit(1,true,false);
			}
			catch(err)
			{
				console.log("No Query is set");

			}
			
		});
	$( ".sendEmail" ).click(function() {	
	$( "#sendEmailModal" ).modal();		
	});
	$("#articleShareForm").submit(function() {
		if ( $("#senderEmail").val() !=  $("#senderEmailConfirm").val()) {
			alert('<?php echo dp($articleLanguageInfo,"Please check your email address.");?>')
			return false;
		}
		   $.ajax({
           type: "POST",
           url: '<?php echo  base_url();?>abrasivesworld/article_sharing',
           data: $("#articleShareForm").serialize(), // serializes the form's elements.
           success: function(data)
           {
               alert("Email has been sent."); // show response from the php script.
               $( "#sendEmailModal" ).modal("hide");
           }
         });
    return false; // avoid to execute the actual submit of the form.
	});

	</script>

	<style>
		.article-search-form
		{
			background: #4d4582;
			color: white;
		}
	</style>

