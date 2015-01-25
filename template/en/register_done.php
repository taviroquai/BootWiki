<div>
    <h1>Register Complete!</h1>
    <p>Thank you for registering.</p>
    <?php if (SEND_MAILS) { ?>
    <p>An email was sent with your login details.</p>
    <?php } ?>
    
    <?php if (!empty($this->message)) : ?>
    <div class="bg-danger" id="login_error"><?=$this->message?></div>
    <script>
        jQuery(function($) {
            for(i=0;i<3;i++) {
                $('#login_error').fadeTo('fast', 0).fadeTo('fast', 1);
            }
        });
    </script>
    <?php endif; ?>
</div>