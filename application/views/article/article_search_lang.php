<?php
function dp($info_holderdy,$f,$fsl="") {
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

function article_render(& $article_in, & $hph,$lang,$searchLanguage) {

	$article_data = "";
	foreach ($article_in as &$value)
	{
		$containsVideo = false;
		$videoContent = "";
		$containsImage = false;
		$imageContent = "";

		$articleDescription = "";
		$articleTitle = "";
		$articleDesc = "";

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

		try
		{
			$dom = new DOMDocument;
			libxml_use_internal_errors(true);
			$dom->loadHTML($value->article_details);
			$frames = $dom->getElementsByTagName('iframe');
			$videos = $dom->getElementsByTagName('p');
			$images = $dom->getElementsByTagName('img');

			$domArticle = new DOMDocument;
			$articleUTF8 = mb_convert_encoding($articleDescription, 'HTML-ENTITIES', "UTF-8");
			$domArticle->loadHTML($articleUTF8);

			$paragraphs = $domArticle->getElementsByTagName('p');

			$getIndex = 1;
			foreach ($paragraphs as $paragraph) {
				if ($getIndex == 1) {
					$getIndex = $getIndex+1;
					$articleDesc = $paragraph->nodeValue;
					$articleDesc = trim($articleDesc);
					if (strlen($articleDesc) > 350 ) {
						$articleDesc = substr($articleDesc, 0,349);
						$pad_string = "&#160;";
						$articleDesc = str_pad($articleDesc, strlen($articleDesc)+(400*strlen($pad_string)), $pad_string, STR_PAD_RIGHT);
					} else {
						$pad_string = "&#160;";
						$articleDesc = str_pad($articleDesc, strlen($articleDesc)+(400*strlen($pad_string)), $pad_string, STR_PAD_RIGHT);
					}
					break;
				}
			}

			foreach ($frames as $frame) {
				if (strpos($frame->getAttribute('src'), 'www.youtube.com/embed') !== false) {
					$containsVideo = true;
					$containsImage = true;
					$videoContent= '<iframe allowfullscreen="allowfullscreen" width="100%"  height="250" src="'.$frame->getAttribute('src').'"></iframe>';
				}
			}
			$k=0;

			foreach ($videos as $video) {
				$v=$videos->item($k)->getElementsByTagName('video')->item(0);
				if ($v != null) {
					$containsVideo = true;
					$containsImage = true;
					$videoContent= '<video controls="controls" width="100%" height="250"><source src="'.$v->firstChild->getAttribute("src").'" type="video/mp4" /></video>';
					break;
				}
				$k++;
			}
			foreach ($images as $image) {
				if ( $containsImage == true ) {
					break;
				}
				$containsImage = true;
				$imageContent= '<img  width="100%" height="250" src="'.$image->getAttribute('src').'" />';

			}
		}
		catch(Exception $e)
		{
		// ignore the error
		}

		$mediaContent = "";

		if ( $containsVideo == true) {
			$mediaContent = $videoContent;
		} else {
			if ($containsImage == true) {
				$mediaContent = $imageContent;
			} else {
				$mediaContent = $articleDesc;
			}
		}
		$articleURL = base_url()."article/view/?articleId=".$value->article_id."&locale=".$searchLanguage."#showArticle";

		$article_data .= '
		<li class="col-md-3 col-xs-12" >
			<div>
				<div class="thumbnail" style="padding: 0;height:450px;!important">
					<div style="padding:3px">
						'.$mediaContent.'

						<hr style="margin-top:0px;margin-bottom:0px;">
					</div>
					<div class="caption">
						<b>'.dp($hph,"Article Title").' : </b>
						<span>'.$articleTitle.'</span>
					</div>
					<div class="modal-footer" style="text-align:left;padding-top:5px;">

						<div class="row">
							<div class="col-md-12 col-xs-12">
								<b>'.dp($hph,"Article Date").':</b> '.$value->article_date.'
							</div>
						</div>


						<div class="row" style="margin-top:5px;margin-bottom:5px">
							<div class="col-md-12 col-xs-12">
								<a class="btn btn-u form-control" href="'.$articleURL.'">'.dp($hph,"View More").'</a>
							</div>
						</div>

					</div>

				</div>
			</div>
		</li>';

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

$totalPages = $lastPage;
$showPages = 10;
$pinfo = "";
$currentPage = $p;

if ( $totalPages > $showPages ) {
	$page=$p;
	if ($p != 1 ) {
	$pinfo .= '<li><span  style="cursor:pointer;" onclick="search('.($p-1).')">&laquo;</span>';
	}

	for( $page=$p; $page <= ($p + ($showPages-1) ); $page++) {

		if ($page == $p ) {
		$pinfo .= '<li class="active"><span>'.$page.'</span>';
		} else if ($page > $totalPages) {

		}
		else {
		$pinfo .= '<li><span  style="cursor:pointer;" onclick="search('.$page.')">'.$page.'</span>';
		}

	}
	$page = ($page > $totalPages ? $totalPages : $page);
	$pinfo .= '<li><span  style="cursor:pointer;" onclick="search('.($page).')">&raquo;</span>';
} else {
for( $page=1; $page <= $totalPages; $page++) {
	if ($page == $p) {
	$pinfo .= '<li class="active"><span>'.$page.'</span>';
	} else {
	$pinfo .= '<li><span  style="cursor:pointer;" onclick="search('.$page.')">'.$page.'</span>';
	}
  }
}




$paginationInfoNew = "";

for($page = 1; $page <= $totalPages; $page++) {
	if ($page == $p) {
		$paginationInfoNew .=  '<li class="active"><span>'.$page.'</span>';
	} else {
		$paginationInfoNew .=  '<li><span  style="cursor:pointer;" onclick="search('.$page.')">'.$page.'</span>';
	}
}

if ($lastPage != "1") {
	if ($p != 1) {
		$previous = $p - 1;
		$paginationInfo .=  '<li><span class="page-cursor" onclick="search('.$previous.')">&laquo;</span>';
	}
}

if ($p == 1) {
	$paginationInfo .= '<li class="active"><span>' .$p. '</span></li>';
	$paginationInfo .= '<li><span class="page-cursor" onclick="search('.$add1.');return false;">'.$add1.'</span></li>';
} else if ($p == $lastPage) {
	$paginationInfo .= '<li><span class="page-cursor" onclick="search('.$sub1.');return false;">'.$sub1.'</span></li>';
	$paginationInfo .= '<li class="active"><span>' . $p. '</span></li>';
} else if ($p > 2 && $p < ($lastPage - 1)) {
	$paginationInfo .= '<li><span class="page-cursor" onclick="search('.$sub2.');return false;">'.$sub2.'</span></li>';
	$paginationInfo .= '<li><span class="page-cursor" onclick="search('.$sub1.');return false;">'.$sub1.'</span></li>';
	$paginationInfo .= '<li class="active"><span>' . $p. '</span></li>';
	$paginationInfo .= '<li><span class="page-cursor" onclick="search('.$add1.');return false;">'.$add1.'</span></li>';
	$paginationInfo .= '<li><span class="page-cursor" onclick="search('.$add2.');return false;">'.$add2.'</span></li>';
} else if ($p > 1 && $p < $lastPage) {
	$paginationInfo .= '<li><span class="page-cursor" onclick="search('.$sub1.');return false;">'.$sub1.'</span></li>';
	$paginationInfo .= '<li class="active"><span>' . $p. '</span></li>';
	$paginationInfo .= '<li><span class="page-cursor" onclick="search('.$add1.');return false;">'.$add1.'</span></li>';
}
		// show previous button
if ($lastPage != "1")
{
	if ($p != $lastPage)
	{
		$nextPage = $p + 1;
		$paginationInfo .= '<li><span class="page-cursor" onclick="search('.$nextPage.')">&raquo;</span></li>';
	}
}

?>
</ul>
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
else
{
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

	<div class="row">
		<ul class="thumbnails list-unstyled">
			<?php echo article_render($articleData,$homePageTranslation,$userLanguage,$displayLanguage)	?>
		</ul>
	</div>

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
	<hr style="margin-top:3px;margin-bottom:3px;">
	<?php
}
?>