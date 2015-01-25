<div>
    <h1>Registo Completo!</h1>
    <p>Obrigado por se registar.</p>
    <?php if (SEND_MAILS) { ?>
    <p>Foi enviado um email com os detalhes para iniciar sessão.</p>
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