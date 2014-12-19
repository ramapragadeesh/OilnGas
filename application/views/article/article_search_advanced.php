<?php
function dp($info_holderdy,$f,$fsl="")
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
function article_render(& $article_in, & $hph,$lang,$searchLanguage)
{

	$article_data = "";
	foreach ($article_in as &$value)
	{
		$articleDescription = "";
		$articleTitle = "";

		if ($searchLanguage == $value->article_lang)
		{
			$articleDescription=$value->article_details;
		}
		elseif ($searchLanguage == "default")
		{
			$articleDescription=$value->article_details;
			$articleTitle=$value->article_title;
		}
		elseif ($searchLanguage == "en")
		{
			$articleDescription=$value->article_en;
			$articleTitle=$value->arttitle_en;
		}
		elseif ($searchLanguage == "zh-cn")
		{
			$articleDescription=$value->article_ch;
			$articleTitle=$value->arttitle_ch;
		}
		elseif ($searchLanguage == "th")
		{
			$articleDescription=$value->article_th;
			$articleTitle=$value->arttitle_th;
		}
		elseif ($searchLanguage == "hi")
		{
			$articleDescription=$value->article_hi;
			$articleTitle=$value->arttitle_hi;
		}
		elseif ($searchLanguage == "de")
		{
			$articleDescription=$value->article_de;
			$articleTitle=$value->arttitle_de;
		}
		elseif ($searchLanguage == "id")
		{
			$articleDescription=$value->article_bh;
			$articleTitle=$value->arttitle_bh;
		}

		$article_data .= '
		<div class="row">
			<div class="col-xs-12 col-md-3">
				<h5>'.dp($hph,"Article Title").' : </h5>
			</div>
			<div class="col-xs-12 col-md-9">
				<p>'.$articleTitle.'</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-3">
				<h5>'.dp($hph,"Organazation Name").' : </h5>
			</div>
			<div class="col-xs-12 col-md-9">
				<p>'.$value->article_org.'</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-3">
				<h5>'.dp($hph,"Author").' : </h5>
			</div>
			<div class="col-xs-12 col-md-9">
				<p>'.$value->article_author.'</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-3">
				<h5>'.dp($hph,"Article Date").' : </h5>
			</div>
			<div class="col-xs-12 col-md-9">
				<p>'.$value->article_date.'</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<h5>'.$articleDescription.' : </h5>
			</div>
		</div>

		';

	}
	return $article_data;
}

?>
<?php
$paginationInfo = "";
$paginationInfoPages = "";
$sub1 = $p - 1;
$sub2 = $p - 2;
$add1 = $p + 1;
$add2 = $p + 2;
		// show previous button

$totalPages = $lastPage;
$showPages = 10;
$pinfo = "";
$currentPage = $p;

if ( $totalPages > $showPages ) {
	$page=$p;
	if ($p != 1 ) {
	$pinfo .= '<li><span  style="cursor:pointer;" onclick="searchSubmit('.($p-1).')">&laquo;</span>';
	}

	for( $page=$p; $page <= ($p + ($showPages-1) ); $page++) {

		if ($page == $p ) {
		$pinfo .= '<li class="active"><span>'.$page.'</span>';
		} else if ($page > $totalPages) {

		}
		else {
		$pinfo .= '<li><span  style="cursor:pointer;" onclick="searchSubmit('.$page.')">'.$page.'</span>';
		}

	}
	$page = ($page > $totalPages ? $totalPages : $page);
	$pinfo .= '<li><span  style="cursor:pointer;" onclick="searchSubmit('.($page).')">&raquo;</span>';
} else {
for( $page=1; $page <= $totalPages; $page++) {
	if ($page == $p) {
	$pinfo .= '<li class="active"><span>'.$page.'</span>';
	} else {
	$pinfo .= '<li><span  style="cursor:pointer;" onclick="searchSubmit('.$page.')">'.$page.'</span>';
	}
  }
}

if ($lastPage != "1")
{
	if ($p != 1)
	{
		$previous = $p - 1;
		$paginationInfo .=  '<li><span class="page-cursor" onclick="searchSubmit('.$previous.')">&laquo;</span>';
	}
}

if ($p == 1)
{
	$paginationInfo .= '<li class="active"><span>' . $p. '</span></li>';
	$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$add1.');return false;">'.$add1.'</span></li>';
}
else if ($p == $lastPage)
{
	$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$sub1.');return false;">'.$sub1.'</span></li>';
	$paginationInfo .= '<li class="active"><span>' . $p. '</span></li>';
}
else if ($p > 2 && $p < ($lastPage - 1))
{
	$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$sub2.');return false;">'.$sub2.'</span></li>';
	$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$sub1.');return false;">'.$sub1.'</span></li>';
	$paginationInfo .= '<li class="active"><span>' . $p. '</span></li>';
	$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$add1.');return false;">'.$add1.'</span></li>';
	$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$add2.');return false;">'.$add2.'</span></li>';
}
else if ($p > 1 && $p < $lastPage)
{
	$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$sub1.');return false;">'.$sub1.'</span></li>';
	$paginationInfo .= '<li class="active"><span>' . $p. '</span></li>';
	$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$add1.');return false;">'.$add1.'</span></li>';
}
		// show previous button
if ($lastPage != "1")
{
	if ($p != $lastPage)
	{
		$nextPage = $p + 1;
		$paginationInfo .= '<li><span class="page-cursor" onclick="searchSubmit('.$nextPage.')">&raquo;</span></li>';
	}
}

?>
<?php
if ($lastPage != "1")
{
	$paginationInfoPages .= 'Page <span class="badge">' . $p . '</span> of <span class="badge" style="background:#4d4582;">' . $lastPage. '</span>';
}
?>

<?php
error_reporting(1);
if ( $searchResultEmpty == true)
{
	echo "<div style='margin-bottom:10px'>
	<h5 style='color:red'>
		".dp($homePageTranslation,"No article is found based on your search criteria. Please try again")."
	</h5>
	<span onclick='searchReset()' class='label label-warning' style='cursor:pointer'>
		".dp($homePageTranslation,"You can reset your search by clicking here")."
	</span>
</div>";
return;
}
else if ($singleArticle == true )
{
// Single Article Render
	?>

	<div>
		<?php echo article_render($articleData,$homePageTranslation,$userLanguage,$displayLanguage)	?>
	</div>

	<?php
}
else
{
	// Search Results
	?>
	<div id="searchPagination1" style="margin-top:10px">
		<div class="row">
			<div class="col-xs-12 col-md-9">
				<ul class="pagination" style="margin:0 0 0 0;">
					<?php echo $pinfo;?>
				</ul>
			</div>
			<div class="col-xs-12 col-md-3">
				<?php echo $paginationInfoPages;?>
			</div>
		</div>
	</div>
	<hr style="margin-top:3px;margin-bottom:3px;">

	<div>
		<?php echo article_render($articleData,$homePageTranslation,$userLanguage,$displayLanguage)	?>
	</div>

	<hr style="margin-top:3px;margin-bottom:3px;">

	<div id="searchPagination2" style="margin-top:10px">
		<div class="row">
			<div class="col-xs-12 col-md-9">
				<ul class="pagination" style="margin:0 0 0 0;">
					<?php echo $pinfo;?>
				</ul>
			</div>
			<div class="col-xs-12 col-md-3">
				<?php echo $paginationInfoPages;?>
			</div>
		</div>
	</div>

	<?php
}
?>
