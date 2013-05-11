
<h1>Register</h1>

<form action="" method="post">
    <label>Email</label>
    <input name="username" required type="text" placeholder="Email"
           value="<?=empty($_POST['username']) ? '' : $_POST['username']?>" />
    <label>Display Name</label>
    <input name="displayname" required type="text" placeholder="Display name"
           value="<?=empty($_POST['displayname']) ? '' : $_POST['displayname']?>" />
    
    <label>Social profile link</label>
    <input name="profile" type="text" placeholder="Social profile link"
           value="<?=empty($_POST['profile']) ? '' : $_POST['profile']?>" />
    
    <label>Password</label>
    <input name="password" type="password" required placeholder="Password" />
    <label>Confirme Password</label>
    <input name="password_confirm" type="password" required placeholder="Confirm password" />

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
    <button type="submit">Register</button>
</form>
<? BootWiki::clearMessage(); ?>