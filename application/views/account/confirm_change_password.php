<?php
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

function error_trace(& $edatav,$isvalid,& $ld)
{
$edata="<div><ul>";
if ($isvalid== true)
{
$edata= "<li style='color:gray'>".dp($ld,"your password has been changed successfully")."</li>";
}
else
{
foreach($edatav as &$value)
{
$edata .="<li style='color:orange'>".dp($ld,$value)."</li>";
}
$edata .="</ul></div>";
}
return $edata;
}
echo error_trace($errordata,$isvalid,$ldata)
?>