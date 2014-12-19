<?php
function article_original($lang)
{
  if ($lang== "en")
  {
    return "This article is originally written in English";
  }
  elseif ($lang == "zh-cn")
  {
    return "This article is originally written in Chinese";

  }

}
function article_populate(& $article_in, & $hph,$lang)
{
  $af="";
  $idf=0;
  foreach ($article_in as &$value)
  {
    $linfo="";
    $idf=$idf+1;

    if ($idf >= 10 )
    {
      break;
    }

    $idt= "idd".$idf;
    $artdata=$value->article_details;
    $rt="";
    if ($lang == $value->article_lang)
    {
      $artdata=$value->article_details;
      $rt=1;
    }
    elseif ($lang == "en")
    {
      $artdata=$value->article_en;

    }
    elseif ($lang == "zh-cn")
    {
      $artdata=$value->article_ch;
    }
    $af .='
    <div class="item  col-xs-4 col-lg-4">
      <div class="thumbnail">
        <img class="group list-group-image" src="http://placehold.it/400x250/000/fff" alt="" />
        <div class="caption">
          <h4 class="group inner list-group-item-heading" style="height:60px">
            '.str_pad($value->article_title,100,' ').'
          </h4>
          <p class="group inner list-group-item-text">

          </p>
          <p>
            <b>'. dp($hph,"Organazation Name").' : </b>'.$value->article_org.'
          </p>

          <p>
            <b>'. dp($hph,"Date").' : </b> '.$value->article_date.'
          </p>
          <p>
            <b>'. dp($hph,"Author").' : </b> '.$value->article_author.'
          </p>
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <p class="lead">
              </p>
            </div>
            <div class="col-xs-12 col-md-6">
              <a class="btn btn-u" href="http://www.jquery2dotnet.com">'. dp($hph,"More info").'</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    ';
  }
  return $af;
}
?>

<style>
  .page-cursor
  {
    cursor: pointer;

  }

</style>



<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="container" style="background:whitesmoke">
    <div class="row">
      <div class="col-sm-6 col-sm-offset-3 text-center">
        <h5>Please wait while we loading the search content</h5>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-sm-offset-3 text-center">
        <span class="ajaxloader1"></span>
      </div>
    </div>

  </div>
</div>


<div class="container bshadow" id="article-content-info" style="padding-top:10px;margin-top:10px;">
  <div class="well well-sm" style="background:#4d4582;color:white">
    <p>
      <strong><?php echo dp($homepage_holder,"Latest news and update");?></strong>
    </p>

    <nav class="navbar navbar-default" role="navigation">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="fa fa-bars"></span>
        </button>
        <a class="navbar-brand" href="" style="cursor:none">Search By</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo dp($homepage_holder,"Article Type");?></a>
            <ul class="dropdown-menu">
              <li class="active"><a id="bothArticleType" onclick="articletype('both', this);return false;" href="#"><?php echo dp($homepage_holder,"Both");?></a></li>
              <li><a href="#" id="paidArticle" onclick="articletype('paid', this);return false;"><?php echo dp($homepage_holder,"Paid Article");?></a></li>
              <li><a href="#" d="editorialArticle" onclick="articletype('editorial', this);return false;"><?php echo dp($homepage_holder,"Editorial article");?></a></li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">View article in</a>
            <ul class="dropdown-menu">
              <li class="active"><a href="#" onclick="viewLanguage('default');return false;" id="defaultLanguage"><?php echo dp($homepage_holder,"Posted in original language");?></a></li>
              <li><a href="#" onclick="viewLanguage('en',this);return false;">English</a></li>
              <li><a href="#" onclick="viewLanguage('zh-cn',this);return false;">Chinese</a></li>
              <li><a href="#" onclick="viewLanguage('de',this);return false;">German</a></li>
              <li><a href="#" onclick="viewLanguage('th',this);return false;">Thai</a></li>
              <li><a href="#" onclick="viewLanguage('hi',this);return false;">Hindi</a></li>
              <li><a href="#" onclick="viewLanguage('id',this);return false;">Bahasa</a></li>
            </ul>
          </li>
        </ul>

          <form class="navbar-form navbar-left" role="search">
              <div class="form-group">
              <input type="text" class="form-control" placeholder="<?php echo dp($homepage_holder,"Word Search");?>" name="q" id="q">
              </div>
               <span class="btn btn-u form-control" onclick="search();">Update</span>
         </form>

     </div><!-- /.navbar-collapse -->
   </nav>


 </div>
 <div id="article-data">
 </div>

</div>

<!-- DYNAMIC AD START-->
<div class="container bshadow" style="margin-top:10px;">
  <div class="row" style="padding-top:10px">
    <div class="col-xs-12 col-md-12">
      <div class="well well-sm" style="background:#4d4582;color:white">
       <h5><?php echo dp($homepage_holder,"Advertisements");?></h5>
     </div>
   </div>
 </div>

 <div id="ad-listing" class="owl-carousel">
 <?php echo bannerListing($bannerLeft);?>
 <?php echo bannerListing($bannerRight);?>
 </div>
</div>
<!-- DYNAMIC AD END-->



<script>
  var searchForm =
  {"paidArticle":true,
  "editorialArticle":true,
  "displayLanguage": "default",
  "searchText": "",
  "start":0,
  "end":0
};
var g;
function articletype(articletype,elem)
{
  if (articletype == "both") {
    searchForm.paidArticle = true;
    searchForm.editorialArticle = true;
  } else if(articletype == "paid") {
    searchForm.paidArticle = true;
    searchForm.editorialArticle = false;
  } else if (articletype == "editorial") {
    searchForm.paidArticle = false;
    searchForm.editorialArticle = true;
  }
  g = elem;
  $(elem).parent().parent().children().removeClass("active");
  $(elem).parent().addClass("active");
  $(elem).parent().parent().parent().children().first().text($(elem).text())
  return false;
}

function viewLanguage(language,elem)
{
  searchForm.displayLanguage = language;
  $(elem).parent().parent().children().removeClass("active");
  $(elem).parent().addClass("active");
  $(elem).parent().parent().parent().children().first().text($(elem).text())
  return false;
}

function searchReset()
{

  searchForm.paidArticle = true;
  searchForm.editorialArticle = true;
  searchForm.displayLanguage = "default";
  searchForm.searchText = "";
  searchForm.start = 0;
  searchForm.end = 1;

  $("#defaultLanguage").parent().parent().children().removeClass("active");
  $("#defaultLanguage").parent().addClass("active");
  $("#paidArticle").parent().parent().children().addClass("active");
  $("#q").val("");
  search();

}

function search(page)
{
  $("#loadingModal").modal();
  if (typeof page === "undefined")
  {
    searchForm.start=0;
  }
  else
  {
   searchForm.start=page;
 }
 searchForm.searchText = $("#q").val();
 $.ajax({
  url: 'article/article_search_new',
  type: 'POST',
  data: {searchForm : JSON.stringify(searchForm)},
  success: function(msg) {
    $("#article-data").html(msg)
    $("#loadingModal").modal("hide");
  }
});
}
$( document ).ready(function() {
  search();
});
</script>