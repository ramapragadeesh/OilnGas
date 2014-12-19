<?php
function email_verify($tou)
{

// multiple recipients
$to  = $tou;

// subject
$subject = 'AbrasivesWorld Account';

// message
$message = '
<html>
<head>
  <title>Abrasives World Account</title>
</head>
<body>
<p>You have signed up for abrasives world account </p>
  <p> You can activate your account by click the below link</p>
  <a href="http://abrasivesworld.com/alpha/account/signin"> Activate my account</a>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

// Additional headers
$headers .= 'To: '.$tou . "\r\n";
$headers .= 'From: support@abrasivesworld.com' . "\r\n";

// Mail it
mail($to, $subject, $message, $headers);

}
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

if (count($vdata)== 0) {

	if ($autoUser == true) {
			echo "<p style='colo:green'>
			<b>".dp($lf,"Your account has been created successfully, we have sent you an activation email to your account to login into our website").".</b>
			<input type='hidden' id='dynca' name='dynca'>
			</p>";	
	}
	else if ($uexd== true) {
	echo "<p><b>".dp($lf,"you email id is already registered, if you have problem loggin in, you can recover the password by using below link").".</b>
	</p>
	<a href='signin'>".dp($lf,"Recover my password")."</a>";

	} else {

			echo "<p style='colo:green'>
			<b>".dp($lf,"Your account has been created successfully, we have sent you an activation email to your account to login into our website").".</b>
			<input type='hidden' id='dynca' name='dynca'>
			</p>";	

	}
} else {

$vdisplay="<div><ul>";

foreach ($vdata as &$value) {
$vdisplay .= "<li style='font-size:12px;color:orange'>". dp($lf,$value) ."</li>";
}

echo $vdisplay."</ul></div>";
}


?>
