<div>
    <h1>Resultados da Pesquisa</h1>
    <?php if (empty($this->items)) : ?>
    <p>A pesquisa não devolver resultados. Tente outras palavras-chave.</p>
    <?php else: ?>
    <ul class="media-list">
        <?php foreach ($this->items as $item) { ?>
        <li class="media">
          <div class="media-left col-sm-2 col-md-2">
            <a href="<?=BASEURL.'/'.$this->alias?>" class="thumbnail">
              <img class="media-object" src="<?=$item->image->getThumbUrl()?>" />
            </a>
          </div>
          <div class="media-body">
            <h4 class="media-heading">
                <a href="<?=BASEURL.'/'.$item->alias?>"><?=$item->title?></a>
            </h4>
            <p><?=$item->intro?></p>
          </div>
          <hr />
          <div class="clearfix"></div>
        </li>
        <?php } ?>
    </ul>
    <?php endif; ?>
</div>