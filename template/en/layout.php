<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# blog: http://ogp.me/ns/blog#">
  <head>
    <meta charset="utf-8">
    <title><?=$this->title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:description" name="description" content="<?=$this->description?>">
    <meta name="twitter:description" content="<?=$this->description?>">
    <meta name="keywords" content="<?=$this->keywords?>">
    <?php if (is_object($this->author)) : ?>
    <meta property="article:author" name="author" content="<?=$this->author->username?>">
    <?php else: ?>
    <meta property="article:author" name="author" content="<?=$this->author?>">
    <?php endif; ?>
    <meta name="twitter:creator" content="<?=$this->author?>">
    <meta name="twitter:card" content="summary">
    <meta property="og:type" content="article" /> 
    <meta property="og:title" name="twitter:title" content="<?=$this->title?>" />
    <?php if (!empty($this->main_image)) { ?>
    <meta property="og:image" name="twitter:image" content="<?=implode('', BootWiki::parseRoute())?><?=$this->main_image?>" />
    <link href="<?=$this->main_image?>" rel="image_src">
    <?php } ?>
    <base href="<?=BASEURL?>/">

    <!-- Le styles -->
    <link href="http://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="web/css/bootstrap.css">
    <link rel="stylesheet" href="web/bootstrap-fileupload/bootstrap-fileupload.min.css">
    <link rel="stylesheet" href="web/css/bootstrap-wysihtml5-0.0.2.css">
    <link rel="stylesheet" href="web/css/bootstrap-responsive.css">
    <link rel="stylesheet" href="web/css/wiki.css">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="web/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="web/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="web/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="web/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="web/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="web/ico/favicon.png">
    
    <!-- Include the badass jQuery -->
    <script src="web/js/jquery-1.7.1.min.js"></script>
  </head>

  <body itemscope itemtype="http://schema.org/WebPage">

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" style="padding: 0" href="<?=BASEURL?>">
            <span itemprop="logo" itemscope itemtype="http://schema.org/ImageObject">
                <img itemprop="contentURL" src="<?=ORGANIZATION_LOGO?>" alt="<?=$this->organization_name?>" title="<?=$this->organization_name?>" />
            </span>
            <meta itemprop="name" content="<?=$this->organization_name?>">
          </a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
                
                <?php if (!empty($this->idioms)) {?>
                    <?php foreach ($this->idioms as $item) { ?>
                        <a class="navbar-link" href="<?=$item->href()?>">
                          <?=$item->html()?>
                        </a>
                    <?php } ?>
                <?php } ?>
                
                <?php if (!empty($this->logged_username)) : ?>
                    Logged in as <a href="<?=BASEURL.'/mod/myaccount'?>" class="navbar-link"><?=$this->logged_username?></a>&nbsp;
                    <a href="<?=$this->logout_link->href?>" class="navbar-link">Logout</a>
                <?php else: ?>
                    <a href="<?=$this->login_link->href?>" class="navbar-link">Login</a>
                    <?php if (REGISTER_ALLOWED) { ?>
                        <a href="<?=$this->register_link->href?>" class="navbar-link">Register</a>
                    <?php } ?>
                <?php endif; ?>
                
            </p>
            <ul class="nav">
                <?php foreach ($this->top_menu as $item) { ?>
                <li<?php if (!empty($item->class)) {?> class="<?=$item->class?>"<?php } ?>>
                    <a href="<?=$item->href?>"><?=$item?></a>
                </li>
                <?php } ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
            
            <div class="well sidebar-nav">
                <div class="wiki-search">
                    <div class="nav-header">Search...</div>
                    <form class="form-search" action="search">
                        <div class="input-append">
                            <input class="span7" type="text" name="q"
                                   value="<?=empty($this->query) ? '' : $this->query?>">
                            <button class="btn" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
            </div><!--/.well -->
            
            <?php if (!empty($this->recent)) { ?>
                <div class="well sidebar-nav">
                  <ul class="nav nav-list">
                    <li class="nav-header">Recent...</li>
                    <?php foreach ($this->recent as $item) { ?>
                      <li<?php if (!empty($item->class)) {?> class="<?=$item->class?>"<?php } ?>>
                          <a href="<?=$item->href?>"><?=$item?> <span class="label wiki-date-min"><?=$item->date?></span></a>
                      </li>
                    <?php } ?>
                  </ul>
                </div><!--/.well -->
            <?php } ?>
                
            <?php if (!empty($this->popular)) { ?>
                <div class="well sidebar-nav">
                  <ul class="nav nav-list">
                    <li class="nav-header">Most popular...</li>
                    <?php foreach ($this->popular as $item) { ?>
                      <li<?php if (!empty($item->class)) {?> class="<?=$item->class?>"<?php } ?>>
                          <a href="<?=$item->href?>"><?=$item?> <span class="badge badge-info wiki-visits-min"><?=(int)$item->visits?></span></a>
                      </li>
                    <?php } ?>
                  </ul>
                </div><!--/.well -->
            <?php } ?>
                
            <?php if (!empty($this->unpublished)) { ?>
                <div class="well sidebar-nav">
                  <ul id="wiki-unpublished" class="nav nav-list">
                    <li class="nav-header">Unpublished...</li>
                    <?php foreach ($this->unpublished as $item) { ?>
                      <li<?php if (!empty($item->class)) {?> class="<?=$item->class?>"<?php } ?>>
                          <a href="<?=$item->href?>"><?=$item?></a>
                      </li>
                    <?php } ?>
                  </ul>
                </div><!--/.well -->
            <?php } ?>
                                
        </div><!--/span-->
        <div class="span9">
            <?php if (!empty($this->featured)) { ?>
                <?php $content = reset($this->featured); ?>
                <div class="hero-unit">
                  <h1><a href="<?=BASEURL.'/'.$content->alias?>"><?=$content->title?></a></h1>
                  <div class="row">
                      <div class="span8">
                        <img class="media-object wiki-img-featured-big" 
                            src="<?=$content->image->getUrl()?>" alt="<?=$content->title?>" />
                      </div>
                      <div class="span4"><?=$content->intro?></div>
                  </div>
                  <div class="clearfix"></div>
                  <p>
                      <a href="<?=BASEURL.'/'.$content->alias?>" 
                        class="btn btn-primary pull-right"><?=$content->more_link?></a>
                        <?php if (is_object($content->author) && !empty($content->author->profile)) : ?>
                            <a class="pull-right" rel="author" href="<?=$content->author->profile?>" title="<?=$content->author?>">by <?=$content->author?>&nbsp;</a>
                        <?php else: ?>
                            <span class="pull-right"> by <?=$content->author?>&nbsp;</span>
                        <?php endif; ?>
                  </p>
                </div>
            <?php } ?>
            <?php if (!empty($this->featured) && count($this->featured) > 1) { ?>
            <div class="row-fluid">
                <?php for ($i = 1; $i < count($this->featured); $i++) {
                    $content = $this->featured[$i];
                    ?>
                <div class="span<?=round(12/(count($this->featured)-1))?>">
                  <h2><a href="<?=BASEURL.'/'.$content->alias?>"><?=$content->title?></a></h2>
                  <img class="media-object wiki-media-object-img pull-left" 
                       src="<?=$content->image->getThumbUrl()?>" alt="<?=$content->title?>" />
                  <div><?=$content->intro?></div>
                  <div class="clearfix"></div>
                  <a href="<?=BASEURL.'/'.$content->alias?>" class="btn btn-mini pull-right"><?=$content->more_link?></a>
                </div><!--/span-->
              <?php } ?>
            </div><!--/row-->
            <hr />
            <?php } ?>
            <?php if (!empty($this->html)) { ?>
                <div class="row-fluid">
                  <div class="span12">
                    <?=$this->html?>
                  </div><!--/span-->
                </div><!--/row-->
          <?php } ?>
        </div><!--/span-->
      </div><!--/row-->
    </div><!--/.fluid-container-->
    
    <footer class="navbar navbar-fixed-bottom">
        <div class="navbar-inner">
            <div class="pull-right">BootWiki &copy; Marco Afonso 2013</div>
        </div>
    </footer>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="web/js/wysihtml5-0.3.0_rc2.min.js"></script>
    <script src="web/js/bootstrap.min.js"></script>
    <script src="web/js/bootstrap-wysihtml5-0.0.2.js"></script>
    
    <!-- Include google analytics if exists -->
    <?php if (file_exists(TEMPLATEPATH.'/'.BootWiki::getIdiom().'/ga.php')) {
        include TEMPLATEPATH.'/'.BootWiki::getIdiom().'/ga.php';
    } ?>
    
  </body>
</html>