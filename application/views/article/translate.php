<?php
function article_populate(& $article_in)
{
$af="";
$idf=0;
foreach ($article_in as &$value) 
{
$af .='
<div>
<b>'."Article".' : </b> '.$value->article_title.'
</div>
<div>
<b>'. "Date".' : </b> '.$value->article_date.'
</div>
<div>
<b>'."Author".' : </b> '.$value->article_author.'
</div>
<br/>
<div>
'.$value->article_details.'
</div>
';
}
return $af;
}

function connect_google($content)
{
$content=urlencode($content);
$translate = file_get_contents("https://www.googleapis.com/language/translate/v2?key=AIzaSyAqEhtDrrTMdUfXLz40-_F-0gZ8B9Bgt-M&q=$content&source=en&target=fr");
//$translate= utf8_encode($translate); 
$arr = json_decode($translate, true);
return  $arr['data']['translations'][0]['translatedText'];
}
$rt="";
$body_array = str_split(article_populate($lang_holder), 500);
?>
<?php
foreach($body_array as &$value)
{
$rt .=connect_google($value);
}
echo $rt;
?>
