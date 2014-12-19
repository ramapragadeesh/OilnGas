<?php
function article_fulldetails(& $inf)
{
$af="";
foreach ($inf as &$value) 
{
$af .='
<div>
<b>Article : </b> '.$value->article_title.'
</div>
<div>
<b>Date : </b> '.$value->article_date.'
</div>
<div>
<b>Author : </b> '.$value->article_author.'
</div>
<br/>
<div>
'.$value->article_details.'
</div>
<hr style="width:300px;margin:5px 0px 0px 0px">
';
}
return $af;

}
?>
<div class="clearfix">
</div>
<div style="width:1024px;margin-left:auto;margin-right:auto;background-color:whitesmoke">
<div style="background-color:rgb(158, 31, 99);height:40px;color:white;text-align:center">
<b>Article Details</b>
</div>
<div style="padding-top:10px">
</div>

<div style="margin-left:20px">

<?php echo article_fulldetails($article_holder);?>

</div>

</div>