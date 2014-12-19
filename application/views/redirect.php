<?php
?>
<html>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>	
<meta charset="utf-8"/>
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css"></script>
</head>
<body>

<div style="text-align:center">
<div class="jumbotron">
<?php
echo "<p style='font-size:16px;font-weight:bold'>Your session is expired or You are not logged into abrasivesworld. click the link below to login to access your profile</p>";
echo "<p style='font-size:16px;font-weight:bold'>您还没有登录到abrasivesworld。点击下面的链接登录到访问您的个人资料</p>";
echo "<p><a style='font-size:14px' href='".base_url()."account/signin' class='btn btn-primary btn-lg' role='button'> Login to Abrasivesworld.</a></p>";
?>
</div>
</div>

<div class="container">
    <div class="page-header">
        <h1 id="timeline"> RFQ and Article Management System</h1>
    </div>
    <ul class="timeline">
        <li>
          <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">RFQ</h4>
              <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> Updated By Abrasivesworld</small></p>
            </div>
            <div class="timeline-body">
              <p>
			  Driven by the passion to engage the abrasives communities and allow each community to reach out to other effectively, Request for Quotation (RFQ) is developed to help members to search for the right suppliers that offer fair price at the best quality products. This is done without both geographic and language barriers.

The key features includes: 

- Sender of RFQ can decide to send their RFQ by the member group in abrasivesworld or / and to their assigned email addresses. 

- Qualified bidders shall be alerted and offer their quotation in confidence. 

- Both Sender and Bidder will have their RFQ and quotation records saved in abrasivesworld archives which will help them to retrieve information  whenever needed.

Go on, log in as the members of Abrasivesworld and enjoy the various features available that benefited our many abrasives members. Afterall, Abrasivesworld is created for the abrasives community by the abrasives community.
			  </p>
			  </div>
          </div>
        </li>
        <li class="timeline-inverted">
          <div class="timeline-badge warning"><i class="glyphicon glyphicon-credit-card"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Article Management System</h4>
            </div>
            <div class="timeline-body">
				<p>
				
				Abrasivesworld lives to its commitment to its readers and members by launching 4 additional languages into its news article – www.abrasivesworld.com.

This allows its members to publish their news updates and have them translated to different languages instantly reaching out to broader readers worldwide. The new languages are German, Hindi, Bahasa and Thai in addition to its English and Chinese languages.

Abrasivesworld believes that effective marketing means faster time-to-market and reaching out international customers. Hence, to expand its languages translation capability is an appropriate investment for Abrasivesworld to bring the benefit to its members who want to market their product effectively.   

				</p>

			</div>
          </div>
        </li>
     
    </ul>
</div>
<style>
.timeline {
  list-style: none;
  padding: 20px 0 20px;
  position: relative;
}
.timeline:before {
  top: 0;
  bottom: 0;
  position: absolute;
  content: " ";
  width: 3px;
  background-color: #eeeeee;
  left: 50%;
  margin-left: -1.5px;
}
.timeline > li {
  margin-bottom: 20px;
  position: relative;
}
.timeline > li:before,
.timeline > li:after {
  content: " ";
  display: table;
}
.timeline > li:after {
  clear: both;
}
.timeline > li:before,
.timeline > li:after {
  content: " ";
  display: table;
}
.timeline > li:after {
  clear: both;
}
.timeline > li > .timeline-panel {
  width: 46%;
  float: left;
  border: 1px solid #d4d4d4;
  border-radius: 2px;
  padding: 20px;
  position: relative;
  -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
  box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
}
.timeline > li > .timeline-panel:before {
  position: absolute;
  top: 26px;
  right: -15px;
  display: inline-block;
  border-top: 15px solid transparent;
  border-left: 15px solid #ccc;
  border-right: 0 solid #ccc;
  border-bottom: 15px solid transparent;
  content: " ";
}
.timeline > li > .timeline-panel:after {
  position: absolute;
  top: 27px;
  right: -14px;
  display: inline-block;
  border-top: 14px solid transparent;
  border-left: 14px solid #fff;
  border-right: 0 solid #fff;
  border-bottom: 14px solid transparent;
  content: " ";
}
.timeline > li > .timeline-badge {
  color: #fff;
  width: 50px;
  height: 50px;
  line-height: 50px;
  font-size: 1.4em;
  text-align: center;
  position: absolute;
  top: 16px;
  left: 50%;
  margin-left: -25px;
  background-color: #999999;
  z-index: 100;
  border-top-right-radius: 50%;
  border-top-left-radius: 50%;
  border-bottom-right-radius: 50%;
  border-bottom-left-radius: 50%;
}
.timeline > li.timeline-inverted > .timeline-panel {
  float: right;
}
.timeline > li.timeline-inverted > .timeline-panel:before {
  border-left-width: 0;
  border-right-width: 15px;
  left: -15px;
  right: auto;
}
.timeline > li.timeline-inverted > .timeline-panel:after {
  border-left-width: 0;
  border-right-width: 14px;
  left: -14px;
  right: auto;
}
.timeline-badge.primary {
  background-color: #2e6da4 !important;
}
.timeline-badge.success {
  background-color: #3f903f !important;
}
.timeline-badge.warning {
  background-color: #f0ad4e !important;
}
.timeline-badge.danger {
  background-color: #d9534f !important;
}
.timeline-badge.info {
  background-color: #5bc0de !important;
}
.timeline-title {
  margin-top: 0;
  color: inherit;
}
.timeline-body > p,
.timeline-body > ul {
  margin-bottom: 0;
}
.timeline-body > p + p {
  margin-top: 5px;
}
</style>
</body></html>";
