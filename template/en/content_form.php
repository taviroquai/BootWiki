<h1>Editing...</h1>
<form action="<?=BASEURL.'/edit/'.$this->content->alias?>" method="post" enctype="multipart/form-data">
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn" 
                onclick="window.location = '<?=BASEURL.'/'.$this->content->alias?>'">Cancel</button>
    </div>
    
    <div class="row-fluid">
        <div class="span6">
            
            <label>Title</label>
            <input name="content[title]" type="text" value="<?=$this->content->title?>" class="span12" />
            <label>Alias</label>
            <input name="content[alias]" type="text" value="<?=$this->content->alias?>" class="span12" />

            <div class="control-group">
                <label class="control-label">Idiom</label>
                <?php foreach ($this->idioms as $item) { ?>
                <label class="radio inline">
                    <input type="radio" name="content[idiom]" value="<?=$item->code?>"<?=$this->content->idiom->code == $item->code ? 'checked' : ''?>>
                    <?=$item->html()?>
                </label>
                <?php } ?>
            </div>

            <div class="control-group">
                <label class="control-label">Publish</label>
                <label class="radio inline">
                    <input type="radio" name="content[publish]" id="optionsRadios1" value="1"<?=$this->content->publish ? 'checked' : ''?>>
                    Yes
                </label>
                <label class="radio inline">
                    <input type="radio" name="content[publish]" id="optionsRadios2" value="0"<?=$this->content->publish ? '' : 'checked'?>>
                    No
                </label>
            </div>
            
            <div class="control-group">
                <label class="control-label">Featured</label>
                <label class="radio inline">
                    <input type="radio" name="content[featured]" value="1"<?=$this->content->featured ? 'checked' : ''?>>
                    Yes
                </label>
                <label class="radio inline">
                    <input type="radio" name="content[featured]" value="0"<?=$this->content->featured ? '' : 'checked'?>>
                    No
                </label>
            </div>

            <label>Date</label>
            <input name="content[date]" type="text" value="<?=$this->content->date?>" />
            <label>Visits</label>
            <input name="content[visits]" type="text" value="<?=$this->content->visits?>" />
            <label>Description</label>
            <textarea name="content[description]" class="span12"><?=$this->content->description?></textarea>
            <label>Keywords</label>
            <input name="content[keywords]" type="text" value="<?=$this->content->keywords?>" class="span12" />
            <label>Author</label>
            <input name="content[author]" type="text" value="<?=$this->content->author?>" />
            
            <label>Introduction</label>
            <textarea id="wysiwyg1" name="content[intro]" class="span12" rows="8"><?=$this->content->intro?></textarea>

        </div>
        <div class="span6">
            
            
            <label>Body</label>
            <textarea id="wysiwyg2" name="content[html]" class="span12" rows="20"><?=$this->content->html?></textarea>

            <label>Image</label>
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail span12">
                <?php if (!empty($this->content->image)) : ?>
                    <img src="<?=$this->content->image?>" alt="<?=$this->content->title?>" />
                <?php else : ?>
                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" />
                <?php endif; ?>
                </div>
                <div class="fileupload-preview fileupload-exists thumbnail span12"></div>
                <div>
                  <span class="btn btn-file">
                      <span class="fileupload-new">Select image</span>
                      <span class="fileupload-exists">Change</span>
                      <input type="file" name="upload_image" />
                  </span>
                  <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn" 
                onclick="window.location = '<?=BASEURL.'/'.$this->content->alias?>'">Cancel</button>
    </div>
</form>
<script type="text/javascript" src ="web/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
<script type="text/javascript" src ="web/js/wysihtml5-override.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        $('#wysiwyg1').wysihtml5(overrideOptions);
        $('#wysiwyg2').wysihtml5(overrideOptions);
        $('.fileupload').fileupload();
    });
</script>