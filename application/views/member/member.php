<?php
function dp($info_holderdy,$f,$fsl="")
{
  $rt=$f;

  if ($fsl == "F" && strtolower($f)== "annual output")
  {
    $rt="Annual Consumption";
  }

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
?>
<div class="container">
<div class="" style="margin-top:10px">
<div class="panel panel-default">
  <div class="panel-heading">
    <?php echo dp($info_holder,"Members Corner");?>
  </div>
  <div class="panel-body">

    <?php

    if ($ulang == "zh-cn")
    {
      ?>

      <div id="cnab" style="">
        <p>
          研磨世界创建磨料社区服务。无论您是提供机械，原料，生产商，分销商或最终用户，我们希望能为您服务。
          <br/>
          <br/>
          我们相信，服务不应该花费巨额款项。但在同一时间，我们有信心研磨世界的特点和功能会超出我们的成员的喜悦
        </p>
        <p>
          研磨世界提供的主要服务分别是：
          <br/>
          - 创建成员帐户
          <br/>
          - 允许研磨世界的成员或编辑文章从研磨世界发邮件给成员。这让成员触摸到最新的磨料发展
        </p>
        <p>
          - 创建成员的个人资料。此配置文件形成了一个事实表，可以替代传单或链接使用方便成员给他们的客户介绍自己的产品和服务。
        </p>
        <p>
          -成员将有额外的过滤器功能。搜索时，他们所选择的文章附加的功能包括：搜索会员组，由国家，等
        </p>
        <p>
          研磨世界也提供特别设计的辅助服务，以帮助各成员，并没有在语言或地理屏障推销他们的产品和服务，并在全球范围内提高品牌知名度。
        </p>
        <p>
          它们包括:
        </p>
        <p>
          -允许研磨世界从它的成员或编辑的文章发邮件给成员。这具有额外制设置让成员过滤所选择的文章（成员组）。它可以让成员专注于成员感兴趣的文章。
        </p>
        <p>
          -允许成员瞬间的创建和发布自己产品或服务的文章。研磨世界可以自动翻译文章成各种语言由研磨世界提供。它可以帮助成员达到了毫不费力地和有效地向全球市场和国际客户。
        </p>
        <p>
          - 成员可以利用研磨世界个性化功能允许加载图片，视频链接，甚至您所选择的视频，以提高您的个人文章的活力
        </p>
        <p>
          -成员可要求研磨世界搜索他们选择的成员组。例如，磨料磨具生产商正在寻找在某个国家的分销商代表来他们。
        </p>
        <p>
          -成员可以利用研磨世界国际平台宣传自己产品或服务。广告将链接到会员自己的网站。
          <br/>
          <br/>
          研磨世界将不断取得新的功能和服务，给你一个意外惊喜。
        </p>
        <p>
          <br/>
          研磨世界为了我们所有的成员会致力继续提升我们的服务和网站功能。这是我们的承诺。
        </p>
      </div>
      <?php
    }
    else
    {
      ?>

      <div id="enab">

        <div>
          <div class="page-header" style="margin:0 0 0 0">
            <p>AbrasivesWorld.com is created to serve the abrasives communities regardless if you are supplying machinery, raw material, producers, distributors or end users.
            </p><p>

            We believe services should not cost or at a hefty amount to its members although we are confident that the features AbrasivesWorld offers would exceed the delight of our members.
          </p><p>
          Members can enjoy the following</p>
        </div>
        <ul class="timeline">
         <li>
          <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Personalised URL link of member’s profile</h4>
              <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> Updated By Abrasivesworld</small></p>
            </div>
            <div class="timeline-body">
              <p>

                Abrasivesworld enables members to create their personalise Company Profile Pages at absolutely not cost. Anyone in the abrasives community can create, personalised and generate their company profile page. This service is absolutely free and as easy as 1-2-3 and takes less than 5 minutes.
                <br><br/>


                This features brings many benefit to our members. They are:
                <br/>
                - members can decide to save into English or Chinese format.<br/>

                - members can enable this Company fact sheet to be downloaded into PDF format.<br/>

                - member’s Company fact sheet will have an unique URL link that allow information to be shared to others.<br/>

                - member’s Company fact sheet can be make available (if authorised by you) for service match search request<br/>

                - member’s Company fact sheet can be make available (if authorised by you) to parties in their Request for Quotation



              </p>
            </div>
          </div>
        </li>
        <li>
          <div class="timeline-badge warning"><i class="glyphicon glyphicon-credit-card"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">Article Management System</h4>
            </div>
            <div class="timeline-body">
              <p>

                Abrasivesworld lives to its commitment to its readers and members by launching 4 additional languages into its news article. This allows its members to publish their news updates and have them translated to different languages instantly reaching out to broader readers worldwide. The personalised article column allows members to load pictures, video link and even video of your choice to enhance the dynamism of your personal article. These article can either be posted onto <a href="http://www.abrasivesworld.com">www.abrasivesworld.com</a>, or assigned to target member’s group or to the member’s assigned email addresses.

                <br/><br/>

                Today, Abrasivesworld can offer its article to German, Hindi, Bahasa and Thai in addition to its English and Chinese languages. Abrasivesworld believes that effective marketing means faster time-to-market and reaching out international customers.
              </p>

            </div>
          </div>
        </li>

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


      </ul>
    </div>
  </div>
</div>
</div>
</div>
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
    left: 80%;
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
    width: 76%;
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
    left: 80%;
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

<?php
}
?>


