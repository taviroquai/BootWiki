<div>
    <?php if (empty($this->items)) : ?>
    <p>Your search did not returned any images. Please try other keywords.</p>
    <?php else: ?>
        <?php foreach ($this->items as $item) { ?>
        <div class="pull-left wiki-thumb">
            <a href="<?=DATAURL.'/'.basename($item->src)?>">
                <img src="<?=DATAURL.'/'.basename($item->src)?>"/>
            </a>
        </div>
        <?php } ?>
    <?php endif; ?>
</div>