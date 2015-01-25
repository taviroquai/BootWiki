
<h1>My Account</h1>

<?php if (BootWiki::hasMessage()) : ?>
<div class="bg-danger" id="login_error"><?=BootWiki::getMessage()?></div>
<?php endif; ?>

<h2>Change Account</h2>

<form action="" method="post">
    <div class="form-group">
        <label>Username</label>
        <input name="username" type="text" disabled="disabled" 
            class="form-control"
            value="<?=$this->account->username?>" />
    </div>
    <div class="form-group">
        <label>Display Name</label>
        <input name="displayname" type="text" 
            class="form-control"
            value="<?=$this->account->displayname?>" />
    </div>
    <div class="form-group">
        <label>Profile (author link)</label>
        <input name="profile" type="text" 
            class="form-control"
            value="<?=$this->account->profile?>" />
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
</form>

<h2>Change Password</h2>

<form action="" method="post">
    <div class="form-group">
        <label>Password</label>
        <input name="password" type="password" 
            class="form-control"
            value="" />
    </div>
    <div class="form-group">
        <label>Confirme Password</label>
        <input name="password_confirm" type="password" 
            class="form-control"
            value="" />
    </div>
    <button class="btn btn-primary" type="submit">Change</button>
</form>
<?php BootWiki::clearMessage(); ?>