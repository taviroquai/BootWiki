
<h1>Registar</h1>

<form action="" method="post">
    <div class="form-group">
        <label>E-mail</label>
        <input name="username" required type="text" placeholder="Email"
                class="form-control"
                value="<?=empty($_POST['username']) ? '' : $_POST['username']?>" />
    </div>
    <div class="form-group">
        <label>Nome Público</label>
        <input name="displayname" required type="text" placeholder="Display name"
                class="form-control"
                value="<?=empty($_POST['displayname']) ? '' : $_POST['displayname']?>" />
    </div>
    <div class="form-group">
        <label>Endereço de Perfil</label>
        <input name="profile" type="text" placeholder="Social profile link"
                class="form-control"
                value="<?=empty($_POST['profile']) ? '' : $_POST['profile']?>" />
    </div>
    <div class="form-group">
        <label>Palavra-passe</label>
        <input name="password" type="password" required placeholder="Password" class="form-control" />
    </div>
    <div class="form-group">
        <label>Confirmar Palavra-passe</label>
        <input name="password_confirm" type="password" required placeholder="Confirm password" class="form-control" />
    </div>

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

    <input type="text" name="reserved" style="display: none" />
    <button class="btn btn-primary" type="submit">Registar</button>
</form>
<?php BootWiki::clearMessage(); ?>