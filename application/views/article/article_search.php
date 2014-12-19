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

function article_original($lang)
{
if ($lang == "en")
{
return "This article is originally written in English";
}
elseif ($lang == "zh-cn")
{
return "This article is originally written in Chinese";
}
elseif ($lang== "th")
{
return "This article is originally written in Thai";
}
elseif ($lang == "hi")
{
return "This article is originally written in Hindi";
}
elseif ($lang == "de")
{
return "This article is originally written in German";
}
elseif ($lang == "id")
{
return "This article is originally written in Bahasa";
}


}
function link_populate(& $article_in, & $hph,$lang)
{
$af="";
$idf=0;
$af="<div id='sresultsul'>
<style>
.rls
{
list-style: none;
}
</style>
<p>".dp($hph,"Search Result")."</p>
<ul>";
foreach ($article_in as &$value) 
{

$linfo="";

$idt= "idd".$idf;
if ($value->article_type==1)
{
$af .='<li class="rls" onclick="linkarticle('.$idf.');" style="font-size:12px;color:rgb(0, 85, 128);cursor:pointer;" gid="'.$idt.'"><span style="height:10px;width:10px;background-color:rgb(32, 135, 252);text-decoration:none;">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;<b style="text-decoration:underline;">'.$value->article_title.'</b></li>';

}
else
{
$af .='<li class="rls" onclick="linkarticle('.$idf.');" style="font-size:12px;color:rgb(0, 85, 128);cursor:pointer;" gid="'.$idt.'"><span style="height:10px;width:10px;background-color:rgb(213, 228, 247);text-decoration:none;">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;<b style="text-decoration:underline;">'.$value->article_title.'</b></li>';
}
$idf=$idf+1;
}
$af .= "</ul></div>";
return $af;
}

function article_populate(& $article_in, & $hph,$lang)
{
$af="";
$idf=0;
foreach ($article_in as &$value) 
{
$linfo="";
$idf=$idf+1;
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
$linfo= "<div style='color:gray;font-size:12px;font-style:italic;'><b>".dp($hph,article_original($value->article_lang))."</b></div><br/>";
} 
elseif ($lang == "zh-cn")
{
$artdata=$value->article_ch;
$linfo= "<div style='color:gray;font-size:12px;font-style:italic;'><b>".dp($hph,article_original($value->article_lang))."</b></div><br/>";
} 
$af .='
<li style="width:600px!important;height:750px!important;overflow-y:scroll;">
<div id="'.$idt.'">
'.$linfo.'
<div>
<b>'. dp($hph,"Article").' : </b> <b style="font-size:15px">'.$value->article_title.'</b>
</div>
<div>
<b>'. dp($hph,"Organazation Name").' : </b> '.$value->article_org.'
</div>
<div>
<b>'. dp($hph,"Date").' : </b> '.$value->article_date.'
</div>
<div>
<b>'. dp($hph,"Author").' : </b> '.$value->article_author.'
</div>
<br/>
<div>
'.$artdata.'
</div>
</div>
</li>
';
}
return $af;

}

?>
<?php 

if ( $sful=="yes")
{
$af=link_populate($article_holder,$homepage_holder,$usrseslang);
echo $af;
}
else
{
$af=article_populate($article_holder,$homepage_holder,$usrseslang);
if ($af== "")
{
echo dp($homepage_holder,"No Results returned from search, please try again");
}
else
{
echo '<ul id="foo6">'.$af."</ul>";
}
}
?>
