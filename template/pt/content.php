<div>
    
    <h1 itemprop="headline" id="content_title"><a href="<?=BASEURL.'/'.$this->alias?>"><?=$this->title?></a>
        <? if (BootWiki::getLoggedAccount()) : ?>
        &nbsp;<a class="wiki-edit-link" href="<?=BASEURL.'/edit/'.$this->alias?>">alterar</a>
        <? endif; ?>
    </h1>
    
    <p id="content_meta">
        <em itemprop="lastReviewed" class="label"><?=$this->date?></em> 
        <span class="label label-important"> by <?=$this->author?></span>
        <span class="badge badge-info"><?=$this->visits?> visitas</span>
        <meta itemprop="interactionCount" content="<?=$this->visits?> UserPageVisits">
        <meta itemprop="author" content="<?=$this->author?>">
    </p>
    <div itemprop="description" id="content_intro"><?=$this->intro?></div>
    <p itemprop="primaryImageOfPage" itemscope itemtype="ImageObject" id="content_image" style="text-align: center;"><?=$this->image->html()?></p>
    <div itemprop="text" id="content_body"><?=$this->html?></div>
    <p class="well" itemprop="keywords"><?=$this->keywordsToLabels()?></p>
</div>

<? if (!empty($this->versions)) { ?>
<div class="clearfix"></div>
<hr />
<h4>Versões</h4>
<ul>
    <? foreach ($this->versions as $item) { ?>
    <li>
        <a href="<?=BASEURL.'/edit/'.$this->alias.'/'.$item->id?>"><?=$item->title?></a> 
        <span class="label wiki-label-min"><?=$item->date?></span>
    </li>
    <? } ?>
</div>
<? } ?>