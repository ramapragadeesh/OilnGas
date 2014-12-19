<form class="form-horizontal" action="<?php echo base_url();?>admin/save_banner" method="POST" enctype="multipart/form-data">
<fieldset>

<!-- Form Name -->
<legend>Banner Creation</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="bannerTitle">Banner Title</label>
  <div class="controls">
    <input id="bannerTitle" name="bannerTitle" type="text" placeholder="Banner Title" class="input-xlarge" required="">
    <p class="help-block">Enter Banner Title</p>
  </div>
</div>

<!-- Textarea -->
<div class="control-group">
  <label class="control-label" for="bannerDesc">Banner Description</label>
  <div class="controls">
    <textarea id="bannerDesc" name="bannerDesc">Enter Banner Description</textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="bannerPosition">Banner Position</label>
  <div class="controls">
    <select id="bannerPosition" name="bannerPosition" class="input-xlarge">
      <option value="left">Left</option>
      <option value="right">Right</option>
    </select>
  </div>
</div>

<!-- File Button -->
<div class="control-group">
  <label class="control-label" for="bannerPicture">Banner Picture</label>
  <div class="controls">
    <input id="bannerPicture" name="bannerPicture1" class="input-file" type="file" >
  </div>
</div>


<!-- File Button -->
<div class="control-group">
  <label class="control-label" for="bannerPicture">Banner Picture</label>
  <div class="controls">
    <input id="bannerPicture" name="bannerPicture2" class="input-file" type="file" >
  </div>
</div>


<!-- File Button -->
<div class="control-group">
  <label class="control-label" for="bannerPicture">Banner Picture</label>
  <div class="controls">
    <input id="bannerPicture" name="bannerPicture3" class="input-file" type="file" >
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="bannerPictureLink">Insert a link for above picture</label>
  <div class="controls">
    <input id="bannerPictureLink" name="bannerPictureLink1" type="text" placeholder="Enter a link" class="input-xlarge">
    <p class="help-block">Enter a Link(starts with http or https)</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="bannerPictureLink">Insert a link for above picture</label>
  <div class="controls">
    <input id="bannerPictureLink" name="bannerPictureLink2" type="text" placeholder="Enter a link" class="input-xlarge">
    <p class="help-block">Enter a Link(starts with http or https)</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="bannerPictureLink">Insert a link for above picture</label>
  <div class="controls">
    <input id="bannerPictureLink" name="bannerPictureLink3" type="text" placeholder="Enter a link" class="input-xlarge">
    <p class="help-block">Enter a Link(starts with http or https)</p>
  </div>
</div>


<!-- Multiple Checkboxes -->
<div class="control-group">
  <label class="control-label" for="activeBanner"></label>
  <div class="controls">
    <label class="checkbox" for="activeBanner-0">
      <input type="checkbox" name="activeBanner" id="activeBanner-0" value="Activate">
      Activate
    </label>
  </div>
</div>

<!-- Button -->
<div class="control-group">
  <label class="control-label" for="save"></label>
  <div class="controls">
    <button id="save" name="save" class="btn btn-primary">Save</button>
  </div>
</div>

</fieldset>
</form>

<div style="text-align:center">
<?php
if (isset($error)) {
  echo $error;
}
?>
</div>

