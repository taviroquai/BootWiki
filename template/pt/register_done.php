<div>
    <h1>Registo Completo!</h1>
    <p>Obrigado por se registar. Foi enviado um email para confirmar o seu registo.</p>
    
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