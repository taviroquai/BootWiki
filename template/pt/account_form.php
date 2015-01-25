
<h1>A Minha Conta de Utilizador</h1>

<?php if (BootWiki::hasMessage()) : ?>
<div class="bg-danger" id="login_error"><?=BootWiki::getMessage()?></div>
<?php endif; ?>

<h2>Alterar Dados</h2>

<form action="" method="post">
    <div class="form-group">
        <label>Nome de Utilizador</label>
        <input name="username" type="text" disabled="disabled" 
            class="form-control"
            value="<?=$this->account->username?>" />
    </div>
    <div class="form-group">
        <label>Nome Público</label>
        <input name="displayname" type="text" 
            class="form-control"
            value="<?=$this->account->displayname?>" />
    </div>
    <div class="form-group">
        <label>Link de Perfil (author link)</label>
        <input name="profile" type="text" 
            class="form-control"
            value="<?=$this->account->profile?>" />
    </div>
    <button class="btn btn-primary" type="submit">Salvar</button>
</form>

<h2>Alterar Palavra-passe</h2>

<form action="" method="post">
    <div class="form-group">
        <label>Palavra-passe</label>
        <input name="password" type="password" 
            class="form-control"
            value="" />
    </div>
    <div class="form-group">
        <label>Confirmar Palavra-passe</label>
        <input name="password_confirm" type="password" 
            class="form-control"
            value="" />
    </div>
    <button class="btn btn-primary" type="submit">Alterar</button>
</form>
<?php BootWiki::clearMessage(); ?>