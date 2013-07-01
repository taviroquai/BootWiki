
<h1>A Minha Conta</h1>

<? if (BootWiki::hasMessage()) : ?>
<div class="control-group error" id="login_error">
    <div class="controls">
        <span class="help-inline"><?=BootWiki::getMessage()?></span>
    </div>
</div>
<? endif; ?>

<h2>Alterar Conta</h2>

<form action="" method="post">
    <label>Nome de Utilizador (username)</label>
    <input name="username" type="text" disabled="disabled" value="<?=$this->account->username?>" />
    <label>Nome Completo</label>
    <input name="displayname" type="text" value="<?=$this->account->displayname?>" />
    <label>Link de Perfil de Autoria</label>
    <input name="profile" type="text" value="<?=$this->account->profile?>" />

    <label></label>
    <button type="submit">Guardar</button>
</form>

<h2>Alterar Palavra-passe</h2>

<form action="" method="post">
    <label>Palavra-passe</label>
    <input name="password" type="password" />
    <label>Confirmar Palavra-passe</label>
    <input name="password_confirm" type="password" />

    <label></label>
    <button type="submit">Alterar</button>
</form>
<? BootWiki::clearMessage(); ?>