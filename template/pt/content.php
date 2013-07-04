<div>
    
    <h1 itemprop="headline" id="content_title"><a href="<?=BASEURL.'/'.$this->content->alias?>"><?=$this->content->title?></a>
        <? if (BootWiki::getLoggedAccount()) : ?>
        &nbsp;<a class="wiki-edit-link" href="<?=BASEURL.'/edit/'.$this->content->alias?>">alterar</a>
        <? endif; ?>
    </h1>
    
    <p id="content_meta">
        <em itemprop="lastReviewed" class="label"><?=$this->content->date?></em> 
        <? if (is_object($this->content->author) && !empty($this->content->author->profile)) : ?>
            <a rel="author" href="<?=$this->content->author->profile?>" title="<?=$this->content->author?>">
                <span class="label label-important"> por <?=$this->content->author?></span>
            </a>
        <? else: ?>
            <span class="label label-important"> por <?=$this->content->author?></span>
        <? endif; ?>
        <span class="badge badge-info"><?=$this->content->visits?> visitas</span>
        <meta itemprop="interactionCount" content="<?=$this->content->visits?> UserPageVisits">
        <meta itemprop="author" content="<?=$this->content->author?>" 
              <? if (is_object($this->content->author)) { ?>
              rel="author" href="<?=$this->content->author->profile?>"
              <? } ?>>
    </p>
    <span itemprop="primaryImageOfPage" itemscope itemtype="ImageObject" 
         id="content_image" class="pull-right" style="text-align: center;">
                <?=!empty($this->content->image) ? $this->content->image->html($this->content->title) : ''?></span>
    <div itemprop="description" id="content_intro"><?=$this->content->intro?></div>
    <div itemprop="text" id="content_body"><?=$this->content->html?></div>
    <div class="clearfix"></div>
    <div class="pull-right">
        <!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style">
        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
        <a class="addthis_button_tweet"></a>
        <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
        </div>
        <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51d4bb04702edcc6"></script>
        <!-- AddThis Button END -->
    </div>
    <div class="clearfix"></div>
    <p class="well" itemprop="keywords"><?=$this->content->keywordsToLabels()?></p>
</div>

<? if (!empty($this->versions)) { ?>
<div class="clearfix"></div>
<hr />
<h4>Versões</h4>
<ul>
    <? foreach ($this->versions as $item) { ?>
    <li>
        <a href="<?=BASEURL.'/edit/'.$this->content->alias.'/'.$item->id?>"><?=$item->title?></a> 
        <span class="label wiki-label-min"><?=$item->date?></span>
    </li>
    <? } ?>
</div>
<? } ?>