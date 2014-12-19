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
<div  class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo dp($info_holder,"Aboout Abrasive World");?></h3>
    </div> 
    <div class="panel-body">
        <div>
            <?php
            if ($ulang == "zh-cn")
            {
                ?>
                <div id="cnab" style="">
                    <p>
                        研磨世界是一个专门为了磨具的网站。它提供一个共同的平台允许磨料社区进行交互
                    </p>
                    <p>
                        它允许成员广播公司的产品和服务，文章瞬间的被翻译成各种语言。这样一来公司在营销活动可以在国内和国际市场接触到特定磨料社区及目标受众。
                    </p>
                    <p>
                        研磨世界将会努力的，提高用户的体验和实用功能。我们欢迎任何意见，使我们的成员从研磨世界继续留在今天的产业演进有关。
                    </p>
                    <p>
                        谢谢你，享受这个世界的磨料 - AbrasivesWorld.com
                    </p>
                </div>
                <?php 
            }
            else
            {
                ?>

                <div id="enab" style="">
                    <p>
                        AbrasivesWorld.com is a specialized abrasives portal provides a common platform for all its abrasive communities along its value chain to interact with one
                        another.
                    </p>
                    <p>
                        It empowers its members to broadcast it’s products and services and reaching out to specific community or target audience in both its domestic and
                        international market. The articles are translated instantly into various languages.
                    </p>
                    <p>
                        AbrasivesWorld.com endeavors to improve user’s experience and functionality that exceed the expectation of its members. We welcome any comments from our
                        members so that abrasivesWorld continues to stay relevant in today’s industry evolution.
                    </p>
                    <p>
                        Thank you and enjoy this world of abrasives – AbrasivesWorld.com
                    </p>

                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
</div>
