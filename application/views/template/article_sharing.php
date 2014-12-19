<?php

?>
<html>
<head>
<meta charset="utf-8" />
<meta name="Author" content="Abrasives World." />
</head>
<body>
<p>
<b><?php echo $senderName;?></b> wants to share with you the following article from <a href="http://www.abrasivesworld.com">www.abrasivesworld.com</a>
</p>
<hr>
<b>Article Title : </b> 
<?php echo $title; ?>
<hr/>
<?php 
echo $body;
?>
<hr/>
<p>
	You can also visit the following URL to see the article in differnt language and search more abraisvesworld article.
</p>
<a href="<?php echo base_url();?>article/view/?locale=default&articleId=<?php echo $articleID;?>">Click here to see more information about this article</a>
<hr>
<p style="text-decoration:underline"><strong>About AbrasivesWorld.com</strong></p>
<p>
Abrasivesworld is a specialized abrasives portal that provides a common platform for all its abrasive communities along its value chain to interact with one another. It empowers its members to broadcast it's products and services instantly and reaching out to specific community or target audience in both its domestic and international market with no language barrier.  AbrasivesWorld allows articles to  be translated from its original languages into various languages instantly.
</p>
<p>
For more information, visit <a href="http://abrasivesworld.com">www.abrasivesworld.com</a>
</p>
<p>
<strong>IMPORTANT NOTICE</strong>: The information in this email is confidential and may also be privileged. If you are not the intended recipient, any use or dissemination of the information and any disclosure or copying of this email is unauthorised and strictly prohibited. If you have received this email in error, please delete this email and destroy any hard copies produced.
</p>
</body>
</html>