<div>
    <?php if (empty($this->items)) : ?>
    <p>A pesquisa não devolver resultados. Por favor tente outras palavras.</p>
    <?php else: ?>
    <div class="row">
        <?php foreach ($this->items as $item) { ?>
        <div class="pull-left col-xs-3 col-md-3">
            <a href="<?=DATAURL.'/'.basename($item->src)?>" class="thumbnail">
                <img src="<?=DATAURL.'/'.basename($item->src)?>"/>
            </a>
        </div>
        <?php } ?>
    </div>
    <?php endif; ?>
</div>