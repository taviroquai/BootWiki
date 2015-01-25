<h1>Editar...</h1>
<form action="<?=BASEURL.'/edit/'.$this->content->alias?>" method="post" enctype="multipart/form-data" id="editPost">
    
    <div class="form-group pull-right">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <button type="button" class="btn" 
                onclick="window.location = '<?=BASEURL.'/'.$this->content->alias?>'">Cancelar</button>
    </div>
    <div class="clearfix"></div>
    
    <div class="row-fluid">
        <div class="col-sx-12 col-md-6">
            
            <div class="form-group">
                <label>Título</label>
                <input name="content[title]" type="text" value="<?=$this->content->title?>" class="form-control" />
            </div>
            <div class="form-group">
                <label>URL</label>
                <input name="content[alias]" type="text" value="<?=$this->content->alias?>" class="form-control" />
            </div>

            <div class="form-group">
                <label>Idioma</label>
                <?php foreach ($this->idioms as $item) { ?>
                <label class="radio-inline">
                    <input type="radio" name="content[idiom]" value="<?=$item->code?>"<?=$this->content->idiom->code == $item->code ? 'checked' : ''?>>
                    <?=$item->html()?>
                </label>
                <?php } ?>
            </div>

            <div class="form-group">
                <label>Publicado</label>
                <label class="radio-inline">
                    <input type="radio" name="content[publish]" id="optionsRadios1" value="1"<?=$this->content->publish ? 'checked' : ''?>>
                    Sim
                </label>
                <label class="radio-inline">
                    <input type="radio" name="content[publish]" id="optionsRadios2" value="0"<?=$this->content->publish ? '' : 'checked'?>>
                    Não
                </label>
            </div>
            
            <div class="form-group">
                <label>Destaque</label>
                <label class="radio-inline">
                    <input type="radio" name="content[featured]" value="1"<?=$this->content->featured ? 'checked' : ''?>>
                    Sim
                </label>
                <label class="radio-inline">
                    <input type="radio" name="content[featured]" value="0"<?=$this->content->featured ? '' : 'checked'?>>
                    Não
                </label>
            </div>

            <div class="form-group">
                <label>Data</label>
                <input name="content[date]" type="text" value="<?=$this->content->date?>" class="form-control" />
            </div>
            <div class="form-group">
                <label>Visitas</label>
                <input name="content[visits]" type="text" value="<?=$this->content->visits?>" class="form-control" />
            </div>
            <div class="form-group">
                <label>Descrição</label>
                <textarea name="content[description]" class="form-control" rows="3"><?=$this->content->description?></textarea>
            </div>
            <div class="form-group">
                <label>Palavras-chave</label>
                <input name="content[keywords]" type="text" value="<?=$this->content->keywords?>" class="form-control" />
            </div>
            <div class="form-group">
                <label>Autor</label>
                <input name="content[author]" type="text" value="<?=$this->content->author?>" class="form-control" />
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label>Imagem</label>
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-new thumbnail">
                    <?php if (!empty($this->content->image)) : ?>
                        <img src="<?=$this->content->image?>" alt="<?=$this->content->title?>" />
                    <?php else : ?>
                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" />
                    <?php endif; ?>
                    </div>
                    <div class="fileupload-preview fileupload-exists thumbnail"></div>
                    <div>
                      <span class="btn btn-file">
                          <span class="btn btn-default fileupload-new">Escolher</span>
                          <span class="btn btn-default fileupload-exists">Alterar</span>
                          <input type="file" name="upload_image" />
                      </span>
                      <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remover</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="col-sx-12 col-md-12">

            <div id="alerts"></div>

            <div class="form-group">
                <label>Introdução</label>
                <input type="hidden" name="content[intro]" value="<?=htmlentities($this->content->intro)?>" />
                <div class="btn-toolbar" data-role="editor1-toolbar" data-target="#editor1">
                  <div class="btn-group">
                    <a class="btn btn-default btn-xs" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="glyphicon glyphicon-bold"></i></a>
                    <a class="btn btn-default btn-xs" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="glyphicon glyphicon-italic"></i></a>
                    <!--<a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
                    <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>-->
                  </div>
                  <div class="btn-group">
                    <a class="btn btn-default btn-xs" data-edit="insertunorderedlist" title="Bullet list"><i class="glyphicon glyphicon-align-justify"></i></a>
                    <a class="btn btn-default btn-xs" data-edit="insertorderedlist" title="Number list"><i class="glyphicon glyphicon-list"></i></a>
                    <a class="btn btn-default btn-xs" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="glyphicon glyphicon-indent-right"></i></a>
                    <a class="btn btn-default btn-xs" data-edit="indent" title="Indent (Tab)"><i class="glyphicon glyphicon-indent-left"></i></a>
                  </div>
                  <div class="btn-group">
                    <a class="btn btn-default btn-xs" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="glyphicon glyphicon-align-left"></i></a>
                    <a class="btn btn-default btn-xs" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="glyphicon glyphicon-align-center"></i></a>
                    <a class="btn btn-default btn-xs" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="glyphicon glyphicon-align-right"></i></a>
                    <a class="btn btn-default btn-xs" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="glyphicon glyphicon-align-justify"></i></a>
                  </div>
                  <div class="btn-group">
                      <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="glyphicon glyphicon-link"></i></a>
                        <div class="dropdown-menu">
                            <div class="input-group">
                                <input class="form-control input-sm" placeholder="URL" type="text" data-edit="createLink"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-default btn-sm" type="button">Salvar</button>
                                </span>
                            </div>
                        </div>
                    <a class="btn btn-default btn-xs" data-edit="unlink" title="Remove Hyperlink"><i class="glyphicon glyphicon-remove"></i></a>

                  </div>
                  <div class="btn-group">
                    <a class="btn btn-default btn-xs" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="glyphicon glyphicon-chevron-left"></i></a>
                    <a class="btn btn-default btn-xs" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="glyphicon glyphicon-chevron-right"></i></a>
                  </div>
                </div>
                <div id="editor1" style="overflow:scroll;height: 120px;border: 2px dashed gray; padding: 10px;"><?=$this->content->intro?></div>
            </div>

            <div class="form-group">
                
                <label>Corpo do Texto</label>
                <input type="hidden" name="content[html]" value="<?=htmlentities($this->content->html)?>" />
                <div class="btn-toolbar" data-role="editor2-toolbar" data-target="#editor2">
                  <div class="btn-group">
                    <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" title="Font"><i class="glyphicon glyphicon-font"></i><b class="caret"></b></a>
                      <ul class="dropdown-menu">
                      </ul>
                    </div>
                  <div class="btn-group">
                    <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="glyphicon glyphicon-text-height"></i>&nbsp;<b class="caret"></b></a>
                      <ul class="dropdown-menu">
                      <li><a data-edit="fontSize 5"><font size="5">Enorme</font></a></li>
                      <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
                      <li><a data-edit="fontSize 1"><font size="1">Pequeno</font></a></li>
                      </ul>
                  </div>
                  <div class="btn-group">
                    <a class="btn btn-default btn-xs" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="glyphicon glyphicon-bold"></i></a>
                    <a class="btn btn-default btn-xs" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="glyphicon glyphicon-italic"></i></a>
                    <!--<a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
                    <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>-->
                  </div>
                  <div class="btn-group">
                    <a class="btn btn-default btn-xs" data-edit="insertunorderedlist" title="Bullet list"><i class="glyphicon glyphicon-align-justify"></i></a>
                    <a class="btn btn-default btn-xs" data-edit="insertorderedlist" title="Number list"><i class="glyphicon glyphicon-list"></i></a>
                    <a class="btn btn-default btn-xs" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="glyphicon glyphicon-indent-right"></i></a>
                    <a class="btn btn-default btn-xs" data-edit="indent" title="Indent (Tab)"><i class="glyphicon glyphicon-indent-left"></i></a>
                  </div>
                  <div class="btn-group">
                    <a class="btn btn-default btn-xs" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="glyphicon glyphicon-align-left"></i></a>
                    <a class="btn btn-default btn-xs" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="glyphicon glyphicon-align-center"></i></a>
                    <a class="btn btn-default btn-xs" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="glyphicon glyphicon-align-right"></i></a>
                    <a class="btn btn-default btn-xs" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="glyphicon glyphicon-align-justify"></i></a>
                  </div>
                  <div class="btn-group">
                      <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="glyphicon glyphicon-link"></i></a>
                        <div class="dropdown-menu">
                            <div class="input-group">
                                <input class="form-control input-sm" placeholder="URL" type="text" data-edit="createLink"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-default btn-sm" type="button">Salvar</button>
                                </span>
                            </div>
                        </div>
                    <a class="btn btn-default btn-xs" data-edit="unlink" title="Remove Hyperlink"><i class="glyphicon glyphicon-remove"></i></a>

                  </div>
                  
                  <div class="btn-group">
                    <a class="btn btn-default btn-xs" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="glyphicon glyphicon-picture"></i></a>
                    <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                  </div>
                  <div class="btn-group">
                    <a class="btn btn-default btn-xs" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="glyphicon glyphicon-chevron-left"></i></a>
                    <a class="btn btn-default btn-xs" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="glyphicon glyphicon-chevron-right"></i></a>
                  </div>
                </div>
                <div id="editor2" style="overflow:scroll;height: 300px;border: 2px dashed gray; padding: 10px;"><?=$this->content->html?></div>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-default" 
                        onclick="window.location = '<?=BASEURL.'/'.$this->content->alias?>'">Cancelar</button>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript" src ="web/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
