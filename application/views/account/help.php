<?php
function userLocaleConversion(& $info_holderdy,$f) {
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
?>

<div class="container">
    <h1 style="font-weight:100;padding-bottom:15px;padding-top:10px"><?php echo userLocaleConversion($memberLanguageInfo,"Help");?></h1>
    <hr>
    <div class="row" style="text-align:center">
    <h3 style="font-weight:100;padding-bottom:5px;padding-top:10px">
    <a href="<?php echo base_url();?>tinymce/plugins/moxiemanager/data/files/support%40abrasivesworld.com/guide/Article%20management%20system%20vol%20%201.pdf">
    <?php echo userLocaleConversion($memberLanguageInfo,"Article Management Guide");?>
    </a>
    </h3>
    </div>
    <div class="row" style="text-align:center">
    <h3 style="font-weight:100;padding-bottom:5px;padding-top:5px">
        <a href="<?php echo base_url();?>tinymce/plugins/moxiemanager/data/files/support%40abrasivesworld.com/guide/Request%20for%20Quotation%20vol%20%201.pdf">
    <?php echo userLocaleConversion($memberLanguageInfo,"RFQ Management Guide");?>
    </a>
    </h3>
    </div>
</div>