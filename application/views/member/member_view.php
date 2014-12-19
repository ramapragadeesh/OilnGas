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


function abrasiveUsersList(& $au, & $languageInfo)
{
	$html="";
	foreach ($au as &$value)
	{
		if ($value->au_category=="Others, please specify") {
			$html .='<li><a onclick="abUsersTypeSet('.$value->au_id.');return false;">'.dp($languageInfo,"Others").'</a></li>';
		} else {
			$html .='<li><a onclick="abUsersTypeSet('.$value->au_id.');return false;">'.dp($languageInfo,$value->au_category).'</a></li>';
		}
	}

	return $html;
}
?>
<script type="text/javascript" language="javascript" src="<?php echo base_url();?>/application/js/bootstrap3-typeahead.min.js"></script>
<div class="container" id="parentContainer" style="background:whitesmoke">  <!-- Parent Container Starts Here-->
	<div style="background:rgb(202, 197, 197);padding-top:5px;padding-left:10px;padding-bottom:10px">
	<h3 style="color:#4d4582;font-weight:100"><?php echo dp($memberLanguageInfo, "Member Listing Search");
		?></h3>
		<hr style="margin-top:0px!important;margin-bottom:0;px!important">
			<div class="row">
				<div class="col-xs-12 col-md-3" style="margin-top:15px">
					<label><?php echo dp($memberLanguageInfo, "Member Type");?></label>
				</div>
				<div class="col-xs-12 col-md-3">
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="memberTypeLabel">
							Available Member Types
							</a>
							<ul class="dropdown-menu" id="memberTypes">
								<li class="active"><a membertype="ALL" href="" onclick="memberTypeSet('ALL',this);return false;"><?php echo dp($memberLanguageInfo, "All");?></a></li>
								<li><a membertype="A" href="" onclick="memberTypeSet('A',this);return false;"><?php echo dp($memberLanguageInfo, "Machine / Equipment  Supplier");?></a></li>
								<li><a membertype="B" href="" onclick="memberTypeSet('B',this);return false;"><?php echo dp($memberLanguageInfo, "Raw Material Supplier");?></a></li>
								<li><a membertype="C" href="" onclick="memberTypeSet('C',this);return false;"><?php echo dp($memberLanguageInfo, "Abrasive Producer (Bonded)");?></a></li>
								<li><a membertype="Z" href="" onclick="memberTypeSet('Z',this);return false;"><?php echo dp($memberLanguageInfo, "Abrasive Producer (Coated)");?></a></li>
								<li><a membertype="D" href="" onclick="memberTypeSet('D',this);return false;"><?php echo dp($memberLanguageInfo, "Coated Abrasive Converter");?></a></li>
								<li><a membertype="E" href="" onclick="memberTypeSet('E',this);return false;"><?php echo dp($memberLanguageInfo, "Distributor( Bonded or Coated Abrasive)");?></a></li>
								<li><a membertype="F" href="" onclick="memberTypeSet('F',this);return false;"> <?php echo dp($memberLanguageInfo, "Abrasive Users");?></a></li>
							</ul>
						</li>
					</ul>
				</div>

			</div>
			<div class="row" style="display:none">
				<div class="col-xs-12 col-md-3" style="margin-top:15px">
					<label>
						<?php echo dp($memberLanguageInfo, "Abrasives users list");?>
					</label>
				</div>
				<div class="col-xs-12 col-md-3">
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Abrasives users list<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<?php echo abrasiveUsersList($abrasivesUsers,$memberLanguageInfo); ?>
							</ul>
						</li>
					</ul>
				</div>
			</div>

			<div class="row" style="margin-top:10px;margin-bottom:5px">
				<div class="col-xs-12 col-md-3" style="margin-top:5px;">
					<label>
						<?php echo dp($memberLanguageInfo, "Organazation Name");?>
					</label>
				</div>
				<div class="col-xs-12 col-md-3" style="margin-top:5px;">
					<input type="text" class="form-control" id="orgName">
				</div>
			</div>


			<div class="row" style="margin-top:10px;margin-bottom:5px">
				<div class="col-xs-12 col-md-3" style="margin-top:5px;">
					<label><?php echo dp($memberLanguageInfo, "Organazation Country");?></label>
				</div>
				<div class="col-xs-12 col-md-3" style="margin-top:5px;">
					<input type="text"  data-items="4" data-provide="typeahead" class="form-control" id="countryName">
				</div>
			</div>

			<div class="row" style="margin-top:10px;margin-bottom:5px">
				<div class="col-xs-12 col-md-3" style="margin-top:5px;">
					<button class="btn btn-u form-control" onclick="searchReset();">
						<?php echo dp($memberLanguageInfo, "Reset Search");?>
					</button>
				</div>
				<div class="col-xs-12 col-md-3" style="margin-top:5px;">
					<button class="btn btn-u form-control" onclick="searchSubmit();">
						<?php echo dp($memberLanguageInfo, "Search");?>
					</button>
				</div>
			</div>

		</div>

		<div id="showMembers">
		</div>
		<h4 style="color:#4d4582;">
			<?php echo dp($memberLanguageInfo, "Member Listing Search Results");?>
		</h4>
		<hr style="margin-top:0;margin-bottom:0;">

		<div class="container">
			<div id="member-data">
			</div>
		</div>
	</div> <!-- Parent Container Ends Here-->



	<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="container" style="background:whitesmoke">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3 text-center">
					<span class="ajaxloader1"> </span><br/><?php echo dp($memberLanguageInfo, "Please wait while we loading the search content");?>
				</div>
			</div>
		</div>
	</div>

	<script>
		var searchForm =
		{
			"memberTypes":['ALL'],
			"abrasivesUsersTypes":['ALL'],
			"countryName":"",
			"orgName":"",
			"start":1,
			"end":0
		};

		function memberTypeSet(memberGroupInfo,elem)	{
			searchForm.memberTypes = [];
			searchForm.memberTypes.push(memberGroupInfo);
			
			$(elem).parent().parent().children().removeClass("active");
			$(elem).parent().addClass("active");
			$("#memberTypeLabel").text($(elem).text());


		}
		function abUsersTypeSet(userGroupInfo) {
			if (userGroupInfo == "ALL") {
				searchForm.abrasivesUsersTypes = [];
				searchForm.abrasivesUsersTypes.push(userGroupInfo);
			} else {
				i = searchForm.abrasivesUsersTypes.indexOf("ALL");
				if ( i != -1) {
					searchForm.abrasivesUsersTypes.splice(i, 1);
					searchForm.abrasivesUsersTypes.push(userGroupInfo);
				} else {
					searchForm.abrasivesUsersTypes.push(userGroupInfo);
				}
			}
		}
		function searchReset() {
			searchForm.memberTypes = ['ALL'];
			searchForm.abrasivesUsersTypes = ['ALL'];
			searchForm.countryName = "";
			searchForm.orgName = "";
			searchForm.start = 1;
			searchForm.end = 0;

			$("#orgName").val("");
			$("#countryName").val("");
			$("#memberTypeLabel").text('<?php echo dp($memberLanguageInfo, "All");?>');
			searchSubmit();
		}

		function getSearchData() {
			searchForm.orgName     = $("#orgName").val();
			searchForm.countryName = $("#countryName").val();
		}

		function searchSubmit(page) {

			baseUrl ="<?php echo base_url().'member/member_search_advanced'?>";
			getSearchData();
			$("#loadingModal").modal();
			if (typeof page === "undefined") {
				searchForm.start=0;
			} else {
				searchForm.start=page;
			}
			$.ajax({
				url: baseUrl,
				type: 'POST',
				data: {searchForm : JSON.stringify(searchForm)},
				success: function(msg) {
					$("#member-data").html(msg)
					$("#loadingModal").modal("hide");
				}
			});
		}
		var country_list = ['Others'];		

		$('#countryName').typeahead({source: country_list});

		$.getJSON('<?php echo base_url();?>general/country_list', function(data) {
			$.each(data, function(key, val) {
				country_list.push(val.country_name);
			});
		});

		$(document ).ready(function() {
			try {
				var queries = {};
				$.each(document.location.search.substr(1).split('&'),function(c,q){
					var i = q.split('=');
					queries[i[0].toString()] = i[1].toString();
				});
				elInfo = "a[membertype='"+queries.member_type+"']";
				e = $(elInfo)
				memberTypeSet(queries.member_type,e)
				console.log(queries.member_type)
			} catch(err) {
				console.log("No Query is set");
			}

			searchSubmit();
		});
	</script>
	<style>
		.article-search-form
		{
			background: #4d4582;
			color: white;
		}
		.glyphicon {  margin-bottom: 10px;margin-right: 10px;}

		small {
			display: block;
			line-height: 1.428571429;
			color: #999;
		}
		.page-cursor
		{
			cursor: pointer;
		}
	</style>