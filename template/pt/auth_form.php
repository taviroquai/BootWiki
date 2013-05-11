
<h1>Iniciar Sessão</h1>

<form action="" method="post">
    <label>Endereço de E-mail</label>
    <input name="username" type="text" value="" />
    <label>Palavra-passe</label>
    <input name="password" type="password" />

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

    <button type="submit">Iniciar Sessão</button>
</form>
<? BootWiki::clearMessage(); ?>