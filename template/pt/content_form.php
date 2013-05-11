<h1>Edição...</h1>
<form action="" method="post" enctype="multipart/form-data">
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <button type="button" class="btn" 
                onclick="window.location = '<?=BASEURL.'/'.$this->alias?>'">Cancelar</button>
    </div>
    
    <div class="row-fluid">
        <div class="span6">
            
            <label>Título</label>
            <input name="content[title]" type="text" value="<?=$this->title?>" class="span12" />
            <label>Alias</label>
            <input name="content[alias]" type="text" value="<?=$this->alias?>" class="span12" />

            <div class="control-group">
                <label class="control-label">Idioma</label>
                <? foreach ($this->idioms as $item) { ?>
                <label class="radio inline">
                    <input type="radio" name="content[idiom]" value="<?=$item->code?>"<?=$this->idiom->code == $item->code ? 'checked' : ''?>>
                    <?=$item->html()?>
                </label>
                <? } ?>
            </div>

            <div class="control-group">
                <label class="control-label">Publicar</label>
                <label class="radio inline">
                    <input type="radio" name="content[publish]" id="optionsRadios1" value="1"<?=$this->publish ? 'checked' : ''?>>
                    Sim
                </label>
                <label class="radio inline">
                    <input type="radio" name="content[publish]" id="optionsRadios2" value="0"<?=$this->publish ? '' : 'checked'?>>
                    Não
                </label>
            </div>
            
            <div class="control-group">
                <label class="control-label">Destaque na Homepage</label>
                <label class="radio inline">
                    <input type="radio" name="content[featured]" value="1"<?=$this->featured ? 'checked' : ''?>>
                    Yes
                </label>
                <label class="radio inline">
                    <input type="radio" name="content[featured]" value="0"<?=$this->featured ? '' : 'checked'?>>
                    No
                </label>
            </div>

            <label>Data</label>
            <input name="content[date]" type="text" value="<?=$this->date?>" />
            <label>Descrição</label>
            <textarea name="content[description]" class="span12"><?=$this->description?></textarea>
            <label>Palavras-chave</label>
            <input name="content[keywords]" type="text" value="<?=$this->keywords?>" class="span12" />
            <label>Autor</label>
            <input name="content[author]" type="text" value="<?=$this->author?>" />
            
            <label>Introdução</label>
            <textarea id="wysiwyg1" name="content[intro]" class="span12" rows="8"><?=$this->intro?></textarea>

        </div>
        <div class="span6">
            
            
            <label>Corpo</label>
            <textarea id="wysiwyg2" name="content[html]" class="span12" rows="20"><?=$this->html?></textarea>

            <label>Imagem</label>
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail span12">
                <? if (!empty($this->image)) : ?>
                    <img src="<?=$this->image?>" alt="<?=$this->title?>" />
                <? else : ?>
                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" />
                <? endif; ?>
                </div>
                <div class="fileupload-preview fileupload-exists thumbnail span12"></div>
                <div>
                  <span class="btn btn-file">
                      <span class="fileupload-new">Escolher image</span>
                      <span class="fileupload-exists">Alterar</span>
                      <input type="file" name="upload_image" />
                  </span>
                  <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <button type="button" class="btn" 
                onclick="window.location = '<?=BASEURL.'/'.$this->alias?>'">Cancelar</button>
    </div>
</form>
<script type="text/javascript" src ="web/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        $('#wysiwyg1').wysihtml5();
        $('#wysiwyg2').wysihtml5();
        $('.fileupload').fileupload();
    });
</script>