<script type="text/javascript" src ="web/js/jquery.hotkeys.js"></script>
<script type="text/javascript" src ="web/js/bootstrap-wysiwyg.js"></script>
<script>
  jQuery(function($) {

    $('.fileupload').fileupload();

    function initToolbarBootstrapBindings() {
      var fonts = ['Serif', 'Sans', 'Arial', 'Comic Sans MS', 'Helvetica', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
      $.each(fonts, function (idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
      });
      $('a[title]').tooltip({container:'body'});
        $('.dropdown-menu input').click(function() {return false;})
            .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
        .keydown('esc', function () {this.value='';$(this).change();});

      $('[data-role=magic-overlay]').each(function () { 
        var overlay = $(this), target = $(overlay.data('target')); 
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
      });
    };
    function showErrorAlert (reason, detail) {
        var msg='';
        if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
        else {
            console.log("error uploading file", reason, detail);
        }
        $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
         '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
    };
    initToolbarBootstrapBindings();  
    $('#editor1').wysiwyg({ fileUploadError: showErrorAlert, toolbarSelector: '[data-role=editor1-toolbar]'} );
    $('#editor2').wysiwyg({ fileUploadError: showErrorAlert, toolbarSelector: '[data-role=editor2-toolbar]'} );
    
    $('#editPost').submit(function(e) {
        $('[name="content[intro]"]').val($('#editor1').cleanHtml());
        $('[name="content[html]"]').val($('#editor2').cleanHtml());
        return true;
    });
  });
</script>