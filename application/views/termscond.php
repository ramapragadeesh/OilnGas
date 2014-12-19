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
<div id="main_container" class="main_container">
<div> 
<div class="header_text">
<span>
<small><strong><?php echo dp($info_holder,"Abrasive World Account Terms and Conditions");?></small></strong>
</span> 
</div> 
<div id="maincon">

<div style="margin-left:30px;padding-top:30px;margin-right:30px">

<?php if ($userlanguage == "en" || $userlanguage == "")
{

?>
<div>
<p>
    Date: 20 August 2013
</p>
<p>
    These terms and conditions apply to your browsing and use of the AbrasivesWorld website. By viewing or using our websites, you are agreeing to these Terms
    and Conditions whether as a guest or registered user. By viewing or using our sites you are indicating you accept these terms of use and that you agree to
    abide by them. From time to time we may change these Terms and Conditions, and will post revisions on this website. We recommend that you read these Terms
    and Conditions prior to using our sites and thereafter regularly review any changes and you are responsible for doing so.
</p>
<p>
    <strong>Governing law and jurisdiction</strong>
</p>
<p>
    This website, any information contained on it, and these terms and conditions of use will be governed by, and interpreted in accordance with, Singapore
    law. The Singapore courts have exclusive jurisdiction to hear any disputes concerning matters involving this website.
    <br/>
    <br/>
</p>
<p>
    <strong>Access to AbrasivesWorld website</strong>
</p>
<p>
    We try to ensure that website availability is uninterrupted and that transmissions will be error-free. However, we cannot, guarantee that your access will
    not be suspended or restricted from time to time, including to allow for repairs, maintenance or the introduction of new facilities or services. We of
    course try to limit the frequency and duration of any suspension or restriction.
</p>
<p>
    <strong>Accounts and Passwords</strong>
</p>
<p>
    If you have registered or subscribed to a BMJ Group website, any user identification code or password must be kept confidential and used only by you
    (unless agreed in writing with AbrasivesWorld). We have the right to disable any user identification code or password whether chosen by you or allocated by
    us at any time if in our option you have failed to comply with any of the provisions of these terms of use or default of payment.
</p>
<p>
    <strong>Intellectual Property rights</strong>
</p>
<p>
    Unless otherwise stated, you may access, view, copy, print or temporarily store textual material published by AbrasivesWorld on this website for your
    personal use only and, when printing or storing material, in limited quantities. Any copyright notice on that material must be retained on the copy. You
    may not reproduce, adapt, distribute or incorporate anything from this website in any other work (in whole or in part), including republishing it for any
    commercial or other purpose, without AbrasivesWorld’s express written consent.
</p>
<p>
    The copyright in all materials (including rights in text, graphics, arrangement and overall design of this website) displayed or available on this website
    either belongs to AbrasivesWorld or is used by AbrasivesWorld with permission.
    <br/>
    <br/>
</p>
<p>
    Some material on this website, including trademarks and logos, is the intellectual property of third parties. By making these material, including
    trademarks and logos available to AbrasivesWorld, and it’s readers, it is deem that the third parties have consent the use of their intellectual property
    on the site. Your rights in relation to that material are as defined by the copyright owner of the material.
    <br/>
    <br/>
</p>
<p>
    While AbrasivesWorld has endeavoured to ensure that the information on this website is accurate, current and complete, it does not accept liability for any
    error, misstatement or omission. AbrasivesWorld may change the material on this website at any time without notice. In the unlikely event that an
    unauthorised person makes changes to this website, AbrasivesWorld does not accept responsibility for those changes. Errors are subject to correction.
</p>
<p>
    You are solely responsible for any actions you take in reliance on the content on this website.
    <br/>
    <br/>
</p>
<p>
    Any material you upload to our sites will be considered non-confidential and non-proprietary and for such content you grant us a transferable, royalty
    free, worldwide, irrevocable licence to use, copy, distribute, edit, amend, disclose, sub licence to third parties and create derivative works in whole or
    party of any such material for any purpose, in any media. We may remove, edit or amend any such material at any time without notice to you.
</p>
<p>
    We also have the right to disclose your identity to any third party who is claiming that any material posted or uploaded by you to any of our sites
    constitutes a violation of their rights, including without limitation, their intellectual property rights, reputational rights or of their right to
    privacy.
</p>
<p>
    If any article or comments are made available on the public noticeboard, either on this website or any website linked to this website, AbrasivesWorld does
    not make any representations about, nor endorses nor accepts any responsibility for, the content or views of those comments.
</p>
<p>
    You may not make any comment or post any article which is illegal, abusive, indecent, harmful, defamatory, obscene, offensive, abusive, threatheningm
    invasive of privacy, in breach of confidence infringes any intellectual property rights or objectionable. AbrasivesWorld may, at any time and for any
    reason, remove any comment or article provided by you that has been posted on the website. Under such circumstances, AbrasivesWorld will not make any
    refund to the paid services offered by AbrasivesWorld.
</p>
<p>
    <strong>Links</strong>
</p>
<p>
    This website may contain links to third party websites. AbrasivesWorld has no control over the content of such websites and does not make any
    representations about, nor endorses, such websites. The links are provided for convenience and informational purposes only. AbrasivesWorld is not
    responsible for the content, validity, accuracy, or the use, of any other website. You should check the terms and conditions applicable to any other
    websites you use.
    <br/>
    <br/>
    You may not create a link from any other website to any part of this website, without AbrasivesWorld's express written consent.
    <br/>
    <br/>
</p>
<p>
    <strong>Translation</strong>
</p>
<p>
    AbrasivesWorld uses third party translation engines for translation of articles posted by you to be made available in other languages offer by
    AbrasivesWorld . AbrasivesWorld shall not be liable to the accuracy and meaning of its translated content.
</p>
<p>
    <strong>Language</strong>
</p>
<p>
    English shall be the official and legally bidding language in this Terms and Condition
</p>
<p>
    <strong>Liability</strong>
</p>
<p>
    <br/>
    Your use of this website is at your own risk. AbrasivesWorld shall not be responsible or liable, in contract, tort (including negligence), equity or
    otherwise for any direct, indirect, incidental, consequential, special, or punitive damage, or for any loss of profit, income or savings, or any costs or
    expenses incurred or suffered by you or any other person, arising out of, or in connection with, your access to, or use of, this website or any linked
    websites.
    <br/>
    <br/>
</p>
<p>
    It is up to you to take precautions to ensure that whatever information you select for your use is free of items such as viruses, worms, trojan horses or
    other items of a destructive nature.
    <br/>
    <br/>
</p>
</div>
<?php 
}
else
{

?>
<div>
<p>
    日期：2013年8月20日
</p>
<p>
    <a name="OLE_LINK2"></a>
    <a name="OLE_LINK1">本条款和条件适用于您在浏览和使用</a>
    AbrasivesWorld网站时, 无论是以游客或是注册用户身份，当您在查看或使用本网站的同时，您已经同意了本条款和条件，并接受且遵守其使用说明。我们会不时地改变这些条款和条件，并将修订后的版本告示于本网站。我们建议并认为您有义务在使用我们的网站前务必先阅读条款和条件，并定期审查任何条款变化。
</p>
<p>
    <a name="OLE_LINK3"> </a>
</p>
<p>
    <strong>管辖法律与司法管辖</strong>
    <strong>
        <br/>
    </strong>
    本网站所含任何信息及使用条款及条件将适用并依照于新加坡的法律解释。任何有关争议事项涉及本网站专属管辖权时，新加坡法院将有唯一司法管辖权。
</p>
<p>
    <strong>访问</strong>
    <strong>AbrasivesWorld</strong>
    <strong>网站</strong>
    <strong>
        <br/>
    </strong>
    我们将尽力确保您可以不间断的访问我们的网站，做到无错误的信息传输。然而，我们不能保证您的访问有时将不被中止或被限制，情况包括新设备和服务的维护和引进。我们将务必降低以上中断或被限制的情况发生的次数及持续的时间。
</p>
<p>
    <strong>账户和密码</strong>
    <strong>
        <br/>
    </strong>
    如果您已经注册或订阅BMJ集团的网站，任何用户识别码或密码必须保持机密并且只供您一人使用（除非以书面形式取得AbrasivesWorld的同意）。若您未能遵守任何这些使用条款的规定或不履行付款义务，我们将有权取消任何的用户识别码或密码，不论是您自己选择或是我们分配的。
</p>
<p>
    <a name="OLE_LINK9"></a>
    <a name="OLE_LINK8"></a>
</p>
<p>
    <strong>知识产权</strong>
    <strong>
        <br/>
    </strong>
    除非特别注明，您可以访问，查看，打印、复印或临时存储AbrasivesWorld网站发表的文本材料，但只可供您个人使用并仅限于一定的材料数量。对材料的任何版权声明必须保留在副本。未经AbrasivesWorld书面同意，您无法复制，改编，分发或在其他作品（全部或部分）中包含源于本网站的材料，情况包括重新发表本网站材料，以作为任何商业或其他用途。
</p>
<p>
    <br/>
    所有本网站展示或可用材料的版权（包括文本，图形，布局和本网站的整体设计）属于AbrasivesWorld所有或AbrasivesWorld已获得使用准许。
    <br/>
    <br/>
</p>
<p>
    所有在本网站上使用的商标和标识均属于第三方知识产权，受知识产权法律保护。在本网站所上载的任何商标和标识均被看作已取得第三方的知识产权使用许可，可在本网站使用。您对该资料的权利由版权所有者界定。
</p>
<p>
    AbrasivesWorld会尽力保证本网站所含信息的准确性、时效性和完整性，在任何情况下，我们概不就任何用户在本网站张贴的错误，误述或对其內容的遗失负责。AbrasivesWorld可能在不事先通知您的情况下随后修改网站内容。对未授权方在本网站上所做出的任何修改提交，我们不承担任何的责任或法律后果，并且提交的內容并不一定代表或反映我们的观点或意见。错误有待更正。
</p>
<p>
    <br/>
    您将全权负责您对本网站的内容所作的任何行动。
    <br/>
    <br/>
    <a name="OLE_LINK11"></a>
    <a name="OLE_LINK10"></a>
</p>
<p>
    <a name="OLE_LINK22"></a>
    <a name="OLE_LINK21">任何您上传到我们的网站的材料将被视为非机密和非专有的。对这些内容您授权我方可转让权，</a>
    免版税，全球性的、不可撤销的使用许可，<a name="OLE_LINK24"></a><a name="OLE_LINK23">包括向第三方（们）分发，复制，修改，编辑，披露、提供子执照、在任何媒体上自由创建出部分或全部的派生作品。我们可能在不事先通知您的情况下，删除、编辑或修改任何此类材料</a>。
    <br/>
    <br/>
</p>
<p>
    我们有权利向任何指控你侵权的第三方提供您的身份，此侵权范围包括但不限于您上传的资料损害了第三方的知识产权，名誉权和隐私权。
    <br/>
    <br/>
    在本网站或本网站链接的网站的公共区域内的任何文章或评论，AbrasiveWorld不对其观点和内容负责。
    <br/>
    <br/>
    您不可以进行非法的，不雅的评论，这包括但不仅限于诽谤和冒犯他人，提供淫秽内容，滥用材料，侵犯隐私和侵犯知识产权。AbrasivesWorld有权利在任何时间无理由的删除任何评论或文章。在这种情况下，AbrasivesWorld不会因此有任何退款服务。
</p>
<p>
    <strong>链接</strong>
    <strong></strong>
</p>
<p>
    本网站可能包含第三方链接。这些网站的内容和观点都与AbrasivesWorld无关。第三方链接仅以提供便利和信息为目的。AbrasivesWorld不对其内容，合理性，准确性和在其他任何网站的用途负责。请务必查看其他网站的使用条款和条件。
</p>
<p>
    在没有AbrasivesWorld书面允许的情况下，您不能创建链接从其他网站链接到AbrasivesWorld网站。
</p>
<p>
    <strong>翻译</strong>
    <strong></strong>
</p>
<p>
    AbrasivesWorld使用了其他翻译引擎来多语言翻译您所提供的文章。AbrasivesWorld不能保证其翻译内容的准确性和合理性。
</p>
<p>
    <strong>语言</strong>
    <strong></strong>
</p>
<p>
    此使用条件说明法律上以英文版本为准。
</p>
<p>
    <strong>责任声明</strong>
    <strong></strong>
</p>
<p>
    <a name="OLE_LINK16"></a>
    <a name="OLE_LINK15">如果您使用了本网站，那么您将自己承担该行为的所有风险，</a>
    AbrasivesWorld对任何由于接入或使用本网站，或其中包含的任何信息而导致的任何直接、间接、特殊、惩罚性、惩戒性或后果性的损失或损害不承担任何责任，包括利润损失，无论是基于合同违约、侵权（包括过失）、产品责任还是相反情况。
</p>
<p>
    您须为您提交的所有內容完全负责并保证您的提交不以任何方式含有病毒、木马程式、蠕虫、损坏的档案，任何其他恶意软件或其他可能对他人电脑造成损害的材料。
</p>
</div>
<?php
}
?>
</div>
</div>
</div>
</div>