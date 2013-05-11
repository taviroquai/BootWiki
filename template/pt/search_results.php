<div>
    <h1>Resultados da Pesquisa</h1>
    <? if (empty($this->items)) : ?>
    <p>A sua pesquisa não devolveu resultados. Por favor pesquise com outras palavras-chave.</p>
    <? else: ?>
    <ul class="media-list">
        <? foreach ($this->items as $item) { ?>
        <li class="media">
          <a class="pull-left" href="<?=BASEURL.'/'.$this->alias?>">
            <img class="media-object wiki-media-object-img" src="<?=BASEURL?>/web/data/<?=$item->image->src?>" />
          </a>
          <div class="media-body">
            <h4 class="media-heading">
                <a href="<?=BASEURL.'/'.$item->alias?>"><?=$item->title?></a>
            </h4>
            <?=$item->intro?>
          </div>
          <hr />
          <div class="clearfix"></div>
        </li>
        <? } ?>
    </ul>
    <? endif; ?>
</div>