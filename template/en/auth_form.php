
<h1>Login</h1>

<form action="" method="post">
    <label>Email</label>
    <input name="username" type="text" value="" />
    <label>Password</label>
    <input name="password" type="password" />

    <label></label>

    <?php if (BootWiki::hasMessage()) : ?>
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
    <?php endif; ?>

    <button type="submit">Login</button>
</form>
<?php BootWiki::clearMessage(); ?>