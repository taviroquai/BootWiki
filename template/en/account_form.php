
<h1>My Account</h1>

<?php if (BootWiki::hasMessage()) : ?>
<div class="control-group error" id="login_error">
    <div class="controls">
        <span class="help-inline"><?=BootWiki::getMessage()?></span>
    </div>
</div>
<?php endif; ?>

<h2>Change Account</h2>

<form action="" method="post">
    <label>Username</label>
    <input name="username" type="text" disabled="disabled" value="<?=$this->account->username?>" />
    <label>Display Name</label>
    <input name="displayname" type="text" value="<?=$this->account->displayname?>" />
    <label>Profile (author link)</label>
    <input name="profile" type="text" value="<?=$this->account->profile?>" />

    <label></label>
    <button type="submit">Save</button>
</form>

<h2>Change Password</h2>

<form action="" method="post">
    <label>Password</label>
    <input name="password" type="password" />
    <label>Confirme Password</label>
    <input name="password_confirm" type="password" />

    <label></label>
    <button type="submit">Change</button>
</form>
<?php BootWiki::clearMessage(); ?>