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
<div class="container" style="margin-top:10px">
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
            <div class="page-header" style="margin:0 0 0 0">

              <h1 id="timeline" style="font-weight:100">以下突出AbrasivesWorld的发展里程碑...</h1>
            </div>
            <ul class="timeline">
             <li>
              <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="timeline-title"></h4>
                  <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>2014年9月1日</small></p>
                </div>
                <div class="timeline-body">
                  <p>
                    启动自动显示尺寸调整功能。读者可以查看abrasivesworld在其手机，平板电脑，笔记本电脑或计算机上。
                  </p>
                </div>
              </div>
            </li>
            <li>
              <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="timeline-title"></h4>
                  <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>2014年9月1日</small></p>
                </div>
                <div class="timeline-body">
                  <p>
                  推出，增强用户体验全新的用户界面。它包含了古典和现代的展示，以适应不同读者的喜好。
                  </p>
                </div>
              </div>
            </li>

             <li>
              <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="timeline-title"></h4>
                  <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>2014年8月30 </small></p>
                </div>
                <div class="timeline-body">
                  <p>
                  启动AbrasivesWorld成员列表和搜索功能。
                  </p>
                </div>
              </div>
            </li>

             <li>
              <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="timeline-title"></h4>
                  <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 2014年3月14日</small></p>
                </div>
                <div class="timeline-body">
                  <p>
                  – Abrasivesworld和Pose Media合作，带来更多新闻其共同的读者。
                  </p>
                </div>
              </div>
            </li>

             <li>
              <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="timeline-title"></h4>
                  <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>2014年3月8日</small></p>
                </div>
                <div class="timeline-body">
                  <p>
                  - 推出个性化的个人资料页与独特的网络地址。
                  </p>
                </div>
              </div>
            </li>

             <li>
              <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="timeline-title"></h4>
                  <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>2014年2月19日</small></p>
                </div>
                <div class="timeline-body">
                  <p>
                  – 推出索取报价功能。

                  </p>
                </div>
              </div>
            </li>

                  <li>
              <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="timeline-title"></h4>
                  <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>2013年12月28日</small></p>
                </div>
                <div class="timeline-body">
                  <p>
                  –推出额外的4种主要语言来自动翻译的文章。语言包括：德语，印地文，泰文和马来语（除了现有的中国和英语）。
                  </p>
                </div>
              </div>
            </li>

                  <li>
              <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="timeline-title"></h4>
                  <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>2013年7月30日 </small></p>
                </div>
                <div class="timeline-body">
                  <p>
                  – 推出文章管理系统，使成员张贴的文章，插入图片，视频即时，同时允许读者将文章翻译为首选语言。
                  </p>
                </div>
              </div>
            </li>
          </ul>
          </div>
          <?php
        }
        else
        {
          ?>

          <div id="enab">
              <div class="page-header" style="margin:0 0 0 0">
              <h1 id="timeline" style="font-weight:100"> Below highlight the development milestones of AbrasivesWorld</h1>
            </div>
            <ul class="timeline">
             <li>
              <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="timeline-title"></h4>
                  <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 1st Sept 2014</small></p>
                </div>
                <div class="timeline-body">
                  <p>
                    – Launches automatic display resizing capability. Readers can view abrasivesworld on its mobile phone, tablet, laptop or computer.
                  </p>
                </div>
              </div>
            </li>
            <li>
              <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="timeline-title"></h4>
                  <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 1st Sept 2014</small></p>
                </div>
                <div class="timeline-body">
                  <p>
                  – Launches complete new user interface that enhances user’s experience. It contains both Classic and Modern Display to suit the different readers’ preference.
                  </p>
                </div>
              </div>
            </li>

             <li>
              <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="timeline-title"></h4>
                  <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 30th August 2014</small></p>
                </div>
                <div class="timeline-body">
                  <p>
                  – Launches Listing and Search capability of AbrasivesWorld members.
                  </p>
                </div>
              </div>
            </li>

             <li>
              <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="timeline-title"></h4>
                  <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 14th March 2014</small></p>
                </div>
                <div class="timeline-body">
                  <p>
                  – Abrasivesworld and Pose Media in collaboration to bring more news to its readers.
                  </p>
                </div>
              </div>
            </li>

             <li>
              <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="timeline-title"></h4>
                  <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>8th March 2014</small></p>
                </div>
                <div class="timeline-body">
                  <p>
                  - Launch personalised member profile pages with unique web address.
                  </p>
                </div>
              </div>
            </li>

             <li>
              <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="timeline-title"></h4>
                  <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>19th Feb 2014</small></p>
                </div>
                <div class="timeline-body">
                  <p>
                  – Launch Request for Quotation modules for members.

                  </p>
                </div>
              </div>
            </li>

                  <li>
              <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="timeline-title"></h4>
                  <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> 28th Dec 2013</small></p>
                </div>
                <div class="timeline-body">
                  <p>
                  – Launch additional 4 major languages for auto articles translation. The languages are German, Hindi, Thai and Bahasa Malay (in addition to existing  Chines and English).
                  </p>
                </div>
              </div>
            </li>

                  <li>
              <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
              <div class="timeline-panel">
                <div class="timeline-heading">
                  <h4 class="timeline-title"></h4>
                  <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i>30th  July 2013</small></p>
                </div>
                <div class="timeline-body">
                  <p>
                  – launch article management system that enables members to post article, incorporate image, video instantly and at the same time allow reader to translate article to preferred languages.
                  </p>
                </div>
              </div>
            </li>
          </ul>
        </div>

<?php
}
?>

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