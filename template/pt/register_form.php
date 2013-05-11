
<h1>Registar</h1>

<form action="" method="post">
    <label>E-mail</label>
    <input name="username" type="text" value="" placeholder="E-mail" 
           value="<?=empty($_POST['username']) ? '' : $_POST['username']?>" />
    <label>Nome Público</label>
    <input name="displayname" type="text" placeholder="Nome Público"
           value="<?=empty($_POST['displayname']) ? '' : $_POST['displayname']?>" />
    
    <label>Link do perfil social</label>
    <input name="profile" type="text" placeholder="Link do perfil social"
           value="<?=empty($_POST['profile']) ? '' : $_POST['profile']?>" />
    
    <label>Palavra-passe</label>
    <input name="password" type="password" placeholder="Palavra-passe" />
    <label>Confirmar Palavra-passe</label>
    <input name="password_confirm" type="password" placeholder="Confirmar palavra-passe" />

    <label></label>

    <? if (BootWiki::hasMessage()) : ?>
    <div class="control-group error" id="login_error">
      <div class="controls">
          <span class="help-inline"><?=BootWiki::getMessage()?></span>
      </div>
    </div>
    <script>
        jQuery(function($) {
            for(i=0;i<3;i++) {
                $('#login_error').fadeTo('fast', 0).fadeTo('fast', 1);
            }
        });
    </script>
    <? endif; ?>

    <input type="text" name="reserved" style="display: none" />
    <button type="submit">Registar</button>
</form>
<? BootWiki::clearMessage(); ?>