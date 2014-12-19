<?php
function dp($info_holderdy,$f)
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
if ($dv == true )
{
// check for file upload error;
if (isset($pudata['error']) == true and $pudata['error'] == '<p>You did not select a file to upload.</p>')
{
echo "<p style='color:orange'>".dp($info_holder,"Your information is successfully updated.")."</p>";
}
elseif (isset($pudata['error'])== true)
{
echo "<p style='color:orange'>".dp($info_holder,$pudata['error'])."</p>";
}
else
{
echo "<p style='color:orange'>".dp($info_holder,"Your information is successfully updated.")."</p>";
}
}
else
{
$rt="<div><ul>";
foreach($dataert as &$value)
{
$rt .= "<li style='color:orange'>".dp($info_holder,$value);
}
$rt.="<ul></div>";
echo $rt;
}
?>