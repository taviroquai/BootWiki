
<h1>Descarregar</h1>
<p>O descarregamento começa dentro de 3 segundos...</p>
<script>
    jQuery(function($) {
        setTimeout(function() {
            //window.location.href = '<?=$this->href?>';
            window.open('<?=$this->href?>');
        }, 3000);
    });
</script>