
<h1>Alterar Palavra-passe</h1>

<form action="" method="post">
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
    
    <button type="submit">Alterar</button>
</form>
<? BootWiki::clearMessage(); ?>