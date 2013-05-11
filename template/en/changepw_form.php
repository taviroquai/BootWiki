
<h1>Change Password</h1>

<form action="" method="post">
    <label>Password</label>
    <input name="password" type="password" />
    <label>Confirme Password</label>
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
    
    <button type="submit">Change</button>
</form>
<? BootWiki::clearMessage(); ?>