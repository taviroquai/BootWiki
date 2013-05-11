
<h1>Registar</h1>

<form action="" method="post">
    <label>E-mail</label>
    <input name="username" type="text" value="" />
    <label>Nome Público</label>
    <input name="displayname" type="text" value="<?=empty($_POST['displayname']) ? '' : $_POST['displayname']?>" />
    
    <label>Palavra-passe</label>
    <input name="password" type="password" />
    <label>Confirmar Palavra-passe</label>
    <input name="password_confirm" type="password" />

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

    <button type="submit">Registar</button>
</form>
<? BootWiki::clearMessage(); ?>