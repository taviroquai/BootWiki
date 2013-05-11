<div>
    <h1>Register Complete!</h1>
    <p>Thank you for registering.</p>
    <? if (SEND_MAILS) { ?>
    <p>An email was sent with your login details.</p>
    <? } ?>
    
    <? if (!empty($this->message)) : ?>
    <div class="control-group error" id="login_error">
      <div class="controls">
        <span class="help-inline"><?=$this->message?></span>
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
</div>