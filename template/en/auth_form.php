
<h1>Login</h1>

<form action="" method="post">
    <div class="form-group">
        <label>Email</label>
        <input name="username" type="text" value="" class="form-control" />
    </div>
    <div class="form-group">
        <label>Password</label>
        <input name="password" type="password" class="form-control" />
    </div>

    <label></label>

    <?php if (BootWiki::hasMessage()) : ?>
    <div class="bg-danger" id="login_error"><?=BootWiki::getMessage()?></div>
    <script>
        jQuery(function($) {
            for(i=0;i<3;i++) {
                $('#login_error').fadeTo('fast', 0).fadeTo('fast', 1);
            }
        });
    </script>
    <?php endif; ?>

    <button class="btn btn-primary" type="submit">Login</button>
</form>
<?php BootWiki::clearMessage(); ?>