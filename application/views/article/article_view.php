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
	<h1 style="font-weight:100;color:purple"><?php echo dp($articleLanguageInfo, "Article Advanced Search");?></h1>
		<hr style="margin-top:0px!important;margin-bottom:0;px!important">

		<div>
			<div class="row" style="margin-top:10px;margin-bottom:5px">
				<div class="col-xs-12 col-md-3" style="margin-top:5px;">
					<label>
						<?php echo dp($articleLanguageInfo, "By the article published date");?>
					</label>
				</div>
				<div class="col-xs-12 col-md-3" style="margin-top:5px;">
					<div class="input-group">
						<div class="input-group-addon article-search-form"><?php echo dp($articleLanguageInfo, "From");?></div>
						<input class="form-control" type="text" id="postedStartDate">
					</div>
				</div>
				<div class="col-xs-12 col-md-3" style="margin-top:5px;">
					<div class="input-group">
						<div class="input-group-addon article-search-form"><?php echo dp($articleLanguageInfo, "To");
							?>&nbsp;
							&nbsp;
							&nbsp;
							&nbsp;
						</div>
						<input class="form-control" type="text" id="postedEndDate">
					</div>
				</div>
			</div>
			<div class="row" style="margin-top:10px;margin-bottom:5px">
				<div class="col-xs-12 col-md-3" style="margin-top:5px;">
					<label>
						<?php echo dp($articleLanguageInfo, "Article Information");?>
					</label>
				</div>
				<div class="col-xs-12 col-md-3" style="margin-top:5px;">
					<div class="input-group">
						<div class="input-group-addon article-search-form"><?php echo dp($articleLanguageInfo, "Title");
							?>&nbsp;
						</div>
						<input class="form-control" type="text" id="articleTitle">
					</div>
				</div>
				<div class="col-xs-12 col-md-3" style="margin-top:5px;">
					<div class="input-group">
						<div class="input-group-addon article-search-form"><?php echo dp($articleLanguageInfo, "Content");?></div>
						<input class="form-control" type="text" id="articleContent">
					</div>
				</div>
			</div>
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
			</div>
			<div class="row" style="margin-top:10px;margin-bottom:5px">
				<div class="col-xs-12 col-md-3" style="margin-top:5px;">
					<label>
						<?php echo dp($articleLanguageInfo, "Article Type");?>
					</label>
				</div>
				<div class="col-xs-12 col-md-3" style="margin-top:5px;">
					<select class="form-control" id="articleType" onchange="setArticleType();">
						<option value="paid"><?php echo dp($articleLanguageInfo, "Paid Article");?></option>
						<option value="editorial"><?php echo dp($articleLanguageInfo, "Editorial Article");?></option>
						<option value="both" selected><?php echo dp($articleLanguageInfo, "Both");?></option>
					</select>
				</div>
			</div>
			<div class="row" style="margin-top:10px;margin-bottom:5px">
				<div class="col-xs-12 col-md-3" style="margin-top:5px;">
					<button class="btn btn-u form-control" onclick="searchReset();"><?php echo dp($articleLanguageInfo, "Reset Search");
						?></button>
					</div>
					<div class="col-xs-12 col-md-3" style="margin-top:5px;">
						<button class="btn btn-u form-control" onclick="searchSubmit();"><?php echo dp($articleLanguageInfo, "Search");
							?></button>
						</div>
					</div>
				</div>
				</div>

				<div id="showArticle">
				</div>

				<h1 style="color:#4d4582;font-weight:100"><?php echo dp($articleLanguageInfo, "Article Search Results");
					?></h1>
					<hr style="margin-top:0;margin-bottom:0;">					
						<div id="article-data">
						</div>
				</div> <!-- Parent Container Ends Here-->

				<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div style="background:whitesmoke">
						<div class="row">
							<div class="col-sm-6 col-sm-offset-3 text-center">
								<?php echo dp($articleLanguageInfo,"Please wait while we loading the search content"); ?>
							</div>
						</div>
					</div>
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
						searchForm.startDate = $("#postedStartDate").val();
						searchForm.endDate = $("#postedEndDate").val();
						searchForm.searchTextTitle = $("#articleTitle").val();
						searchForm.searchTextContent = $("#articleContent").val();
						searchForm.displayLanguage = $("#displayLanguage").val();
					}

					function setArticleType()
					{
						articleType = $("#articleType").val();
						if (articleType == "paid")
						{
							searchForm.paidArticle = true;
							searchForm.editorialArticle = false;
						}
						else if (articleType == "editorial")
						{
							searchForm.paidArticle = false;
							searchForm.editorialArticle = true;
						}
						else
						{
							searchForm.paidArticle = true;
							searchForm.editorialArticle = true;
						}
					}
					function searchReset()
					{
						searchForm.paidArticle = true;
						searchForm.editorialArticle = true;
						searchForm.displayLanguage = "default";
						searchForm.searchTextTitle = "";
						searchForm.searchTextContent = "";
						searchForm.startDate = "";
						searchForm.endDate = "";
						searchForm.articleId = "";
						searchForm.start = 1;
						searchForm.end = 0;
						$("#postedStartDate").val("");
						$("#postedEndDate").val("");
						$("#articleTitle").val("");
						$("#articleContent").val("");
						$("#displayLanguage").val("default");
						$("#articleType").val("both");
						setArticleType();
						searchSubmit();

					}
					function searchSubmit(page,showUrlArticleId)
					{

						getArticleSearchData();

						baseUrl ="<?php echo base_url().'article/article_search_advanced'?>";
						$("#loadingModal").modal();
						if (typeof page === "undefined")
						{
							searchForm.start=0;
						}
						else
						{
							searchForm.start=page;
						}
						if (typeof showUrlArticleId === "undefined")
						{
							searchForm.articleId = "";
							console.log("No Article Id is requested on load")
						}
						else
						{

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
						$("#postedStartDate").datepicker();
						$("#postedEndDate").datepicker();

						try
						{
							var queries = {};
							$.each(document.location.search.substr(1).split('&'),function(c,q){
								var i = q.split('=');
								queries[i[0].toString()] = i[1].toString();
							});
							searchForm.articleId = queries.articleId
						}
						catch(err)
						{
							console.log("No Query is set");

						}
						searchSubmit(1,true)
					});
				</script>
				<style>
					.article-search-form
					{
						background: #4d4582;
						color: white;
					}
				</style>

